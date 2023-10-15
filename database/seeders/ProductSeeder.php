<?php

namespace Database\Seeders;

use App\Models\Services\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name'        => 'Banho',
            'description' => 'Tosa',
            'price'       => 6500,
            'is_service'  => true
        ]);
    }
}
