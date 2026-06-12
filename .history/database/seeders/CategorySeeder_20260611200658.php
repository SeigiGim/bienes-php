<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $categories = [
['name' => 'Tools', 'description' => 'Hand and power tools'],
            ['name' => 'Electronics', 'description' => 'Computers, monitors, peripherals'],
            ['name' => 'Furniture', 'description' => 'Desks, chairs, cabinets'],
            ['name' => 'Vehicles', 'description' => 'Cars, trucks, forklifts'],
            ['name' => 'Documents', 'description' => 'Contracts, reports, files'],
      ]  
    }
}
