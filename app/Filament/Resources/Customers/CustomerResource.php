<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\CustomerResource\Pages;
use App\Filament\Resources\Customers\CustomerResource\RelationManagers;
use App\Models\Customers\Customer;
use Filament\Forms;
use Filament\Forms\Form;
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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->nullable()
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->maxLength(255),
                PhoneNumber::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birth_date'),
                Document::make('document')
                    ->cpf()
                    ->unique(ignoreRecord: true),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Repeater::make('addresses')
                            ->label('Endereços')
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
                                    ->required()
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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
}
