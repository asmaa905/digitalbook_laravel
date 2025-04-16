<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Publisher;
use App\Models\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class UsersController extends BaseController
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('publisher')->latest()->paginate(10);
        return view('Admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $publishingHouses = PublishingHouse::all();
        return view('Admin.users.create', compact('publishingHouses'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits_between:10,11', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Admin,Publisher,Reader'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'job_title' => ['required_if:role,Publisher', 'nullable', 'string', 'max:255'],
            'identity_document' => ['required_if:role,Publisher', 'nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:2048'],
            'publishing_house_id' => ['required_if:role,Publisher', 'nullable', 'exists:publishing_houses,id'],
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image = $path;
            $user->save();
        }

        // Create publisher record if role is Publisher
        if ($request->role === 'Publisher') {
            $publisher = new Publisher();
            $publisher->user_id = $user->id;
            $publisher->job_title = $request->job_title;
            $publisher->publishing_house_id = $request->publishing_house_id;

            // Handle identity document upload
            if ($request->hasFile('identity_document')) {
                $path = $request->file('identity_document')->store('identity_documents', 'public');
                $publisher->identity = $path;
            }

            $publisher->save();
        }

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('Admin.users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $publishingHouses = PublishingHouse::all();
        return view('Admin.users.edit', compact('user', 'publishingHouses'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'numeric', 'digits_between:10,11', 'unique:users,phone,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Admin,Publisher,Reader'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'job_title' => ['required_if:role,Publisher', 'nullable', 'string', 'max:255'],
            'identity_document' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:2048'],
            'publishing_house_id' => ['required_if:role,Publisher', 'nullable', 'exists:publishing_houses,id'],
        ]);

        // Update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image = $path;
        }

        $user->save();

        // Handle publisher record
        if ($request->role === 'Publisher') {
            $publisher = $user->publisher ?? new Publisher();
            $publisher->user_id = $user->id;
            $publisher->job_title = $request->job_title;
            $publisher->publishing_house_id = $request->publishing_house_id;

            // Handle identity document upload
            if ($request->hasFile('identity_document')) {
                // Delete old document if exists
                if ($publisher->identity && Storage::disk('public')->exists($publisher->identity)) {
                    Storage::disk('public')->delete($publisher->identity);
                }
                
                $path = $request->file('identity_document')->store('identity_documents', 'public');
                $publisher->identity = $path;
            }

            $publisher->save();
        } elseif ($user->publisher) {
            // If role changed from Publisher to something else, delete publisher record
            $user->publisher->delete();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Delete profile image if exists
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        // Delete identity document if exists
        if ($user->publisher && $user->publisher->identity && Storage::disk('public')->exists($user->publisher->identity)) {
            Storage::disk('public')->delete($user->publisher->identity);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}