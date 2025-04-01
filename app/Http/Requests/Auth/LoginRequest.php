<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // If 'student_id' is present in the request
        if ($this->has('student_id')) {
            return [
                'student_id' => ['required', 'string'],
                'password' => ['required', 'string'],
            ];
        }

        // Default case for requests without 'student_id'
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->getCredentials();

        // Attempt login without role check first
        $loginField = $this->getLoginField();
        $attemptCredentials = [
            $loginField => $credentials[$loginField],
            'password' => $credentials['password'],
        ];

        if (! Auth::attempt($attemptCredentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                $loginField => trans('auth.failed'),
            ]);
        }

        // Check role restrictions based on the type of login
        if ($this->has('student_id')) {
            // Verify that student_id user has the Student role
            if (Auth::user()->role !== 'Student') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'student_id' => 'Invalid student credentials.',
                ]);
            }
        } else {
            // Verify that email user is not a Student
            if (Auth::user()->role === 'Student') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Students cannot log in through this portal.',
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    protected function getCredentials(): array
    {
        if ($this->has('student_id')) {
            return [
                'student_id' => $this->input('student_id'),
                'password' => $this->input('password'),
            ];
        }

        return [
            'email' => $this->input('email'),
            'password' => $this->input('password'),
        ];
    }

    protected function getLoginField(): string
    {
        return $this->has('student_id') ? 'student_id' : 'email';
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            $this->getLoginField() => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string($this->getLoginField())).'|'.$this->ip());
    }
}
