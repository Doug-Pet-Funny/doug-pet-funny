<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AccountWidget extends \Filament\Widgets\AccountWidget
{
    /**
     * @var int | string | array<string, int | null>
     */
    protected int | string | array $columnSpan = 'full';
}
