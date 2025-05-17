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
use Filament\Forms\Get;

class InvoiceTemplateSettingResource extends Resource
{
    protected static ?string $model = InvoiceTemplateSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $hasCompany = $user && $user->company_id;

        return $form
            ->schema([
                Section::make(__('Invoice Template Setting'))
                    ->schema([
                        TextInput::make('key_name')
                            ->label(__('Key Name'))
                            ->required()
                            ->maxLength(255)
                            ->disabled(fn ($record) => $record !== null)
                            ->dehydrated(true),

                        Select::make('company_id')
                            ->label(__('Company'))
                            ->options(Company::pluck('legal_name', 'id'))
                            ->default($hasCompany ? $user->company_id : null)
                            ->disabled($hasCompany)
                            ->dehydrated(true)
                            ->required()
                            ->searchable(),

                        Select::make('field_type')
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
                                'checkbox' => __('Checkbox'),
                            ])
                            ->default('text')
                            ->required()
                            ->live(),

                        Section::make(__('English Value'))
                            ->schema(function (Get $get) {
                                $fieldType = $get('field_type');

                                return match ($fieldType) {
                                    'text' => [
                                        TextInput::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->required(),
                                    ],
                                    'text_area' => [
                                        Forms\Components\Textarea::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->rows(5)
                                            ->required(),
                                    ],
                                    'rich_text_editor' => [
                                        RichEditor::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->required(),
                                    ],
                                    'image' => [
                                        Forms\Components\FileUpload::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->image()
                                            ->directory('settings')
                                            ->required(),
                                    ],
                                    'color_picker' => [
                                        Forms\Components\ColorPicker::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->required(),
                                    ],
                                    'date' => [
                                        Forms\Components\DatePicker::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->required(),
                                    ],
                                    'time' => [
                                        Forms\Components\TimePicker::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->required(),
                                    ],
                                    'day' => [
                                        Select::make('value_en')
                                            ->label(__('Value (English)'))
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
                                    'checkbox' => [
                                        Forms\Components\Checkbox::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->default(false),
                                    ],
                                    default => [
                                        TextInput::make('value_en')
                                            ->label(__('Value (English)'))
                                            ->required(),
                                    ],
                                };
                            }),

                        Section::make(__('Arabic Value'))
                            ->schema(function (Get $get) {
                                $fieldType = $get('field_type');

                                return match ($fieldType) {
                                    'text' => [
                                        TextInput::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->required(),
                                    ],
                                    'text_area' => [
                                        Forms\Components\Textarea::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->rows(5)
                                            ->required(),
                                    ],
                                    'rich_text_editor' => [
                                        RichEditor::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->required(),
                                    ],
                                    'image' => [
                                        Forms\Components\FileUpload::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->image()
                                            ->directory('settings')
                                            ->required(),
                                    ],
                                    'color_picker' => [
                                        Forms\Components\ColorPicker::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->required(),
                                    ],
                                    'date' => [
                                        Forms\Components\DatePicker::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->required(),
                                    ],
                                    'time' => [
                                        Forms\Components\TimePicker::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->required(),
                                    ],
                                    'day' => [
                                        Select::make('value_ar')
                                            ->label(__('Value (Arabic)'))
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
                                    'checkbox' => [
                                        Forms\Components\Checkbox::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->default(false),
                                    ],
                                    default => [
                                        TextInput::make('value_ar')
                                            ->label(__('Value (Arabic)'))
                                            ->required(),
                                    ],
                                };
                            }),
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

                // Tables\Columns\TextColumn::make('company.legal_name')
                //     ->label(__('Company'))
                //     ->searchable()
                //     ->sortable(),

                // Tables\Columns\TextColumn::make('field_type')
                //     ->label(__('Field Type'))
                //     ->searchable()
                //     ->sortable(),

                Tables\Columns\TextColumn::make('value_en')
                    ->label(__('Value (English)'))
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->field_type === 'rich_text_editor') {
                            return $state;
                        } elseif ($record->field_type === 'image') {
                            return view('components.image-preview', ['url' => $state])->render();
                        }
                        return $state;
                    })
                    ->lineClamp(1)
                    ->sortable(),

                Tables\Columns\TextColumn::make('value_ar')
                    ->label(__('Value (Arabic)'))
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->field_type === 'rich_text_editor') {
                            return $state;
                        } elseif ($record->field_type === 'image') {
                            return view('components.image-preview', ['url' => $state])->render();
                        }
                        return $state;
                    })
                    ->lineClamp(1)
                    ->sortable(),

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
