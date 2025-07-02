<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;

use App\Http\Requests\RegisterRequest;
use App\Mail\PasswordResetEmail;
use App\Models\Site;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

   public function register(RegisterRequest $request)
{
    DB::beginTransaction();

    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'marketing_consent' => $request->marketing_consent ?? false,
            'email_verification_token' => Str::random(60),
            'role' => $request->role ?? 'user',
        ]);

        DB::commit(); // Commit before sending the email

        // Try to send the verification email, but don't block registration
        try {
            $this->sendVerificationEmail($user);
        } catch (\Exception $emailException) {
            // Log email issue but do NOT rollback user creation
            Log::error("Failed to send verification email to {$user->email}: " . $emailException->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful. Please verify your email.',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified' => (bool) $user->email_verified_at,
            ]
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Registration failed. Please try again later.',
        ], 500);
    }
}



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid credentials'], 422);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = JWTAuth::user();
        if (!$user->email_verified_at) {
            return response()->json(['error' => 'Please verify your email first'], 403);
        }

        return response()->json(['token' => $token, 'message' => 'Login successful']);
    }

    
    

    public function logout(Request $request)
{
    try {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 400);
        }

        JWTAuth::invalidate($token);

        return response()->json(['message' => 'Logged out successfully']);
    } catch (TokenExpiredException $e) {
        return response()->json(['error' => 'Token has already expired'], 401);
    } catch (TokenInvalidException $e) {
        return response()->json(['error' => 'Invalid token'], 401);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Failed to logout. Please try again later.'], 500);
    }
}



public function verifyEmail(Request $request)
{
    $token = $request->query('token');
    Log::debug('Email verification requested.', ['token' => $token]);

    $user = User::where('email_verification_token', $token)->first();

    if (!$user) {
        Log::warning('Invalid or expired token used for email verification.', ['token' => $token]);
        return response()->json(['error' => 'Invalid or expired token'], 400);
    }

    Log::info('User found for verification.', ['user_id' => $user->id]);

    $user->email_verified_at = now();
    $user->email_verification_token = null;
    $user->save();

    Log::info('User email verified and token cleared.', ['user_id' => $user->id]);

    $token = JWTAuth::fromUser($user);
    Log::debug('JWT token generated for verified user.', ['user_id' => $user->id]);

    return response()->json(['message' => 'Email verified successfully', 'token' => $token]);
}



   public function resendVerificationEmail(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'No user found with this email.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['error' => 'Email is already verified.'], 400);
        }

        // Generate and save a new token
        $user->email_verification_token = Str::random(60);
        $user->save();

        // Send the verification email
        $this->sendVerificationEmail($user);

        Log::info('Verification email resent.', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return response()->json(['message' => 'Verification email resent successfully.']);
    } catch (\Exception $e) {
        Log::error('Error resending verification email', [
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['error' => 'An error occurred while resending the email.'], 500);
    }
}



public function passwordConfirm(Request $request)
{
    $token = $request->bearerToken();
    if (!$token) {
        return response()->json(['error' => 'Token not provided'], 401);
    }

    $request->validate(['password' => 'required']);

    try {
        $user = JWTAuth::setToken($token)->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }
    } catch (TokenExpiredException $e) {
        return response()->json(['error' => 'Token expired'], 401);
    } catch (TokenInvalidException $e) {
        return response()->json(['error' => 'Invalid token'], 401);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Token error'], 401);
    }

    return response()->json(['message' => 'Password confirmed']);
}



    protected function sendVerificationEmail($user)
    {
        Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));
        Log::info("Verification email sent to {$user->email} with token {$user->email_verification_token} at " . now());
    }





public function sendPasswordResetEmail(Request $request)
{
    // Validate request
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid input provided.',
            'errors' => $validator->errors()
        ], 422);
    }

    $email = $request->email;

    // Check if user exists
    $user = User::where('email', $email)->first();

    if (!$user) {
        // Log for backend traceability, but return generic response to frontend (privacy)
        Log::warning("Password reset requested for non-existing email: {$email}");
        return response()->json([
            'message' => 'If this email is registered with us, a reset link will be sent shortly.'
        ], 200); // Always return 200 to avoid exposing valid/invalid emails
    }

    // Throttle password reset (e.g., 1 request every 5 mins)
    if ($user->password_reset_token_created_at && Carbon::parse($user->password_reset_token_created_at)->diffInMinutes(now()) < 5) {
        return response()->json([
            'message' => 'A password reset link was already sent recently. Please check your inbox or try again later.'
        ], 429); // Too Many Requests
    }

    // Generate token and update user
    $user->password_reset_token = Str::random(60);
    $user->password_reset_token_created_at = now();
    $user->save();

    try {
        // Send reset email
        Mail::to($user->email)->send(new PasswordResetEmail($user));
        Log::info("Password reset email sent to {$user->email} at " . now());

        return response()->json([
            'message' => 'If this email is registered, a reset link has been sent.'
        ], 200);
    } catch (\Exception $e) {
        Log::error("Failed to send reset email to {$user->email}: " . $e->getMessage());

        return response()->json([
            'message' => 'We encountered an issue while sending the reset email. Please try again later.'
        ], 500);
    }
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required|string',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ],
    ]);

    $user = User::where('password_reset_token', $request->token)->first();

    if (!$user) {
        return response()->json(['error' => 'Invalid or expired token'], 400);
    }

    // Optional: check token expiration, e.g., 60 minutes
    if ($user->password_reset_token_created_at->diffInMinutes(now()) > 60) {
        return response()->json(['error' => 'Token expired'], 400);
    }

    $user->password = Hash::make($request->password);
    $user->password_reset_token = null;
    $user->password_reset_token_created_at = null;
    $user->save();

    return response()->json(['message' => 'Password reset successfully']);
}


public function changePassword(Request $request)
{
    $user = $request->user();

    $request->validate([
        'current_password' => 'required|string',
        'new_password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ],
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['error' => 'Current password is incorrect'], 401);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Password changed successfully']);
}

public function checkUser()
{
    try {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated. Please login.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ], 200);

    } catch (TokenExpiredException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Token expired. Please login again.',
        ], 401);

    } catch (TokenInvalidException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid token. Please login again.',
        ], 401);

    } catch (\Exception $e) {
        Log::error('User profile error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Authorization token not found or invalid. Please login.',
        ], 401);
    }
}

public function registerSite(Request $request)
{
    $validated = $request->validate([
        'domain' => 'required|string|unique:sites',
        'name' => 'required|string',
    ]);

    $site = Site::create([
        'domain' => $validated['domain'],
        'name' => $validated['name'],
        'user_id' => JWTAuth::user()->id,
    ]);

    return response()->json(['site' => $site]);
}



}
    

