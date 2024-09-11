<?php

declare(strict_types=1);

namespace InspiraPuntoDo\EasyLocale;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use InspiraPuntoDo\EasyLocale\Commands\DiffLocaleCommand;
use InspiraPuntoDo\EasyLocale\Commands\MakeLocaleCommand;

/**
 * @see \InspiraPuntoDo\EasyLocaleForLaravelManager
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // commands
        $this->registerCommands();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            Factory::class,
            'easy-locale',
        ];
    }

    private function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MakeLocaleCommand::class,
            DiffLocaleCommand::class,
        ]);
    }
}
