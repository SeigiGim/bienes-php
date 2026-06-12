<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    public function store(array $data): Contact
    {
        return Contact::create($data);
    }

    public function all(): Collection
    {
        return Contact::all();
    }

    public function find(int $id): Contact
    {
        return Contact::findOrFail($id);
    }

    public function update(int $id, array $data): Contact
    {
        $contact = $this->find($id);
        $contact->update($data);

        return $contact;
    }

    public function delete(int $id): void
    {
        $contact = $this->find($id);
        $contact->delete();
    }
}
