<?php

namespace Database\Seeders;

use App\Models\Services\Employee;
use App\Models\Services\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory(3)->create()->each(function (Employee $employee) {
            $employee->services()->saveMany(Service::inRandomOrder()->limit(rand(1, Service::count()))->get());
        });
    }
}
