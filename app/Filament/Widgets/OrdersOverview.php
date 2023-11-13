<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Orders\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrdersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];

        foreach (OrderStatusEnum::cases() as $status) {
            $stats[] = Stat::make("Pedidos {$status->getLabel()}(s)", Order::withTrashed()->where("status", $status)->count());
        }
        $stats[] = Stat::make(
            'Valor total recebido',
            'R$ ' . number_format(Order::withTrashed()->where('status', OrderStatusEnum::Paid)->sum('total') / 100, decimal_separator: ',', thousands_separator: '.')
        );

        return $stats;
    }
}