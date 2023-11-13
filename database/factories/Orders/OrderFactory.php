<?php

namespace Database\Factories\Orders;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodsEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(OrderStatusEnum::class),
            'payment_method' => fake()->randomElement(PaymentMethodsEnum::class),
            'total' => fake()->randomNumber(6, true),
            'items' => [
                [
                    'pet' => fake()->firstName(),
                    'item' => fake()->words(asText: true),
                    'price' => fake()->randomNumber(6, true),
                    'employee' => fake()->name(),
                    'quantity' => 1
                ],
            ],
            'date' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'start_hour' => fake()->time(),
            'end_hour' => fake()->time(),
        ];
    }
}
