<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentsIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_tree()
    {
        $firstId = DB::table('comments')->insertGetId([
            'name' => 'John Smith',
            'message' => 'Hi Jane, please read this post.',
            'parent_id' => null
        ]);
        $secondId = DB::table('comments')->insertGetId([
            'name' => 'Jane Johnson',
            'message' => 'John, thanks for mentioning me here.',
            'parent_id' => $firstId
        ]);
        DB::table('comments')->insert([
            'name' => 'Jon Snow',
            'message' => 'I know nothing about this.',
            'parent_id' => $secondId
        ]);
        DB::table('comments')->insert([
            'name' => 'Oberyn Martel',
            'message' => 'There is no justice here in the capital.',
            'parent_id' => $secondId
        ]);
        DB::table('comments')->insert([
            'name' => 'Arya Stark',
            'message' => 'I like this post too.',
            'parent_id' => $firstId
        ]);
        DB::table('comments')->insert([
            'name' => 'Sandor Clegane',
            'message' => "I understand that if any more words come pouring out your mouth, I'm gonna have to eat every chicken in this room.",
            'parent_id' => null
        ]);


        $response = $this->get('/api/comments');
        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has(2)
                    ->first(function ($json) {
                        $json
                            ->hasAll(['id', 'name', 'message', 'comments'])
                            ->missing('parent_id')
                            ->where('name', 'John Smith')
                            ->where('message', 'Hi Jane, please read this post.');
                    });
            })
            ->assertJsonPath('0.comments.0.name', 'Jane Johnson')
            ->assertJsonPath('0.comments.1.name', 'Arya Stark')
            ->assertJsonPath('0.comments.1.message', 'I like this post too.')
            ->assertJsonPath('0.comments.0.comments.0.name', 'Jon Snow')
            ->assertJsonPath('0.comments.0.comments.1.name', 'Oberyn Martel')
            ->assertJsonPath('0.comments.0.comments.0.comments', [])
            ->assertJsonPath('1.name', 'Sandor Clegane')
            ;
    }

}
