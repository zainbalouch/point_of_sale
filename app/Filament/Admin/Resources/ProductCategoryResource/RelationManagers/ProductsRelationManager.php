<?php

namespace App\Filament\Admin\Resources\ProductCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Currency;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name_en';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic information')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('name_ar')
                            ->label('Name (Arabic)')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\TextInput::make('code')
                            ->label('Code')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Regular Price')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0),
                                
                                Forms\Components\TextInput::make('sale_price')
                                    ->label('Sale Price')
                                    ->numeric()
                                    ->minValue(0)
                                    ->lte('price'),
                                
                                Forms\Components\Select::make('currency_id')
                                    ->label('Currency')
                                    ->relationship('currency', 'code')
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                            ])
                            ->columns(3),
                    ]),
                
                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->rows(3),
                        
                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (Arabic)')
                            ->rows(3),
                    ])
                    ->columns(2)
                    ->collapsible(),
                
                Forms\Components\Section::make('Organization')
                    ->schema([
                        Forms\Components\Select::make('point_of_sale_id')
                            ->label('Point of Sale')
                            ->relationship('pointOfSale', 'name_en')
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image_url')
                            ->label('Product Image')
                            ->image()
                            ->directory('products')
                            ->visibility('public')
                            ->imagePreviewHeight('150')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular(false)
                    ->defaultImageUrl(fn () => asset('images/default-product.png')),
                
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money(fn ($record) => $record->currency?->code ?? 'USD')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('pointOfSale.name_en')
                    ->label('Point of Sale')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                
                Tables\Filters\SelectFilter::make('point_of_sale_id')
                    ->relationship('pointOfSale', 'name_en')
                    ->label('Point of Sale')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['product_category_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name_en');
    }
} 