<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_category(): void
    {
        $response = $this->postJson('/api/v1/categories', [
            'name' => 'Tools',
            'description' => 'Hand and power tools',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'description', 'created_at', 'updated_at'],
            ])
            ->assertJson([
                'data' => [
                    'name' => 'Tools',
                    'description' => 'Hand and power tools',
                ],
            ]);
    }
}
