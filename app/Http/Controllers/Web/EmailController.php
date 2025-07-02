<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{

    
    public function verifyEmail(Request $request)
{
    $token = $request->query('token');
    Log::debug('Email verification requested.', ['token' => $token]);

    $user = User::where('email_verification_token', $token)->first();

    if (!$user) {
        Log::warning('Invalid or expired token used for email verification.', ['token' => $token]);
        return view('emails.invalid-token'); 
    }

    $user->email_verified_at = now();
    $user->email_verification_token = null;
    $user->save();

    return view('emails.verified-success'); 
}



}
