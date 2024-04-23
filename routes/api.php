<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;

//Auth
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

//User
Route::get("/users/{id}", [UserController::class, "getUser"]);

//Blogs
Route::get("/blogs", [BlogController::class, "getBlogs"]);
Route::get("/blogs/{user_id}", [BlogController::class, "getUserBlogs"]);
Route::get("/blogs/blog/{blog_id}", [BlogController::class, "getBlog"]);

Route::group(["middleware" => ["auth:sanctum"]], function() {
    //Blogs
    Route::post("/blogs", [BlogController::class, "saveBlog"]);
    Route::put("/blogs/{blog_id}", [BlogController::class, "updateBlog"]);
    Route::delete("/blogs/{blog_id}", [BlogController::class, "deleteBlog"]);

    //Comments
    Route::post("/blogs/{blog_id}/comment", [CommentController::class, "saveComment"]);
    Route::put("/blogs/{blog_id}/comment/{comment_id}", [CommentController::class, "updateComment"]);
    Route::delete("/blogs/{blog_id}/comment/{comment_id}", [CommentController::class, "deleteComment"]);

    //Upload
    Route::post("/upload-image", [UploadController::class, "upload"]);

    //Profile
    Route::post("/profile", [UserController::class, "updateProfile"]);
    
    //Logout
    Route::post("/logout", [AuthController::class, "logout"]);
});