<?php

namespace App\Filament\Resources\BreedResource\Pages;

use App\Filament\Resources\BreedResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBreed extends ViewRecord
{
    protected static string $resource = BreedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
