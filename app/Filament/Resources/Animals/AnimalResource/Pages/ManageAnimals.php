<?php

namespace App\Filament\Resources\Animals\AnimalResource\Pages;

use App\Filament\Resources\Animals\AnimalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAnimals extends ManageRecords
{
    protected static string $resource = AnimalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
