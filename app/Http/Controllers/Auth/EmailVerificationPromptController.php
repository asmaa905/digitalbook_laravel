<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? $this->redirectTo(Auth::user()->role)
                    : view('auth.verify-email');
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
