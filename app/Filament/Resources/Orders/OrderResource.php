<?php

namespace App\Filament\Resources\Orders;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodsEnum;
use App\Filament\Resources\Orders\OrderResource\Pages;
use App\Filament\Resources\Orders\OrderResource\RelationManagers;
use App\Models\Customers\Customer;
use App\Models\Orders\Order;
use App\Models\Services\Product;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $modelLabel = 'pedidos';

    protected static ?string $navigationGroup = 'Serviços';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Wizard::make([
                    Components\Wizard\Step::make('items')
                        ->label('Items')
                        ->schema([
                            Components\Select::make('customer_id')
                                ->label('Cliente')
                                ->searchable()
                                ->relationship('customer', 'name')
                                ->required()
                                ->live(),
                            Components\Repeater::make('items')
                                ->required()
                                ->columns(3)
                                ->addActionLabel('Adicionar item')
                                ->hidden(fn (Get $get) => !$get('customer_id'))
                                ->schema([
                                    Components\Select::make('item')
                                        ->options(Product::all()->pluck('name', 'id'))
                                        ->native(false)
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(fn (?int $state, Get $get, Set $set) => $set(
                                            'price',
                                            number_format(Product::find($state)?->price * $get('quantity') / 100, 2, ',', '.')
                                        )),

                                    Components\TextInput::make('quantity')
                                        ->label('Quantidade')
                                        ->required()
                                        ->numeric()
                                        ->default(1)
                                        ->disabled(fn (Get $get) => $get('item') === null)
                                        ->live()
                                        ->afterStateUpdated(fn (?int $state, Get $get, Set $set) => $set(
                                            'price',
                                            number_format(Product::find($get('item'))->price * $state / 100, 2, ',', '.')
                                        )),

                                    Money::make('price')
                                        ->label('Preço')
                                        ->required()
                                        ->readOnly()
                                        ->dehydrateStateUsing(fn (string $state): string => str($state)->remove([',', '.'])),

                                    Components\Select::make('pet')
                                        ->options(fn (Get $get) => Customer::find($get('../../customer_id'))->pets->pluck('name', 'id'))
                                        ->hidden(fn (Get $get) => !Product::find($get('item'))?->is_service)
                                        ->native(false)
                                        ->columnSpanFull()
                                        ->required()
                                ]),
                        ]),
                    Components\Wizard\Step::make('Informações')
                        ->schema([
                            Components\RichEditor::make('observations')
                                ->label('Observação'),
                        ])->afterValidation(function (Get $get, Set $set) {
                            $total_price = collect($get('items'))->map(fn (array $item) => str($item['price'])->remove([',', '.'])->toInteger())->values()->sum();

                            $formated_total_price = number_format($total_price / 100, 2, ',', '.');

                            $set('total', $formated_total_price);
                        }),
                    Components\Wizard\Step::make('Pagamento')
                        ->schema([
                            Components\Select::make('status')
                                ->native(false)
                                ->options(OrderStatusEnum::class)
                                ->required(),
                            Components\Select::make('payment_method')
                                ->label('Método de pagamento')
                                ->native(false)
                                ->options(PaymentMethodsEnum::class)
                                ->required(),
                            Money::make('total')
                                ->label('Total')
                                ->required()
                                ->readOnly()
                                ->dehydrateStateUsing(fn (string $state): string => str($state)->remove([',', '.'])),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
