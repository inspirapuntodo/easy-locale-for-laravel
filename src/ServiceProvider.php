<?php

declare(strict_types=1);

namespace InspiraPuntoDo\EasyLocale;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

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
            'easey-locale',
        ];
    }

    private function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MakeLocaleCommand::class,
        ]);
    }
}