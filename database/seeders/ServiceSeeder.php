<?php

namespace Database\Seeders;

use App\Models\Services\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name'        => 'Banho',
            'description' => 'Tosa',
            'price'       => 6500,
            'is_service'  => true
        ]);
    }
}
