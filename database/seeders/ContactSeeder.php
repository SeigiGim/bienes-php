<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'position' => 'Analyst'],
            ['name' => 'Bob Martínez', 'email' => 'bob@example.com', 'position' => 'Manager'],
            ['name' => 'Carol Smith', 'email' => 'carol@example.com', 'position' => 'Supervisor'],
            ['name' => 'David Lee', 'email' => 'david@example.com', 'position' => 'Technician'],
            ['name' => 'Eva Torres', 'email' => 'eva@example.com', 'position' => 'Coordinator'],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
