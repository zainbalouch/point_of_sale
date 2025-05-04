<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Company Information'))
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                TextInput::make('legal_name')
                                    ->label(__('Legal Name'))
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('tax_number')
                                    ->label(__('Tax Number'))
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Forms\Components\Grid::make()
                            ->schema([
                                TextInput::make('website')
                                    ->label(__('Website'))
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label(__('Email'))
                                    ->email()
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Forms\Components\Grid::make()
                            ->schema([
                                TextInput::make('phone_number')
                                    ->label(__('Phone Number'))
                                    ->tel()
                                    ->maxLength(20),

                                FileUpload::make('logo')
                                    ->label(__('Logo'))
                                    ->image()
                                    ->directory('company-logos')
                                    ->visibility('public')
                                    ->maxSize(2048),
                            ])
                            ->columns(2),

                        Toggle::make('is_active')
                            ->label(__('Active Status'))
                            ->helperText(__('Whether the company is active'))
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                Tables\Columns\ImageColumn::make('logo')
                    ->label(__('Logo')),

                Tables\Columns\TextColumn::make('legal_name')
                    ->label(__('Legal Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tax_number')
                    ->label(__('Tax Number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('Phone Number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('website')
                    ->label(__('Website'))
                    ->url(fn (Company $record): ?string => $record->website)
                    ->openUrlInNewTab()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean()
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

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('is_active')
                    ->label(__('Active Status'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Company');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Companies');
    }

    public static function getNavigationGroup(): string
    {
        return __('Administration');
    }

    public static function canCreate(): bool
    {
        $user = Filament::auth()->user();
        return $user && Gate::allows('create_company');
    }

    public static function canDeleteAny(): bool
    {
        $user = Filament::auth()->user();
        return $user && Gate::allows('delete_any_company');
    }
}
