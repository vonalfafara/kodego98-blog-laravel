<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
   public function upload(Request $request) {
        $fields = $request->validate([
            "image" => "required|image|mimes:jpg,jpeg,png"
        ]);

        $image_name = time() . "." . $request->image->extension();
        $request->image->move(public_path("images"), $image_name);

        return response()->json([
            "image_name" => $image_name
        ], 201);
   }
}
