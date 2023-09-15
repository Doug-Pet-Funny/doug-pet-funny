<?php

namespace App\Filament\Resources\Animals\BreedResource\Pages;

use App\Filament\Resources\Animals\BreedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBreeds extends ListRecords
{
    protected static string $resource = BreedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
