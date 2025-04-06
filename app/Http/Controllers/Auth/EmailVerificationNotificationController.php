<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectTo(Auth::user()->role);
 
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
    protected function redirectTo($role): RedirectResponse
{
    switch ($role) {
        case 'Admin':
            return redirect()->route('admin.dashboard');
            case 'Publisher':
                return redirect()->route('books.publisher.index');
            case 'Reader':
            default:
                return redirect()->route('books.reader.index');
    }
}
}
