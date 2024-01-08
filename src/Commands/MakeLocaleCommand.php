<?php

namespace InspiraPuntoDo\EasyLocale\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use InspiraPuntoDo\EasyLocale\Enums\FileCreationStatusEnum;

final class MakeLocaleCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'make:locale {name}';

    protected $description = 'Create localization files at the given path';

    public function handle()
    {
        $name = $this->argument('name');
        $name = str_replace('.', '/', $name);

        $locale_parts = explode('/', $name);

        // clean empty elements
        $locale_parts = array_filter($locale_parts);

        if (empty($locale_parts)) {
            return;
        }

        $this->line("<options=reverse;fg=white>Creating localization files for: {$name}</>\n");

        $file_name      = end($locale_parts);
        $directory_path = implode('/', array_slice($locale_parts, 0, -1));

        $locales = array_keys(config('app.available_locales', []));

        foreach ($locales as $locale) {
            $creation_status = $this->createLocale($file_name, $directory_path, $locale);

            $file_relative_path = implode('/', array_filter([$locale, $directory_path, $file_name])).'.php';

            match ($creation_status) {
                FileCreationStatusEnum::ALREADY_EXISTS => $this->line("<options=bold;fg=yellow> {$file_relative_path} already exists, skiping...</>\n"),
                FileCreationStatusEnum::CREATED => $this->line("<options=bold;fg=green> CREATED 🌎🌍🌏 {$file_relative_path} 🎉</>\n"),
                default => $this->line("<options=bold;fg=red> ERROR 🚨 {$file_relative_path} 🚨</>\n"),
            };
        }

        $this->line("<options=reverse;fg=white>Hasta luego! 👋</>\n");
    }

    private function createLocale($file_name, $directory_path, $locale): FileCreationStatusEnum
    {
        $base_path = base_path('lang/');

        $locale_path = $base_path.$locale;

        if (!empty($directory_path)) {
            $locale_path .= '/'.$directory_path;
        }

        $file_path = $locale_path.'/'.$file_name.'.php';
        if (!File::isDirectory(dirname($file_path))) {
            File::makeDirectory(dirname($file_path), 0777, true, true);
        }

        if (File::exists($file_path)) {
            return FileCreationStatusEnum::ALREADY_EXISTS;
        }

        if (File::put($file_path, "<?php\n\nreturn [];\n")) {
            return FileCreationStatusEnum::CREATED;
        }

        return FileCreationStatusEnum::ERROR;
    }
}
