<?php

namespace Iammuttaqi\FilamentFakester\Actions;

use Filament\Actions\Action;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeRowTableAction
{
    public static function register(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table->recordActions([
                Action::make('fakester-fake-row')
                    ->label('Fake row')
                    ->icon('heroicon-o-sparkles')
                    ->color('gray')
                    ->visible(fn () => config('fakester.enabled') && static::modelHasFactory($table))
                    ->action(function (Model $record): void {
                        $attrs = $record::factory()->definition();
                        $record->update($attrs);
                    }),
            ], position: RecordActionsPosition::AfterColumns);
        });
    }

    protected static function modelHasFactory(Table $table): bool
    {
        $model = $table->getModel();

        return $model && in_array(HasFactory::class, class_uses_recursive($model), true);
    }
}
