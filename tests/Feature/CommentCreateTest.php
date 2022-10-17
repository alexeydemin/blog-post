<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_comment()
    {
        $response = $this->postJson('/api/comments', [
            'name' => 'Sally',
            'message' => 'Hi there',
        ]);
        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'OK']);

        $this->assertDatabaseHas('comments', [
            'name' => 'Sally',
            'message' => 'Hi there',
            'parent_id' => null,
        ]);
    }

    public function test_create_comment_with_parent()
    {
        $firstId = DB::table('comments')->insertGetId([
            'name' => 'Somebody',
            'message' => 'The first comment',
            'parent_id' => null
        ]);

        $response = $this->postJson('/api/comments', [
            'name' => 'Johanna',
            'message' => 'A second comment',
            'parent_id' => $firstId
        ]);
        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'OK']);

        $this->assertDatabaseHas('comments', [
            'name' => 'Johanna',
            'message' => 'A second comment',
            'parent_id' => $firstId,
        ]);
    }

    public function test_name_validation()
    {
        $response = $this->postJson('/api/comments', [
            'name' => 'Super-long-string-over-255-symbols---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',
            'message' => 'A second comment',
        ]);
        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'ERROR']);
    }
}
