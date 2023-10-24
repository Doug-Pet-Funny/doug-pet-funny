<?php

namespace Database\Seeders;

use App\Models\Animals\Animal;
use App\Models\Customers\Customer;
use App\Models\Customers\Pet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory(10)->create()->each(function (Customer $customer) {
            $animal = Animal::inRandomOrder()->limit(1)->first();
            $pet = Pet::factory()->make();
            $pet->animal_id = $animal->id;
            $pet->breed_id = $animal->breeds->first()->id;

            $customer->pets()->save($pet);
        });
    }
}
