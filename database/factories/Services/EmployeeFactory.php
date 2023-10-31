<?php

namespace Database\Factories\Services;

use App\Enums\ServicesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Services\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'     => fake()->name(),
            'phone'    => fake()->phoneNumber(),
            'email'    => fake()->email(),
            'document' => fake()->cpf(false),
            'services' => fake()->randomElements(ServicesEnum::cases()),
        ];
    }
}
