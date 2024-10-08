<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Override the attemptLogin method
    protected function attemptLogin(Request $request)
    {
        // Add a check for user status before allowing login
        return $this->guard()->attempt(
            $this->credentials($request) + ['status' => 'active'],  // Only allow login if status is 'active'
            $request->filled('remember')
        );
    }

    // Optional: If you want to return a specific message for inactive users
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => [trans('auth.inactive')],
            ]);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
