<?php

declare(strict_types=1);

namespace InspiraPuntoDo\EasyLocale\Facades;

use Illuminate\Support\Facades\Facade;

final class EasyLocale extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'easey-locale';
    }
}
