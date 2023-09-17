<?php

namespace Database\Seeders;

use App\Models\Animals\Animal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Animal::factory(["name" => "Cachorro"])
            ->create()
            ->breeds()
            ->createMany([
                ["name" => "Fox Paulistinha"],
                ["name" => "Pinscher"],
                ["name" => "Doberman"],
                ["name" => "Husky"],
                ["name" => "Fila"],
                ["name" => "Golden Retriver"],
                ["name" => "Labrador"],
                ["name" => "Lulu da Pomerânia"],
                ["name" => "Shitzu"]
            ]);

        Animal::factory(["name" => "Gato"])
            ->create()
            ->breeds()
            ->createMany([
                ["name" => "Siamês"],
                ["name" => "Persa"],
                ["name" => "Sphynx"],
            ]);
    }
}
