<?php

$directory = __DIR__ . '/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$langKeys = [];

// Match @lang('word'), @lang("word"), __('word'), trans('word')
$patternLang = "/(?:@lang|trans|__)\((['\"])(.*?)\\1\)/";

// Pattern for x-component label attribute (e.g., <x-offcanvas.filter-field label="Currency" />)
$patternLabel = '/<x-[^>]+label="([^"]+)"/';

foreach ($files as $file) {
   if ($file->isFile() && $file->getExtension() === 'php') {
       $content = file_get_contents($file->getRealPath());

       // Match @lang, trans, __() functions
       preg_match_all($patternLang, $content, $matchesLang);
       if (!empty($matchesLang[2])) {
           $langKeys = array_merge($langKeys, $matchesLang[2]);
       }

       // Match x-component label attributes
       preg_match_all($patternLabel, $content, $matchesLabel);
       if (!empty($matchesLabel[1])) {
           $langKeys = array_merge($langKeys, $matchesLabel[1]);
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





function extractLabels()
{
    $directory = resource_path('views');
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    $langKeys = [];
    $patternComponent = '/<x-[^>]+(label|title)="([^"]+)"/';
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getRealPath());
            preg_match_all($patternComponent, $content, $matchesComponent);
            if (!empty($matchesComponent[2])) {
                // Merge both label and title values into the language keys
                $langKeys = array_merge($langKeys, $matchesComponent[2]);
            }
        }
    }

    $langKeys = array_unique($langKeys);
    sort($langKeys);

    // Return the labels as a JSON response or as an array
    return response()->json($langKeys);
}