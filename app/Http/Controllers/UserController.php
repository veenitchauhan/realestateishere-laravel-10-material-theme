<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('ACL.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('ACL.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'location' => $request->location,
            'about' => $request->about,
        ]);

        if ($request->has('roles')) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('ACL.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('ACL.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'about' => $request->about,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Sync roles
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
