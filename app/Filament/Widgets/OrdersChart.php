<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentMethodsEnum;
use App\Models\Orders\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Serviços';

    protected int|string|array $columnSpan = 2;

    public ?string $filter = 'all';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $query = $activeFilter != 'all' ? Order::withTrashed()->where('payment_method', $activeFilter) : Order::withTrashed();

        $data = Trend::query($query)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        $filters = ['all' => 'Todos'];
        foreach (PaymentMethodsEnum::cases() as $method) {
            $filters[$method->value] = $method->getLabel();
        }

        return $filters;
    }
}
