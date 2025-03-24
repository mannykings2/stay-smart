<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
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

        if(Permission::where('name', $validData['name'])->exists()){
            return redirect('/permissions')->with('error', 'Permission already exists in the database.');
        }

        if(Permission::create(['name' => $validData['name']])){
            return redirect('/permissions')->with('success', 'Permission created successfully.');
        }
        return redirect('/permissions')->with('error', 'Permission creation failed.');
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
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validData = $request->validate([
            'name' => 'required'
        ]);

        $permission->name = $validData['name'];
        if($permission->save()){
            return redirect('/permissions')->with('success', 'Permission updated successfully.');
        }
        return redirect('/permissions')->with('error', 'Permission update failed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        if($permission->delete()){
            return redirect('/permissions')->with('success', 'Permission deleted successfully.');
        }
        return redirect('/permissions')->with('error', 'Permission deletion failed.');
    }
}
