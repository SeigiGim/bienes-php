<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Main Office', 'address' => '123 Business Ave, Floor 2'],
            ['name' => 'North Warehouse', 'address' => 'Km 15 Industrial Zone'],
            ['name' => 'South Branch', 'address' => 'Av. Principal 456'],
            ['name' => 'Workshop', 'address' => '789 Tools St'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
