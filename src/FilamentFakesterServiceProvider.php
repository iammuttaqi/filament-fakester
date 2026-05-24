<?php

namespace Iammuttaqi\FilamentFakester;

use Iammuttaqi\FilamentFakester\Concerns\RegistersFakerHints;
use Iammuttaqi\FilamentFakester\Support\MatcherRegistry;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFakesterServiceProvider extends PackageServiceProvider
{
    use RegistersFakerHints;

    public static string $name = 'filament-fakester';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('iammuttaqi/filament-fakester');
            });
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(MatcherRegistry::class);
    }

    public function packageBooted(): void
    {
        if (config('filament-fakester.enabled')) {
            $this->registerHintActions();
        }
    }
}
