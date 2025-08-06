<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function index() {
        $data['permissions'] = Permission::all();
        return view('ACL.permissions.index', $data);
    }

    function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50|unique:permissions,name',
        ]);

        if ($validator->passes()) {
            Permission::create([
                'name' => $request->name,
            ]);
            return redirect()->back()->with('success', 'Permission created successfully.');
        }else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    function destroy($id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with('success', "Permission <b>$permission->name</b> deleted successfully.");
    }
}
