<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectTo(Auth::user()->role);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
    return $this->redirectTo(Auth::user()->role);
}

protected function redirectTo($role): RedirectResponse
{
    switch ($role) {
        case 'Admin':
            return redirect()->intended(route('admin.dashboard').'?verified=1');
            case 'Publisher':
                return redirect()->intended(route('books.publisher.index').'?verified=1');
            case 'Reader':
            default:
                return redirect()->intended(route('books.reader.index').'?verified=1');
    }
}
}
