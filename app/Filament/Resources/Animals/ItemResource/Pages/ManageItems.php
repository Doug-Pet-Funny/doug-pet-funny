<?php

namespace App\Filament\Resources\Animals\ItemResource\Pages;

use App\Filament\Resources\Animals\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageItems extends ManageRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
