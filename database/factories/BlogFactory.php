<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $body = "";
        $paragraphs = fake()->paragraphs(5);

        foreach (fake()->paragraphs(5) as $paragraph) {
            $body .= "<p>" . $paragraph . "</p>";
        }

        $date = fake()->date("Y-m-d") . " " . fake()->time("h:i:s");

        return [
            "title" => fake()->realText($maxNbChars = 50),
            "subtitle" => fake()->realText($maxNbChars = 150),
            "body" => $body,
            "user_id" => fake()->randomElement(User::pluck("id")),
            "created_at" => $date,
            "updated_at" => $date
        ];
    }
}
