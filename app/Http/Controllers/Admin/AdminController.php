<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller
{
//    public function showLoginForm()
//    {
//        return view('admin.auth.login');
//    }

//    /**
//     * Handle admin login.
//     */
//    public function login(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);

//        // Attempt authentication
//        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
//            // Check if user is an admin
//            if (Auth::user()->role === 'Admin') {
//                return redirect()->route('admin.dashboard');
//            } else {
//                Auth::logout();
//                return back()->withErrors(['email' => 'Access Denied. Only admins can log in here.']);
//            }
//        }

//        return back()->withErrors(['email' => 'Invalid credentials.']);
//    }

//    /**
//     * Handle admin logout.
//     */
//    public function logout()
//    {
//        Auth::logout();
//        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
//    }

   /**
    * Show the admin dashboard.
    */
   public function dashboard()
   {
       return view('admin.dashboard');
   }
}
