<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard.index', absolute: false))
                    : Inertia::render('Auth/VerifyEmail', [
                        'canLogin' => Route::has('login'),
                        'canRegister' => Route::has('register'),
                        'background' => asset('images/1.jpg'),
                        'status' => session('status')
                    ]);
    }
}
