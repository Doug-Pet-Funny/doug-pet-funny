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

    protected static ?string $description = 'Total em reais de acordo com o filtro.';

    protected int|string|array $columnSpan = 2;

    public ?string $filter = 'all';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $query = $activeFilter != 'all' ? Order::withTrashed()->where('payment_method', $activeFilter) : Order::withTrashed();

        $data = Trend::query($query)
            ->dateColumn('service_date')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('total');

        return [
            'datasets' => [
                [
                    'label' => 'R$',
                    'data' => $data->map(fn(TrendValue $value) => number_format($value->aggregate / 100, decimal_separator: ',', thousands_separator: '.')),
                    'fill' => true,
                ],
            ],
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
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
