<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_comment()
    {
        $firstId = DB::table('comments')->insertGetId([
            'name' => 'Name to delete',
            'message' => 'Comment to delete',
            'parent_id' => null
        ]);

        $response = $this->delete("/api/comments/{$firstId}");

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'OK']);

        $this->assertDatabaseCount('comments', 0);
    }
}
