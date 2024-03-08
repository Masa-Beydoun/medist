<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\PharmacistResource;
use App\Mail\ResetMail;
use App\Models\Pharmacist;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $pharmacistData = $request->validated();
        $pharmacist = Pharmacist::create($pharmacistData);
        $token = $pharmacist->createToken('pharmacist')->plainTextToken;
        $setting = Setting::create();
        $pharmacist->setting()->save($setting);
        return response([
            'pharmacist' => new PharmacistResource($pharmacist),
            'token' => $token
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $pharmacistData = $request->validated();
        $pharmacist = Pharmacist::where('phone_number', $pharmacistData['phone_number'])->first();
        if (!$pharmacist || !Hash::check($pharmacistData['password'], $pharmacist->password)) {
            return response([
                'msg' => 'Invalid Credentials'
            ], 422);
        }
        $token = $pharmacist->createToken('company')->plainTextToken;
        return response([
            'pharmacist' => new PharmacistResource($pharmacist),
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        $pharmacist = Pharmacist::find(Auth::guard('sanctum')->user()->id);
        $pharmacist->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'],200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $pharmacist = Pharmacist::where('email', $request->email)->first();
        if(!$pharmacist) {
            return response()->json([
                'message' => 'Incorrect Data'
            ], 400);
        }
        $token = Str::random(50);
        $user = DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);
        Mail::to($request->email)->send(new ResetMail($token));
        return response()->json([
            'message' => 'Email Sent',
        ],200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = DB::table('password_reset_tokens')->where([
            'email' => $request->email
        ])->first();
        if($user->token == $request->token) {
            $pharmacist = Pharmacist::where('email', $request->email)->first();
            $pharmacist->password = bcrypt($request->password);
            $pharmacist->save();
            return response()->json([
                'message' => 'Password Reset',
            ],200);
        }
        return response()->json([
            'message' => 'Password Reset Failed',
        ],503);
    }
}
