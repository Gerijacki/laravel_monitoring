<?php
namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\DateRangeFilter;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->sortable()->searchable(),

                TextColumn::make('project.name')
                    ->label('Projecte')
                    ->sortable()->searchable(),

                TextColumn::make('title')
                    ->limit(60)->sortable()->searchable(),

                TextColumn::make('occurred_at')
                    ->label('Data')
                    ->sortable()->since(),

                TextColumn::make('created_at')
                    ->label('Creat')
                    ->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'error' => 'Error',
                        'warning' => 'Warning',
                        'info' => 'Info',
                        'debug' => 'Debug',
                    ])
                    ->label('Tipus'),

                SelectFilter::make('project')
                    ->relationship('project', 'name')
                    ->label('Projecte'),

                //DateRangeFilter::make('occurred_at')->label('Rang de dates'),
            ])
            ->defaultSort('occurred_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
        ];
    }
}
