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
}
