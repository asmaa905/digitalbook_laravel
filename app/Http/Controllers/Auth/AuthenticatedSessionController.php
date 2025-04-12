<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            
        ]);
    
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
              // Check if user is publisher or reader
             
        }else{
            $user = Auth::user();
             if ($user->role === 'Publisher' || $user->role === 'Reader') {
                $request->session()->regenerate();
                return $this->redirectTo(Auth::user()->role);
            }
        }
       
       // Logout if not Publisher or reader
       Auth::logout();
       return back()->withErrors(['email' => ' incorrect email or password.']);
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
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}