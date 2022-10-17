<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()
            ->times(3)
            ->create();
        Comment::factory()
            ->times(3)
            ->create();
        Comment::factory()
            ->times(6)
            ->create();

    }
}
