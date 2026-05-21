<?php

namespace Iammuttaqi\FilamentFakester\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BulkFakeRecordsAction
{
    public static function register(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table->headerActions([
                Action::make('fakester-bulk-fake')
                    ->label('Create fake rows')
                    ->icon('heroicon-o-sparkles')
                    ->color('gray')
                    ->visible(fn () => config('filament-fakester.enabled') && static::modelHasFactory($table))
                    ->schema([
                        TextInput::make('count')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->default(config('filament-fakester.default_count', 25))
                            ->required(),
                    ])
                    ->action(function (array $data) use ($table): void {
                        $model = $table->getModel();
                        $model::factory()->count((int) $data['count'])->create();

                        Notification::make()
                            ->title("Created {$data['count']} fake {$model} records")
                            ->success()
                            ->send();
                    }),
            ]);
        });
    }

    protected static function modelHasFactory(Table $table): bool
    {
        $model = $table->getModel();

        return $model && in_array(HasFactory::class, class_uses_recursive($model), true);
    }
}
