<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogsResource;
use App\Models\Blog;

class BlogController extends Controller
{
    public function getBlogs(Request $request) {
        $search = $request->query("search");
        $blogs;

        if (isset($search)) {
            $blogs = Blog::whereAny(["title", "subtitle"], "ILIKE", "%" . $search . "%")->orderBy($request->query("sortBy"), $request->query("ascDesc"))->get();
        } else {
            $blogs = Blog::orderBy($request->query("sortBy"), $request->query("ascDesc"))->get();
        }

        $blogs = BlogsResource::collection($blogs);
        return response()->json($blogs, 200, [], JSON_PRETTY_PRINT);
    }

    public function getBlog($blog_id) {
        $blog = new BlogResource(Blog::find($blog_id));
        return response()->json($blog, 200, [], JSON_PRETTY_PRINT);
    }

    public function getUserBlogs($user_id) {
        $blogs = Blog::where("user_id", $user_id)->get();
        return response()->json($blogs, 200, [], JSON_PRETTY_PRINT);
    }

    public function saveBlog(Request $request) {
        $fields = $request->validate([
            "title" => "required",
            "subtitle" => "required",
            "body" => "required"
        ]);

        Blog::create([
            "title" => $fields["title"],
            "subtitle" => $fields["subtitle"],
            "body" => $fields["body"],
            "user_id" => auth()->user()->id
        ]);

        return response()->json([
            "message" => "'" . $fields["title"] . "' has been created"
        ], 200);
    }

    public function updateBlog(Request $request, $blog_id) {
        $blog = Blog::find($blog_id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog does not exist"
            ], 404);
        }
        
        $fields = $request->validate([
            "title" => "required",
            "subtitle" => "required",
            "body" => "required"
        ]);

        $blog->title = $fields["title"];
        $blog->subtitle = $fields["subtitle"];
        $blog->body = $fields["body"];
        $blog->save();

        return response()->json([
            "message" => "Blog has been updated"
        ], 200);
    }

    public function deleteBlog($blog_id) {
        $blog = Blog::find($blog_id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog does not exist"
            ], 404);
        }

        $blog->delete();

        return response()->json([
            "message" => "Blog has been deleted"
        ], 200);
    }
}
