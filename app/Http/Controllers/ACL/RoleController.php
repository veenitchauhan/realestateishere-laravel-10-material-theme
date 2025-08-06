<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function index() {
        $data['roles'] = Role::all();
        $data['permissions'] = Permission::all(); // Assuming you want to show permissions as well
        return view('ACL.roles.index', $data);
    }

    function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|min:3|max:50|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    function edit($id) {
        $role = Role::findOrFail($id);
        $data['role'] = $role;
        $data['permissions'] = Permission::all();
        return view('ACL.roles.edit', $data);
    }

    function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|min:3|max:50|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->back()->with('success', "Role <b>$role->name</b> updated successfully.");
    }

    function destroy($id) {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success', "Role <b>$role->name</b> deleted successfully.");
    }
}
