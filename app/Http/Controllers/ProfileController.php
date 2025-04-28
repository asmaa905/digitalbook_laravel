<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user()->load('publisher'),
        ]);
    }
    
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user()->load('publisher'),
        ]);
    }
    /**
     * Update the user's profile information.
     */
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // Update basic fields
    $user->fill($request->except(['image', 'identity_document']));
    
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Handle profile image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        
        $path = $request->file('image')->store('profile_images', 'public');
        $user->image = $path;
    }

    $user->save();

    // Handle publisher-specific fields
    if ($user->role === 'Publisher') {
        $publisher = $user->publisher ?? new \App\Models\Publisher();
        $publisher->user_id = $user->id;
        $publisher->job_title = $request->job_title;
        $publisher->publishing_house_id = $request->publishing_house_id;

        // Handle identity document upload
        if ($request->hasFile('identity_document')) {
            // Delete old document if exists
            if ($publisher->identity_document && Storage::disk('public')->exists($publisher->identity_document)) {
                Storage::disk('public')->delete($publisher->identity);
            }
            
            $path = $request->file('identity_document')->store('identity_documents', 'public');
            $publisher->identity = $path;
        }
        $publisher->identity = $publisher->identity ?? ''; 

        $publisher->save();
    }

    return Redirect::route('profile.show')->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function security()
{
    return view('profile.security', [
        'user' => auth()->user()
    ]);
}
}