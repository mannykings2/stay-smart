<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            $users = User::latest()->get();
            $roles = Role::all();
        } else {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Super Admin');
            })
            ->get();
            $roles = Role::where('name', '!=', 'Super Admin')->get();
        }

        return view('roles.assignment', compact('users', 'roles'));
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
        if(! $user){
            return redirect('/role-assignment')->with('error', 'User does not exist.');
        }

        $role = Role::where('id', $validData['role_id'])->first();
        if(! $role){
            return redirect('/role-assignment')->with('error', 'Role does not exist.');
        }

        if($user->syncRoles([$role->name])){
            return redirect('/role-assignment')->with('success', 'User {'.$user->username.'} was given the role {'.$role->name.'} successfully.');
        }
        return redirect('/role-assignment')->with('error', 'User {'.$user->username.'} could NOT be given the role {'.$role->name.'}');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Role $role)
    {
        if($user->removeRole($role->name)){
            return redirect('/role-assignment')->with('success', 'The role {'.$role->name.'} was removed from User {'.$user->username.'} successfully.');
        }

        return redirect('/role-assignment')->with('error', 'The role {'.$role->name.'} was removed from User {'.$user->username.'}.');
    }
}
