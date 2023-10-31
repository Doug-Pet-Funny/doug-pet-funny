<?php

namespace Database\Seeders;

use App\Models\Animals\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()->createMany([
            ['name' => 'Coleira'],
            ['name' => 'Guia'],
            ['name' => 'Enforcador'],
            ['name' => 'Retrátil'],
            ['name' => 'Peitoral'],
            ['name' => 'Escova de Dentes'],
            ['name' => 'Pasta de Dentes'],
        ]);
    }
}
