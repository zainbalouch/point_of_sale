<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InvoiceTemplateSettingResource\Pages;
use App\Filament\Admin\Resources\InvoiceTemplateSettingResource\RelationManagers;
use App\Models\InvoiceTemplateSetting;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class InvoiceTemplateSettingResource extends Resource
{
    protected static ?string $model = InvoiceTemplateSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $hasCompany = $user && $user->company_id;

        return $form
            ->columns([
                'default' => 1,
                'sm' => 3,
                'lg' => 3,
            ])
            ->schema([
                Section::make(__('Invoice Template Setting'))
                    ->columnSpan([
                        'default' => 1,
                        'sm' => 3,
                        'lg' => 3,
                    ])
                    ->schema([
                        TextInput::make('key_name')
                            ->label(__('Key Name'))
                            ->required()
                            ->maxLength(255)
                            ->disabled(fn ($get) => $get('id') !== null)
                            ->dehydrated(true),

                        Select::make('company_id')
                            ->label(__('Company'))
                            ->options(Company::pluck('legal_name', 'id'))
                            ->default($hasCompany ? $user->company_id : null)
                            ->disabled($hasCompany)
                            ->dehydrated(true)
                            ->required()
                            ->searchable(),

                        RichEditor::make('value_en')
                            ->label(__('Value (English)'))
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 3,
                                'lg' => 3,
                            ]),

                        RichEditor::make('value_ar')
                            ->label(__('Value (Arabic)'))
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 3,
                                'lg' => 3,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key_name')
                    ->label(__('Key Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('company.legal_name')
                    ->label(__('Company'))
                    ->searchable()
                    ->sortable(),

                // Tables\Columns\TextColumn::make('value_en')
                //     ->label(__('Value (English)'))
                //     ->formatStateUsing(fn ($state) => strip_tags($state))
                //     ->limit(50)
                //     ->searchable(),

                // Tables\Columns\TextColumn::make('value_ar')
                //     ->label(__('Value (Arabic)'))
                //     ->formatStateUsing(fn ($state) => strip_tags($state))
                //     ->limit(50)
                //     ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListInvoiceTemplateSettings::route('/'),
            'create' => Pages\CreateInvoiceTemplateSetting::route('/create'),
            'edit' => Pages\EditInvoiceTemplateSetting::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Invoice Template Setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Invoice Template Settings');
    }

    public static function getNavigationGroup(): string
    {
        return __('Invoices');
    }
}
