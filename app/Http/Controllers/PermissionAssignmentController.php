<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();

        $permissions = Permission::all();
        return view('permissions.assignment', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'role_id' => 'required',
            'permissions' => 'nullable|array'
        ]);

        $permissions = [];

        if(isset($validData['permissions'])){
            $permission_ids = array_values($validData['permissions']);
            $permissionList = Permission::whereIn('id', $permission_ids)->get();
            foreach($permissionList as $key => $permission){
                array_push($permissions, $permission->name);
            }
        }

        $role = Role::find($validData['role_id']);
        if(! $role){
            return redirect('/permission-assignment')->with('error', 'Role ID does not exist.');
        }

        if($role->syncPermissions($permissions)){
            return redirect('/permission-assignment')->with('success', 'Permission(s) assigned successfully.');
        }

        return redirect('/permission-assignment')->with('error', 'Permissions assignment failed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validData = $request->validate([
            'role_id' => 'required',
            'permission_id' => 'required'
        ]);

        $role = Role::find($validData['role_id']);
        $permission = Permission::find($validData['permission_id']);
        if($role && $role->revokePermissionTo($permission->name)){
            return redirect('/permission-assignment')->with('success', 'Permission{'.$permission->name.'} removed from role {'.$role->name.'} successfully.');
        }
        return redirect('/permission-assignment')->with('error', 'Permission deletion failed.');
    }
}
