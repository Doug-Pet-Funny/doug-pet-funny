<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServicesEnum: string implements HasLabel
{
    case Bath = 'bath';
    case Grooming = 'grooming';

    public function getLabel(): string
    {
        return match ($this) {
            self::Bath => 'Banho',
            self::Grooming => 'Tosa',
        };
    }
}
