<?php

namespace InspiraPuntoDo\EasyLocale\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use SplStack;

final class DiffLocaleCommand extends Command implements PromptsForMissingInput {
    protected $signature   = 'locale:diff';
    protected $description = 'Find differences between locales';

    public function __construct(private Filesystem $filesystem) {
        parent::__construct();
    }

    public function handle() {
        $missing_keys_count = 0;
        $locales    = array_keys(config('app.available_locales', []));

        $key_paths = [];

        foreach ($locales as $locale) {
            $locale_base_path = app()->langPath()."/$locale/";
            foreach ($this->filesystem->allFiles($locale_base_path) as $file) {
                if ('php' !== $file->getExtension()) {
                    continue;
                }

                $file_parts = array_filter([
                    $file->getRelativePath(),
                    $file->getFilenameWithoutExtension(),
                ]);

                $key_path = str_replace($locale_base_path, '', implode('/', $file_parts));

                if (in_array($key_path, $key_paths, true)) {
                    continue;
                }

                $key_paths[] = $key_path;
            }
        }

        $dot_keys = [];
        foreach ($locales as $locale) {
            foreach ($key_paths as $key_path) {
                foreach ($this->dotKeys(trans()->getLoader()->load($locale, $key_path)) as $dot_key) {
                    if (in_array("{$key_path}.{$dot_key}", $dot_keys)) {
                        continue;
                    }

                    $dot_keys[] = "{$key_path}.{$dot_key}";
                }
            }
        }

        foreach ($locales as $locale) {
            foreach ($dot_keys as $dot_key) {
                if (!trans()->hasForLocale($dot_key, $locale)) {
                    $missing_keys_count++;
                    $this->line("Translation for key: <options=bold;fg=red>{$dot_key}</> MISSING on locale <options=bold>{$locale}</>\n");
                }
            }
        }

        if ($missing_keys_count > 0) {
            $this->error("You have missing {$missing_keys_count} translation\s");
            return self::FAILURE;
        }

        $this->info('No differences found in your translation files');
        return self::SUCCESS;
    }

    private function dotKeys(array $content) {
        $dot_keys = [];

        $array_keys_stack = new SplStack;

        foreach (array_keys($content) as $key) {
            $array_keys_stack->push($key);
        }

        while (!$array_keys_stack->isEmpty()) {
            $key = $array_keys_stack->pop();

            $children_key = data_get($content, $key);

            if (!is_array($children_key)) {
                $dot_keys[] = $key;

                continue;
            }

            foreach (array_keys($children_key) as $child_key) {
                $array_keys_stack->push("{$key}.{$child_key}");
            }
        }

        return $dot_keys;
    }
}
