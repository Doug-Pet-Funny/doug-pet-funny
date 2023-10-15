<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as AuthEditProfile;

class EditProfile extends AuthEditProfile
{
    protected static string $layout = 'filament-panels::components.layout.index';

    protected static string $view = 'filament.pages.auth.edit-profile';

    public static function getSlug(): string
    {
        return static::$slug ?? 'perfil';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Informações Pessoais')
                    ->description('Seus dados de usuário')
                    ->icon('heroicon-o-user-circle')
                    ->aside()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                    ]),
                Components\Section::make('Segurança')
                    ->description('Seus dados de segurança')
                    ->icon('heroicon-o-lock-closed')
                    ->aside()
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent()
                    ])
            ]);
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }
}
