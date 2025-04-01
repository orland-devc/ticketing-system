<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SignUpRequestReceived;
use App\Models\ActivityLog;
use App\Models\SignUpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SignUpRequestController extends Controller
{
    public function create()
    {
        return view('auth.signup-request');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'student_id' => 'required|string|unique:sign_up_requests,student_id',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //         'course' => 'required|string|max:255',
    //         'year_level' => 'required|integer|min:1|max:6',
    //         'birthdate' => 'required|date'
    //     ]);

    //     SignUpRequest::create($validated);

    //     ActivityLog::log(
    //         'signup_request',
    //         'New sign-up request received.',
    //         null,
    //         [
    //             'email' => $request->email,
    //             'name' => $request->name
    //         ]
    //     );

    //     return redirect()->route('login.student')->with('message', 'Your sign-up request has been submitted for approval.');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:sign_up_requests,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|integer|min:1|max:6',
            'birthdate' => 'required|date',
        ]);

        SignUpRequest::create($validated);

        ActivityLog::log(
            'signup_request',
            'New sign-up request received.',
            null,
            [
                'email' => $request->email,
                'name' => $request->name,
            ]
        );

        // Send confirmation email to the requestee
        Mail::to($request->email)->send(new SignUpRequestReceived($request->name));

        return redirect()->route('login.student')->with('message', 'Your sign-up request has been submitted for approval.');
    }
}
