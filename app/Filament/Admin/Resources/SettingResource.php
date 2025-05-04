<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource\Pages\CreateSetting;
use App\Filament\Admin\Resources\SettingResource\Pages\EditSetting;
use App\Filament\Admin\Resources\SettingResource\Pages\ListSettings;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Add translation methods
    public static function getModelLabel(): string
    {
        return __('Setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Other Settings');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }

    // Disable create functionality
    // public static function canCreate(): bool
    // {
    //     return false;
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label(__('Key'))
                    ->disabled(fn ($record) => $record !== null)
                    ->required(),
                Forms\Components\Select::make('field_type')
                    ->label(__('Field Type'))
                    ->options([
                        'text' => __('Text'),
                        'text_area' => __('Text Area'),
                        'rich_text_editor' => __('Rich Text Editor'),
                        'image' => __('Image'),
                        'color_picker' => __('Color Picker'),
                        'date' => __('Date'),
                        'time' => __('Time'),
                        'day' => __('Day of Week'),
                        'currency' => __('Currency'),
                        'payment_method' => __('Payment Method'),
                    ])
                    ->default('text')
                    ->required()
                    ->live(),
                Forms\Components\Section::make()
                    ->schema(function (Get $get) {
                        $fieldType = $get('field_type');

                        return match ($fieldType) {
                            'text' => [
                                Forms\Components\TextInput::make('value')
                                    ->label(__('Value'))
                                    ->required(),
                            ],
                            'text_area' => [
                                Forms\Components\Textarea::make('value')
                                    ->label(__('Value'))
                                    ->rows(5)
                                    ->required(),
                            ],
                            'rich_text_editor' => [
                                Forms\Components\RichEditor::make('value')
                                    ->label(__('Value'))
                                    ->required(),
                            ],
                            'image' => [
                                Forms\Components\FileUpload::make('value')
                                    ->label(__('Value'))
                                    ->image()
                                    ->directory('settings')
                                    ->required(),
                            ],
                            'color_picker' => [
                                Forms\Components\ColorPicker::make('value')
                                    ->label(__('Value'))
                                    ->required(),
                            ],
                            'date' => [
                                Forms\Components\DatePicker::make('value')
                                    ->label(__('Value'))
                                    ->required(),
                            ],
                            'time' => [
                                Forms\Components\TimePicker::make('value')
                                    ->label(__('Value'))
                                    ->required(),
                            ],
                            'day' => [
                                Forms\Components\Select::make('value')
                                    ->label(__('Value'))
                                    ->options([
                                        '0' => __('Sunday'),
                                        '1' => __('Monday'),
                                        '2' => __('Tuesday'),
                                        '3' => __('Wednesday'),
                                        '4' => __('Thursday'),
                                        '5' => __('Friday'),
                                        '6' => __('Saturday'),
                                    ])
                                    ->required(),
                            ],
                            'currency' => [
                                Forms\Components\Select::make('value')
                                    ->label(__('Currency'))
                                    ->options(function () {
                                        return Currency::pluck('name', 'code')->toArray();
                                    })
                                    ->searchable()
                                    ->preload(),
                            ],
                            'payment_method' => [
                                Forms\Components\Select::make('value')
                                    ->label(__('Payment Method'))
                                    ->options(function () {
                                        return PaymentMethod::pluck('name_en', 'name_en')->toArray();
                                    })
                                    ->searchable()
                                    ->preload(),
                            ],

                            default => [
                                Forms\Components\TextInput::make('value')
                                    ->label(__('Value'))
                                    ->required(),
                            ],
                        };
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(__('Key'))
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('field_type')
                    ->label(__('Field Type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('Value'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('Edit')),
                Tables\Actions\DeleteAction::make()
                    ->label(__('Delete')),
            ])
            ->bulkActions([
                // Removed bulk actions to prevent deletion
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
            'index' => ListSettings::route('/'),
            'edit' => EditSetting::route('/{record}/edit'),
            'create' => CreateSetting::route('/create'),
        ];
    }
}
