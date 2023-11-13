<?php

namespace App\Filament\Resources\Orders\OrderResource\Pages;

use App\Enums\PaymentMethodsEnum;
use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make()
                ->label('Todos'),
        ];

        foreach (PaymentMethodsEnum::cases() as $method) {
            $tabs[$method->value] = Tab::make()
                ->label($method->getLabel())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('payment_method', $method));
        }

        return $tabs;
    }
}
