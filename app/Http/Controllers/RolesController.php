<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where('name', '!=', 'Super Admin')->get();
        }
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required'
        ]);

        if(Role::where('name', $validData['name'])->exists()){
            return redirect('/roles')->with('error', 'Role already exists in the database.');
        }

        if(Role::create(['name' => $validData['name']])){
            return redirect('/roles')->with('success', 'Role created successfully.');
        }
        return redirect('/roles')->with('error', 'Role creation failed.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validData = $request->validate([
            'name' => 'required'
        ]);

        $role->name = $validData['name'];
        if($role->save()){
            return redirect('/roles')->with('success', 'Role updated successfully.');
        }

        return redirect('/roles')->with('error', 'Role update failed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role->delete()){
            return redirect('/roles')->with('success', 'Role deleted successfully.');
        }
        return redirect('/roles')->with('error', 'Role deletion failed.');
    }

    /**
     * Get list of permissions for this role in JSON format
     */
    public function getPermissions(Role $role){
        $assigned_permissions = [];
        if(count($role->permissions) > 0){
            $assigned_permissions = $role->permissions->pluck('id');
        }
        $permissions = Permission::all()->unique()->map->only('id', 'name');

        return response()->json(['all_permissions' => $permissions, 'assigned_permissions' => $assigned_permissions]);
    }
}
