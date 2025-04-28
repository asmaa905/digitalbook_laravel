<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        // Only allow admin to edit their own profile or non-admin profiles
        if ($user->role === 'admin' && $user->id !== auth()->id()) {
            abort(403);
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Only allow admin to edit their own profile or non-admin profiles
        if ($user->role === 'admin' && $user->id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
}
