<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_contact(): void
    {
        $response = $this->postJson('/api/v1/contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Developer',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'position', 'created_at', 'updated_at'],
            ])
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'position' => 'Developer',
                ],
            ]);
    }

    public function test_email_must_be_unique(): void
    {
        Contact::factory()->create(['email' => 'dup@example.com']);

        $response = $this->postJson('/api/v1/contacts', [
            'name' => 'Another',
            'email' => 'dup@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_can_list_contacts(): void
    {
        Contact::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/contacts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'position', 'created_at', 'updated_at'],
                ],
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson("/api/v1/contacts/{$contact->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['id' => $contact->id],
            ]);
    }

    public function test_returns_404_for_nonexistent_contact(): void
    {
        $response = $this->getJson('/api/v1/contacts/999');

        $response->assertStatus(404);
    }

    public function test_can_update_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->putJson("/api/v1/contacts/{$contact->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Name',
                    'email' => 'updated@example.com',
                ],
            ]);
    }

    public function test_can_delete_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->deleteJson("/api/v1/contacts/{$contact->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
