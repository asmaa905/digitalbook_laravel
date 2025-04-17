<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use App\Models\PublishingHouse;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $publishingHouses = PublishingHouse::all();
        return view('auth.register', compact('publishingHouses'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate basic user information
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'account_type' => ['required', 'in:Reader,Publisher'],
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone'=>$request->phone,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'role' => $request->account_type,
        ]);

        // If publisher, validate and create publisher record
        if ($request->account_type === 'Publisher') {
            $request->validate([
                'identity' => ['required', 'file', 'mimes:pdf', 'max:2048'],
                'job_title' => ['required', 'string', 'max:255'],
                'publishing_house_id' => ['nullable', 'exists:publishing_houses,id'],
            ]);

            $identityPath = $request->file('identity')->store('identity_documents', 'public');

            Publisher::create([
                'user_id' => $user->id,
                'identity' => $identityPath,
                'job_title' => $request->job_title,
                'publishing_house_id' => $request->publishing_house_id,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return $this->redirectTo(Auth::user()->role);

    }

protected function redirectTo($role): RedirectResponse
{
    switch ($role) {
        case 'Admin':
            return redirect()->route('admin.dashboard');
        case 'Publisher':
            return redirect()->route('publisher.books.index');
        case 'Reader':
            return redirect()->route('books.reader.index');
        default:
            return redirect()->route('user.home');
    }
}
}