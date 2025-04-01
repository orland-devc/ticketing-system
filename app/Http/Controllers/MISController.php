<?php

namespace App\Http\Controllers;

use App\Mail\SignUpApproved;
use App\Mail\SignUpRejected;
use App\Models\ActivityLog;
use App\Models\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MISController extends Controller
{
    public function index()
    {
        $requests = SignUpRequest::where('approved', false)->get();

        return view('mis.requests', compact('requests'));
    }

    public function requestNum()
    {
        $requestNum = SignUpRequest::where('approved', false)->count();

        return view('layouts.officeNav', compact('requestNum'));

    }

    public function approve(SignUpRequest $request)
    {
        if ($request->year_level == '6') {
            $role = 'Alumni';
        } else {
            $role = 'Student';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'course' => $request->course,
            'password' => Hash::make($request->student_id),
            'role' => $role,
        ]);

        $request->update(['approved' => true]);

        ActivityLog::log(
            'signup_approval',
            'MIS approved a sign-up request.',
            Auth::user(),
            [
                'approved_user_id' => $user->student_id,
                'approved_user_email' => $user->email,
            ]
        );

        Mail::to($user->email)->send(new SignUpApproved($user));

        return redirect()->route('mis.requests')->with('message', 'Sign-up request approved and user created.');
    }

    public function reject(SignUpRequest $request)
    {
        // Update the request status to rejected
        $request->update(['approved' => '2']);

        // Log the rejection activity
        ActivityLog::log(
            'signup_approval',
            'MIS rejected a sign-up request.',
            Auth::user(),
            [
                'approved_user_id' => $request->id,
                'approved_user_email' => $request->email,
            ]
        );

        // Send rejection email
        Mail::to($request->email)->send(new SignUpRejected($request));

        // Redirect back with a status message
        return redirect()->route('mis.requests')->with('status', 'Sign-up request rejected and deleted.');
    }
}
