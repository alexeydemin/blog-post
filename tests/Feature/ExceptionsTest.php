<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExceptionsTest extends TestCase
{

    public function test_wrong_url()
    {
        $response = $this->get('/api/commmmmmmmmmmmments');
        $response
            ->assertStatus(404)
            ->assertJson(['status' => 'ERROR']);
        ;
    }

    public function test_wrong_type()
    {
        $response = $this->putJson("/api/comments/bla-bla-bla", [
            'name' => 'Updated',
            'message' => 'Message',
        ]);
        $response
            ->assertStatus(400)
            ->assertJson(['status' => 'ERROR']);
    }
}
