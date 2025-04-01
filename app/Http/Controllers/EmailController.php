<?php

namespace App\Http\Controllers;

use App\Mail\goodSignup;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function index()
    {

    }

    public function sendWelcomeEmail()
    {
        $toEmail = 'orlanddosay@gmail.com';
        $message = 'Welcome po kayo!';
        $subject = 'Welcome Email in my system';

        $response = Mail::to($toEmail)->send(new goodSignup($message, $subject));

        dd($response);
    }
}
