<?php

namespace App\Filament\Resources\Services\EmployeeResource\Pages;

use App\Filament\Resources\Services\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployees extends ManageRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
