<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethodsEnum: string implements HasLabel
{
    case Credit = 'credit';
    case Debit = 'debit';
    case Money = 'money';
    case Pix = 'pix';

    public function getLabel(): string
    {
        return match ($this) {
            self::Credit => 'Crédito',
            self::Debit  => 'Débito',
            self::Money  => 'Dinheiro',
            self::Pix    => 'Pix'
        };
    }
}
