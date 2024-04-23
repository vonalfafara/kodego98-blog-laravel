<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email_address" => "required|email|unique:users,email_address",
            "password" => "required|confirmed"
        ]);

        $user = User::create([
            "first_name" => $fields["first_name"],
            "last_name" => $fields["last_name"],
            "email_address" => $fields["email_address"],
            "password" => Hash::make($fields["password"]),
        ]);

        $token = $user->createToken(env("AUTH_SECRET", "secret"))->plainTextToken;

        return response()->json([
            "message" => "Registered successfully",
            "user" => $user,
            "token" => $token
        ], 201, [], JSON_PRETTY_PRINT);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            "email_address" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email_address", $fields["email_address"])->first();

        if (!$user) {
            return response()->json([
                "message" => "Email address does not exist"
            ], 404, [], JSON_PRETTY_PRINT);
        }

        $token = $user->createToken(env("AUTH_SECRET", "secret"))->plainTextToken;

        return response()->json([
            "message" => "Logged in successfully",
            "user" => $user,
            "token" => $token
        ], 201, [], JSON_PRETTY_PRINT);
    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "Logged out"
        ], 200, [], JSON_PRETTY_PRINT);
    }
}

