<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Invitation;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $roles = Role::where('name', 'Cleaner')->get();
        $invitationRoles = collect(); // Roles available for invitation generation
        $users = collect();
        $allUsers = collect();
        $pendingInvitations = collect();

        if ($user->hasRole('Super Admin')) {
            $users = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['Admin', 'Cleaner']);
            })->latest()->get();
            $allUsers = User::whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['Admin', 'Cleaner', 'Super Admin']);
            })->orWhereDoesntHave('roles')->latest()->get();
            $roles = Role::all();
            $invitationRoles = collect(['Cleaner', 'Admin']); // Super Admin can invite Cleaners and Admins
            $pendingInvitations = Invitation::where('expires_at', '>', now())->latest()->get();
        } elseif ($user->hasRole('Admin')) {
            // Admin only sees users who are already Cleaners
            $users = User::role('Cleaner')->latest()->get();
            $invitationRoles = collect(['Cleaner']); // Admin can only invite Cleaners
            $pendingInvitations = Invitation::where('inviter_id', $user->id)
                ->where('expires_at', '>', now())
                ->latest()->get();
        }

        return view('roles.assignment', compact('users', 'roles', 'pendingInvitations', 'invitationRoles', 'allUsers'));
    }

    /**
     * Invite/Add a cleaner directly.
     */
    public function invite(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:255',
        ]);

        $password = \Illuminate\Support\Str::random(12);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'role' => 'Admin', // Cleaners are stored as Admin in the database role column
        ]);

        // If current user is Admin, attach the new cleaner to them
        if (auth()->user()->hasRole('Admin')) {
            auth()->user()->managedCleaners()->attach($user->id);
        }

        // Check if user already has a role
        if ($user->roles()->exists()) {
            return redirect()->route('role-assignment.index')->with('error', 'This user already has a role assigned.');
        }

        $user->assignRole('Cleaner');

        // In a real app, send email here with $password

        return redirect()->route('role-assignment.index')->with('success', 'Cleaner ' . $user->first_name . ' invited and assigned role successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::where('id', $validData['user_id'])->first();
        if (!$user) {
            return redirect('/role-assignment')->with('error', 'User does not exist.');
        }

        $role = Role::where('id', $validData['role_id'])->first();
        if (!$role) {
            return redirect('/role-assignment')->with('error', 'Role does not exist.');
        }

        // Security check for Admin
        if (Auth::user()->hasRole('Admin')) {
            if ($role->name !== 'Cleaner') {
                return redirect('/role-assignment')->with('error', 'You can only assign the Cleaner role.');
            }
            if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
                return redirect('/role-assignment')->with('error', 'You cannot modify Super Admin or Admin users.');
            }
        }

        // Check if user already has a role (Super Admin can override)
        if ($user->roles()->exists() && !Auth::user()->hasRole('Super Admin')) {
            return redirect('/role-assignment')->with('error', 'This user already has a role assigned and cannot be reassigned.');
        }

        if ($user->syncRoles([$role->name])) {
            // Sync database role column
            if (in_array($role->name, ['Admin', 'Cleaner'])) {
                // Attach to Admin if applicable
                if ($role->name === 'Cleaner' && Auth::user()->hasRole('Admin')) {
                    Auth::user()->managedCleaners()->syncWithoutDetaching([$user->id]);
                }
                $user->role = 'Admin';
                $user->save();
            }
            return redirect('/role-assignment')->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' was given the role ' . $role->name . ' successfully.');
        }
        return redirect('/role-assignment')->with('error', 'User ' . $user->first_name . ' ' . $user->last_name . ' could NOT be given the role ' . $role->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Role $role)
    {
        // Security check for Admin
        if (Auth::user()->hasRole('Admin')) {
            if ($role->name !== 'Cleaner') {
                return redirect('/role-assignment')->with('error', 'You can only remove the Cleaner role.');
            }
            if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
                return redirect('/role-assignment')->with('error', 'You cannot modify Super Admin or Admin users.');
            }
        }

        if ($user->removeRole($role->name)) {
            return redirect('/role-assignment')->with('success', 'The role ' . $role->name . ' was removed from User ' . $user->first_name . ' ' . $user->last_name . ' successfully.');
        }

        return redirect('/role-assignment')->with('error', 'The role ' . $role->name . ' was removed from User ' . $user->first_name . ' ' . $user->last_name . '.');
    }

    /**
     * Get properties for a user (AJAX).
     */
    public function getProperties(User $user)
    {
        $authUser = Auth::user();
        $isSuperAdmin = $authUser->hasRole('Super Admin');
        $isAdmin = $user->hasRole('Admin');
        $isCleaner = $user->hasRole('Cleaner');
        
        $ownedProperties = collect();
        $staffAssignments = collect();

        if ($isAdmin) {
            // Admins can only be OWNERS (via user_id column)
            $ownedProperties = Property::where('user_id', $user->id)->get();
        }

        if ($isCleaner) {
            // Cleaners can only be STAFF (via pivot table with role_type = 'cleaner')
            // Note: Even if an Admin was accidentally assigned as staff, we won't show it here for strict enforcement.
            $staffAssignments = $user->assignedProperties()
                ->where('role_type', 'cleaner')
                ->get();
        }

        // Available properties depend on who's asking
        if ($isSuperAdmin) {
            $allProperties = Property::with('user:id,first_name,last_name')->get();
        } else {
            // Admin can only see properties they own
            $allProperties = Property::where('user_id', $authUser->id)->with('user:id,first_name,last_name')->get();
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'is_admin' => $isAdmin,
                'is_cleaner' => $isCleaner,
            ],
            'owned' => $ownedProperties->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'address' => $p->address,
                'city' => $p->city,
            ]),
            'staff' => $staffAssignments->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'address' => $p->address,
                'city' => $p->city,
            ]),
            'available' => $allProperties->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'address' => $p->address,
                'city' => $p->city,
                'owner_id' => $p->user_id,
                'owner_name' => $p->user ? $p->user->first_name . ' ' . $p->user->last_name : 'Unassigned',
            ]),
        ]);
    }

    /**
     * Sync property assignments for a user (AJAX).
     */
    public function syncProperties(Request $request, User $user)
    {
        $authUser = Auth::user();
        $isSuperAdmin = $authUser->hasRole('Super Admin');
        $type = $request->input('type', 'staff'); // 'ownership' or 'staff'

        $request->validate([
            'property_ids' => 'array',
            'property_ids.*' => 'integer|exists:properties,id',
            'type' => 'required|in:ownership,staff',
        ]);

        $propertyIds = $request->input('property_ids', []);

        if ($type === 'ownership') {
            // STRICT ENFORCEMENT: Only Admins can be set as Owners
            if (!$user->hasRole('Admin')) {
                return response()->json(['success' => false, 'message' => 'Ownership can only be assigned to users with the Admin role. Cleaners cannot own properties.'], 422);
            }
            if (!$isSuperAdmin) {
                return response()->json(['success' => false, 'message' => 'Only Super Admin can change property ownership.'], 403);
            }

            $forceOverwrite = $request->boolean('force', false);

            // Detect conflicts
            $conflicts = Property::whereIn('id', $propertyIds)
                ->where(function($q) use ($user, $authUser) {
                    $q->where('user_id', '!=', $user->id)
                      ->where('user_id', '!=', $authUser->id);
                })
                ->whereNotNull('user_id')
                ->with('user:id,first_name,last_name')
                ->get();

            if ($conflicts->isNotEmpty() && !$forceOverwrite) {
                return response()->json([
                    'success' => false,
                    'conflicts' => true,
                    'message' => 'Some properties are already owned by other admins.',
                    'conflict_details' => $conflicts->map(fn($p) => [
                        'id' => $p->id,
                        'name' => $p->name,
                        'current_owner' => $p->user ? $p->user->first_name . ' ' . $p->user->last_name : 'System',
                    ]),
                ]);
            }

            Property::whereIn('id', $propertyIds)->update(['user_id' => $user->id]);

            $currentOwned = Property::where('user_id', $user->id)->pluck('id')->toArray();
            $toRelease = array_diff($currentOwned, $propertyIds);
            if (!empty($toRelease)) {
                Property::whereIn('id', $toRelease)->update(['user_id' => $authUser->id]);
            }

            // Sync tracked owner status in pivot for legacy purposes
            $syncData = [];
            foreach ($propertyIds as $pid) {
                $syncData[$pid] = ['role_type' => 'admin'];
            }
            $user->assignedProperties()->where('role_type', 'admin')->sync($syncData);

        } else {
            // STAFF (CLEANER) ASSIGNMENT
            // STRICT ENFORCEMENT: Admins cannot be set as Cleaning Staff
            if ($user->hasRole('Admin')) {
                return response()->json(['success' => false, 'message' => 'Admins cannot be assigned as cleaning staff. They are restricted to property management.'], 422);
            }

            if (!$isSuperAdmin) {
                $ownedIds = Property::where('user_id', $authUser->id)->pluck('id')->toArray();
                $propertyIds = array_intersect($propertyIds, $ownedIds);
                
                $otherAssignments = $user->assignedProperties()
                    ->where('role_type', 'cleaner')
                    ->whereNotIn('properties.id', $ownedIds)
                    ->pluck('properties.id')->toArray();
                $propertyIds = array_merge($propertyIds, $otherAssignments);
            }

            $syncData = [];
            foreach ($propertyIds as $pid) {
                $syncData[$pid] = ['role_type' => 'cleaner'];
            }
            
            $user->assignedProperties()->where('role_type', 'cleaner')->sync($syncData);
        }

        return response()->json(['success' => true, 'message' => 'Assignments updated successfully.']);
    }
}
