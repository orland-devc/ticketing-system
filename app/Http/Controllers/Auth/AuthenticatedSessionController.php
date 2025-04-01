<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function createStudent(): View
    {
        return view('auth.login-student');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        ActivityLog::log(
            'login',
            Auth::user()->name.' logged in.',
            Auth::user()
        );

        return $this->handleUserRedirect($request->user());
    }

    protected function handleUserRedirect($user)
    {
        switch ($user->role) {
            case 'Administrator':
                return redirect('admindashboard');
                break;
            case 'Office':
                return redirect('officedashboard');
                break;
            case 'Student':
                return redirect('dashboard');
                break;
        }
    }

    public function destroy(Request $request)
    {
        ActivityLog::log(
            'logout',
            Auth::user()->name.' logged out.',
            Auth::user()
        );
        // Determine the redirect URL based on the user's role
        $redirectTo = Auth::user()->role === 'Student' ? '/login/student' : '/login';

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect based on the role
        return redirect($redirectTo);
    }
}
