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

        $this->line('Creating localization files for: '.$name);

        $file_name      = end($locale_parts);
        $directory_path = implode('/', array_slice($locale_parts, 0, -1));

        $this->createLocales($file_name, $directory_path, array_keys(config('app.available_locales', [])));
    }

    private function createLocales($file_name, $directory_path, $locales)
    {
        $base_path = resource_path('lang/');

        foreach ($locales as $locale) {
            $locale_path = $base_path.$locale.'/'.$directory_path;
            if (!File::isDirectory(dirname($locale_path))) {
                File::makeDirectory(dirname($locale_path), 0777, true, true);
            }

            $file_path = $locale_path.'/'.$file_name.'.php';

            if (!File::exists($file_path)) {
                File::put($file_path, "<?php\n\nreturn [];\n");

                $sub_path = $locale.'/'.$directory_path.'/'.$file_name;
                $this->line("<options=bold;fg=green> {$sub_path} CREATED </> 🌎🌍🌏🎉\n");
            }
        }
    }
}
