<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => Comment::count() ? Comment::orderByRaw('RAND()')->first()->id : null,
            'name' => $this->faker->name,
            'message' => $this->faker->text()
        ];
    }
}
