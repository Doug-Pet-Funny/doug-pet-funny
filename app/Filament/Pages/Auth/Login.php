<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

/**
 * @property Form $form
 */
class Login extends BaseLogin
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.auth.login';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    /**
     * Mount function to handle page intialization.
     * 
     * Verify if user is authenticated, if true 
     * redirect to intend URL or Filament's default URL 
     */
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    /**
     * Authenticate user based on the form data
     * 
     * @return LoginResponse | null
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    /**
     * Define the structure of the form.
     *
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * Get the forms to be displayed on the page.
     *
     * @return array<int|string, string|Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * Create the email form component.
     *
     * @return Component
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * Create the password form component.
     *
     * @return Component
     */
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    /**
     * Create the remember form component.
     *
     * @return Component
     */
    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('filament-panels::pages/auth/login.form.remember.label'));
    }

    /**
     * Create the "Register" action link.
     *
     * @return Action
     */
    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label(__('filament-panels::pages/auth/login.actions.register.label'))
            ->url(filament()->getRegistrationUrl());
    }

    /**
     * Get the page title.
     *
     * @return string|Htmlable
     */
    public function getTitle(): string | Htmlable
    {
        return __('filament-panels::pages/auth/login.title');
    }

    /**
     * Get the page heading.
     *
     * @return string|Htmlable
     */
    public function getHeading(): string | Htmlable
    {
        return __('filament-panels::pages/auth/login.heading');
    }

    /**
     * Get the form actions for the page.
     *
     * @return array<Action|ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    /**
     * Create the "Authenticate" form action.
     *
     * @return Action
     */
    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(__('filament-panels::pages/auth/login.form.actions.authenticate.label'))
            ->submit('authenticate');
    }

    /**
     * Determine if the form actions should take up the full width.
     *
     * @return bool
     */
    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * Extract credentials from the form data.
     * 
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }
}
