<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            Select::make('project_category_id')
                ->relationship('category', 'name')
                ->label('Categoria')
                ->searchable(),

            TextInput::make('slug')
                ->disabled()
                ->columnSpanFull(),

            TextInput::make('api_token')
                ->disabled()
                ->label('API Token')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('category.name')->label('Categoria')->sortable()->searchable(),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('api_token')->label('Token'),
                TextColumn::make('created_at')->label('Creat')->date(),
            ])
            ->filters([
                SelectFilter::make('project_category_id')
                    ->relationship('category', 'name')
                    ->label('Categoria'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('Regenerar token')
                    ->action(function (Project $record) {
                        $record->update([
                            'api_token' => Str::random(60),
                        ]);
                    })
                    ->label('Regenerar token')
                    ->icon('heroicon-o-key')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->tooltip('Regenera el token de l’API'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
