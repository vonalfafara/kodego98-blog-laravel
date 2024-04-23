<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function getUser($id) {
        $user = new UserResource(User::find($id));
        return response()->json($user, 200, [], JSON_PRETTY_PRINT);
    }

    public function updateProfile(Request $request) {
        $user = User::find(auth()->user()->id);

        if (!$user) {
            return response()->json([
                "message" => "User does not exist"
            ], 404);
        }

        $fields = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email_address" => "required|email",
            "profile_picture" => "nullable"
        ]);

        $user->first_name = $fields["first_name"];
        $user->last_name = $fields["last_name"];
        $user->email_address = $fields["email_address"];
        $user->profile_picture = $fields["profile_picture"];
        $user->save();

        return response()->json([
            "message" => "Profile has been updated",
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
