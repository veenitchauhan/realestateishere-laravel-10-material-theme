<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.profile');
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        // Validate profile fields
        $attributes = $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'max:10',
            'about' => 'max:150',
            'location' => ''
        ]);

        // Validate password fields only if current_password is provided
        if ($request->filled('current_password')) {
            $passwordRules = $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
                'new_password_confirmation' => 'required'
            ]);

            // Check if current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            // Update the password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        // Update profile information
        $user->update($attributes);
        
        $message = 'Profile successfully updated.';
        if ($request->filled('current_password')) {
            $message = 'Profile and password successfully updated.';
        }
        
        return back()->withStatus($message);
    }
}
