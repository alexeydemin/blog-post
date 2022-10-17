<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_comment()
    {
        $firstId = DB::table('comments')->insertGetId([
            'name' => 'Somebody',
            'message' => 'The first comment',
            'parent_id' => null
        ]);

        $response = $this->putJson("/api/comments/{$firstId}", [
            'name' => 'Updated',
            'message' => 'Message',
        ]);
        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'OK']);

        $this->assertDatabaseHas('comments', [
            'name' => 'Updated',
            'message' => 'Message',
            'parent_id' => null,
            'id' => $firstId,
        ]);
    }
}
