<?php

namespace Database\Seeders;

use App\Models\Customers\Customer;
use App\Models\Orders\Order;
use App\Models\Services\Employee;
use App\Models\Services\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory(20)->create()->each(function (Order $order) {
            $customer = Customer::inRandomOrder()->limit(1)->first();
            $order->customer()->associate($customer);

            $service = Service::inRandomOrder()->limit(1)->first();
            $employee = Employee::whereHas('services', fn (Builder $query) => $query->where('name', $service->name))->get()->first();
            $order->items = [
                [
                    'pet' => $customer->pets->first()->name,
                    'item' => $service->name,
                    'price' => $service->price,
                    'employee' => $employee->name,
                    'quantity' => 1
                ]
            ];
            $order->total = $service->price;

            $order->save();
        });
    }
}
