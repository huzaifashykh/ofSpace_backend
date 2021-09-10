<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "comment" => $this->faker->sentence(7, false),
            "forum_id" => Forum::all()->random()->id,
            "created_by" => User::all()->random()->id,
        ];
    }
}
