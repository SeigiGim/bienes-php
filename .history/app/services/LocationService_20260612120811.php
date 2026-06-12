<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    public function store(array $data): Location
    {
        return Location::create($data);
    }

    public function all(): Collection
    {
        return Location::all();
    }

    public function find(int $id): Location
    {
        return Location::findOrFail($id);
    }

    public function update(int $id, array $data): Location
    {
        $location = $this->find($id);

        $location->update($data);

        return $location;
    }

    public function delete(int $id): void
    {
        $location = $this->find($id);
        $location->delete();
    }
}
