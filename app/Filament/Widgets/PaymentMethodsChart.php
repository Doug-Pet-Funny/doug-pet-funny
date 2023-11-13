<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentMethodsEnum;
use App\Models\Orders\Order;
use Filament\Widgets\ChartWidget;

class PaymentMethodsChart extends ChartWidget
{
    protected static ?string $heading = 'Meios de Pagamento';

    protected static ?string $description = 'Quantidade de pedidos para cada método de pagamento';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        foreach (PaymentMethodsEnum::cases() as $method) {
            $data[] = Order::where('payment_method', $method)->count();
            $labels[] = $method->getLabel();
            $backgroundColor[] = $method->getColor();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Meios de pagamento',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                ],
            ],
            'labels' => $labels
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}