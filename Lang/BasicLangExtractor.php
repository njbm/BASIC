<?php

$directory = __DIR__ . '/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$langKeys = [];

// Match @lang('word'), @lang("word"), __('word'), trans('word')
$pattern = "/(?:@lang|trans|__)\((['\"])(.*?)\\1\)/";

foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        preg_match_all($pattern, $content, $matches);
        if (!empty($matches[2])) {
            $langKeys = array_merge($langKeys, $matches[2]);
        }
    }
}

// Remove duplicates & sort
$langKeys = array_unique($langKeys);
sort($langKeys);

// Save to config/test.php (always use double quotes)
$configPath = __DIR__ . '/config/test.php';
$formatted = "<?php\n\nreturn [\n    \"" . implode("\",\n    \"", $langKeys) . "\",\n];\n";

file_put_contents($configPath, $formatted);

echo "✅ Language keys extracted and saved to config/test.php (always in double quotes)\n";



