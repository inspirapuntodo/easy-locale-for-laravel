<?php

namespace InspiraPuntoDo\EasyLocale\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;

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

        $this->createLocales($file_name, $directory_path, array_keys(config('app.available_locales', [])));

        $this->line("<options=reverse;fg=white>Hasta luego! 👋</>\n");
    }

    private function createLocales($file_name, $directory_path, $locales)
    {
        $base_path = base_path('lang/');

        foreach ($locales as $locale) {
            $locale_path = $base_path.$locale.'/'.$directory_path;

            $file_path = $locale_path.'/'.$file_name.'.php';
            if (!File::isDirectory(dirname($file_path))) {
                File::makeDirectory(dirname($file_path), 0777, true, true);
            }

            $sub_path = $locale.'/'.$directory_path.'/'.$file_name;

            if (File::exists($file_path)) {
                $this->line("<options=bold;fg=yellow> {$sub_path} already exists, skiping...</>\n");

                continue;
            }

            File::put($file_path, "<?php\n\nreturn [];\n");

            $this->line("<options=bold;fg=green> CREATED 🌎🌍🌏 {$sub_path} 🎉</>\n");
        }
    }
}
