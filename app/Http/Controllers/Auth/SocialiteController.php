<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PublishingHouse;
use Illuminate\Auth\Events\Registered;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Exception;

class SocialiteController extends Controller
{
  
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect to Google for admin login
     */
    public function redirectToGoogleAdmin()
    {
        return Socialite::driver('google')
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent select_account',
            ])
            ->redirectUrl(config('services.google.admin.redirect'))
            ->redirect();
    }
    public function handleLoginGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            //  check if user exists with this social_id
            $findUser = User::where('social_id', $user->id)->first();
            
            if ($findUser) {
                Auth::login($findUser);
                return $this->redirectTo($findUser->role);
            }
            
            // If no user with social_id, check by email
            $findUserByEmail = User::where('email', $user->email)->first();
            
            if ($findUserByEmail) {
                // User exists with this email but didn't register with social
                // Update their record with social credentials
                $findUserByEmail->update([
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'avatar' => $user->avatar

                ]);
                
                Auth::login($findUserByEmail);
                return $this->redirectTo($findUserByEmail->role);
            }
                // If no user exists at all, store data in session for registration
                Session::put('social_user', [
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'avatar' => $user->avatar
                ]);
                
                return redirect()->route('social.register');
            
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Failed to login with Google: ' . $e->getMessage()]);
        }
    }
    

    public function showSocialRegistrationForm()
    {
        if (!Session::has('social_user')) {
            return redirect()->route('register');
        }
        
        $socialUser = Session::get('social_user');
        $publishingHouses = PublishingHouse::all();
        
        return view('auth.social-register', compact('socialUser', 'publishingHouses'));
    }

    public function handleSocialRegistration(Request $request)
    {
        if (!Session::has('social_user')) {
            return redirect()->route('register');
        }
        
        $socialUser = Session::get('social_user');
        
        // First validate the email is still unique (might have changed since session was set)
        $emailValidation = User::where('email', $socialUser['email'])->exists();
        
        if ($emailValidation) {
            // Email already exists - redirect to login with error
            return redirect()->route('login')
                ->withErrors(['email' => 'This email is already registered. Please login instead.']);
        }
        
        $request->validate([
            'phone' => ['required', 'unique:users,phone'],
            'role' => ['required', 'in:Reader,Publisher']
        ]);

        // Handle image upload (use social avatar if available)
        $imagePath = null;
        if (!empty($socialUser['avatar'])) {
            try {
                $imageContents = file_get_contents($socialUser['avatar']);
                $imageName = 'profile_images/' . uniqid() . '.jpg';
                \Storage::disk('public')->put($imageName, $imageContents);
                $imagePath = $imageName;
            } catch (Exception $e) {
                // Log error or handle failed avatar download
            }
        }

        // Create user
        $user = User::create([
            'name' => $socialUser['name'],
            'email' => $socialUser['email'],
            'phone' => $request->phone,
            'password' => Hash::make(uniqid()),
            'image' => $imagePath,
            'role' => $request->role,
            'social_id' => $socialUser['social_id'],
            'social_type' => $socialUser['social_type'],
            'email_verified_at' => now() 
        ]);

        if ($request->role === 'Publisher') {
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
        Session::forget('social_user');

        return $this->redirectTo($user->role);
    }

    
    protected function redirectTo($role): RedirectResponse
    {
        switch ($role) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
                case 'Publisher':
                    return redirect()->route('publisher.books.index');
                case 'Reader':
                default:
                    return redirect()->route('books.reader.index');
        }
    }
    /**
     * Handle Google callback for admin login
     */
    public function handleLoginGoogleAdminCallback()
    {
        try {

            $user = Socialite::driver('google')
            ->redirectUrl(config('services.google.admin.redirect'))
            ->user();
            // $user = Socialite::driver('google')->user();
            
            // First check if admin exists with this social_id
            $findAdmin = User::where('social_id', $user->id)
                ->where('role', 'Admin')
                ->first();
            
            if ($findAdmin) {
                Auth::login($findAdmin);
                return redirect()->route('admin.dashboard');
            }
            
            // If no admin with social_id, check by email
            $findAdminByEmail = User::where('email', $user->email)
                ->where('role', 'Admin')
                ->first();
            
            if ($findAdminByEmail) {
                // Admin exists with this email but didn't register with social
                $findAdminByEmail->update([
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'avatar' => $user->avatar
                ]);
                
                Auth::login($findAdminByEmail);
                return redirect()->route('admin.dashboard');
            }
            
            // Clear any existing social_user session
            Session::forget('social_user');
            // If no admin exists, check if email is allowed to register as admin
            if ($this->isAllowedAdminEmail($user->email)) {
                Session::put('social_admin', [
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'avatar' => $user->avatar
                ]);
                
                return redirect()->route('admin.social.register');
            }
            
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'This email is not authorized for admin access']);
            
        } catch (Exception $e) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'Failed to login with Google: ' . $e->getMessage()]);
        }
    }
    /**
     * Show admin social registration form
     */
    public function showAdminSocialRegistrationForm()
    {
        if (!Session::has('social_admin')) {
            return redirect()->route('admin.register');
        }
        
        $socialAdmin = Session::get('social_admin');
        
        return view('auth.social-register-admin', compact('socialAdmin'));
    }
    /**
     * Handle admin social registration
     */
    public function handleAdminSocialRegistration(Request $request)
    {
        if (!Session::has('social_admin')) {
            return redirect()->route('admin.register');
        }
        
        $socialAdmin = Session::get('social_admin');
        
        $request->validate([
            'admin_code' => ['required', 'string'],
            'phone' => ['required', 'unique:users,phone']
        ]);

        // Verify admin registration code
        if ($request->admin_code !== env('ADMIN_REGISTRATION_CODE', '123456')) {
            return back()->withErrors(['admin_code' => 'Invalid admin registration code.']);
        }

        // Handle image upload (use social avatar if available)
        $imagePath = null;
        if (!empty($socialAdmin['avatar'])) {
            try {
                $imageContents = file_get_contents($socialAdmin['avatar']);
                $imageName = 'admin_images/' . uniqid() . '.jpg';
                \Storage::disk('public')->put($imageName, $imageContents);
                $imagePath = $imageName;
            } catch (Exception $e) {
                // Log error or handle failed avatar download
            }
        }

        // Create admin user
        $admin = User::create([
            'name' => $socialAdmin['name'],
            'email' => $socialAdmin['email'],
            'phone' => $request->phone,
            'password' => Hash::make(uniqid()),
            'image' => $imagePath,
            'role' => 'Admin',
            'social_id' => $socialAdmin['social_id'],
            'social_type' => $socialAdmin['social_type'],
            'email_verified_at' => now()
        ]);

        event(new Registered($admin));
        Auth::login($admin);
        Session::forget('social_admin');

        return redirect()->route('admin.dashboard');
    }

    /**
     * Check if email is allowed for admin registration
     */
    protected function isAllowedAdminEmail($email)
    {
        return true; // if found addition validation logic for admin
    }
}