<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->date("Y-m-d") . " " . fake()->time("h:i:s");
        $blog = Blog::find(fake()->randomElement(Blog::pluck("id")));
        $blog_id = $blog->id;
        $comment_id = null;

        if (count($blog->comments)) {
            $comment_id = fake()->randomElement($blog->comments)->id;
            if ($comment_id) 
                $blog_id = null;
        }
        
        return [
            "body" => fake()->realText($maxNbChars = 255),
            "blog_id" => $blog_id,
            "user_id" => fake()->randomElement(User::pluck("id")),
            "comment_id" => $comment_id ,
            "created_at" => $date,
            "updated_at" => $date
        ];
    }
}
