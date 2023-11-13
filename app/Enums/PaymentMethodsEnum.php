<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethodsEnum: string implements HasLabel, HasColor
{
    case Credit = 'credit';
    case Debit = 'debit';
    case Money = 'money';
    case Pix = 'pix';

    public function getLabel(): string
    {
        return match ($this) {
            self::Credit => 'Crédito',
            self::Debit => 'Débito',
            self::Money => 'Dinheiro',
            self::Pix => 'Pix'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Credit => '#086375',
            self::Debit => '#1DD3B0',
            self::Money => '#66E879',
            self::Pix => '#AFFC41',
        };
    }
}
