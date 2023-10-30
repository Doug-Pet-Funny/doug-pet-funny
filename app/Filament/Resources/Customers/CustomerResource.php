<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\CustomerResource\Pages;
use App\Filament\Resources\Customers\CustomerResource\RelationManagers;
use App\Models\Animals\Animal;
use App\Models\Customers\Customer;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'cliente';

    protected static ?string $navigationGroup = 'Clientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do usuário')
                    ->icon('heroicon-o-user-circle')
                    ->columns([
                        'sm' => 1,
                        'md' => 3
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan([
                                'sm' => 'full',
                                'md' => 2
                            ]),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->nullable()
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->maxLength(255),
                        PhoneNumber::make('phone')
                            ->label('Telefone')
                            ->required()
                            ->maxLength(255),
                        Document::make('document')
                            ->label('CPF')
                            ->cpf()
                            ->unique(ignoreRecord: true),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Data de Nascimento'),
                    ]),

                Forms\Components\Section::make('Pets')
                    ->icon('heroicon-o-heart')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Repeater::make('pets')
                            ->hiddenLabel()
                            ->required()
                            ->relationship('pets')
                            ->schema([
                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nome')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\DatePicker::make('birth_date')
                                        ->label('Data de Nascimento'),
                                    Forms\Components\TextInput::make('color')
                                        ->label('Cor')
                                ])->columns(3),

                                Forms\Components\Group::make([
                                    Forms\Components\Select::make('animal_id')
                                        ->label('Espécie')
                                        ->relationship(name: 'animal', titleAttribute: 'name')
                                        ->native(false)
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(
                                            fn (Component $component) => $component
                                                ->getContainer()
                                                ->getComponent('animalBreeds')
                                                ->getChildComponentContainer()
                                                ->fill()
                                        )
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Nome')
                                                ->required()
                                                ->maxLength(255)
                                                ->columnSpanFull()
                                                ->unique(ignoreRecord: true),
                                        ]),
                                    Forms\Components\Select::make('breed_id')
                                        ->label('Raça')
                                        ->nullable()
                                        ->native(false)
                                        ->key('animalBreeds')
                                        ->options(fn (Get $get) => Animal::find($get('animal_id'))?->breeds->sortBy('name')->pluck('name', 'id'))
                                ])->columns(2),

                                Forms\Components\Textarea::make('observations')
                                    ->label('Observações')
                            ])
                    ]),

                Forms\Components\Section::make('Endereços')
                    ->icon('heroicon-o-map-pin')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Repeater::make('addresses')
                            ->hiddenLabel()
                            ->addActionLabel('Novo endereço')
                            ->required()
                            ->relationship('addresses')
                            ->schema([
                                Cep::make('postal_code')
                                    ->label('CEP')
                                    ->required()
                                    ->viaCep(
                                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                                        /**
                                         * Other form fields that can be filled by ViaCep.
                                         * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                                         * More information: https://viacep.com.br/
                                         */
                                        setFields: [
                                            'street'     => 'logradouro',
                                            'number'     => 'numero',
                                            'complement' => 'complemento',
                                            'district'   => 'bairro',
                                            'city'       => 'localidade',
                                            'state'      => 'uf'
                                        ]
                                    ),
                                Forms\Components\TextInput::make('street')
                                    ->label('Endereço')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('number')
                                    ->label('Número')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('complement')
                                    ->label('Complemento')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('district')
                                    ->label('Bairro')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('city')
                                    ->label('Cidade')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('state')
                                    ->label('UF')
                                    ->required()
                                    ->maxLength(2),
                            ])->columns(2)
                    ]),

                Forms\Components\Section::make('Informações adicionais')
                    ->collapsible()
                    ->collapsed()
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Criado em')
                            ->content(fn ($record): string => $record?->created_at ? $record->created_at->format('d/m/Y H:i:s') : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Atualizado em')
                            ->content(fn ($record): string => $record?->updated_at ? $record->updated_at->format('d/m/Y H:i:s') : '-'),
                        Forms\Components\Placeholder::make('deleted_at')
                            ->label('Excluído em')
                            ->content(fn ($record): string => $record?->deleted_at ? $record->deleted_at->format('d/m/Y H:i:s') : '-')
                    ])->columns(3)
                    ->hidden(fn (?Customer $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Data Nasc.')
                    ->date('d/m/Y')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document')
                    ->label('CPF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
