<?php

use Stichoza\GoogleTranslate\GoogleTranslate;

require 'vendor/autoload.php';

// Define target languages (ISO codes)
$languages = [
    'es' => 'Spanish',
//    'id' => 'Indonesian',
];

// Load extracted words from config/test.php
$configFile = __DIR__ . '/config/test.php';

if (!file_exists($configFile)) {
    die("❌ config/test.php not found. Run extraction script first!\n");
}

$words = include $configFile;

if (!is_array($words)) {
    die("❌ Invalid config/test.php format. It should return an array.\n");
}

$totalWords = count($words); // Get the total number of words to be translated

foreach ($languages as $langCode => $langName) {
    $translator = new GoogleTranslate($langCode);
    $translatedWords = [];

    echo "\n🗣️ Translating to $langName...\n";

    $batchSize = 10; // Set batch size to 500 words
    $batchCount = ceil($totalWords / $batchSize); // Number of batches
    $wordCount = 1; // Start word count

    for ($batch = 0; $batch < $batchCount; $batch++) {
        $start = $batch * $batchSize;
        $batchWords = array_slice($words, $start, $batchSize);

        echo "🌀 Translating batch " . ($batch + 1) . " of $batchCount...\n";

        foreach ($batchWords as $word) {
            try {
                $translatedWords[$word] = $translator->translate($word);
            } catch (Exception $e) {
                echo "⚠️ Error translating '$word' to $langName: " . $e->getMessage() . "\n";
                $translatedWords[$word] = $word; // Fallback to original text
            }
            $wordCount++;
        }

        // Add a small delay between batches to avoid rate limits
        sleep(1); // Adjust the sleep time if needed

        // Display progress bar
        $progress = floor(($wordCount / $totalWords) * 100);
        echo "🔄 Progress: $progress% ($wordCount/$totalWords words)\n";
    }

    // Create lang directory if it doesn't exist
    $langPath = __DIR__ . "/resources/lang";
    if (!is_dir($langPath)) {
        mkdir($langPath, 0777, true);
    }

    // Save translations in lang/es.json
    $filePath = "$langPath/{$langCode}.json";
    $content = json_encode($translatedWords, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    file_put_contents($filePath, $content);
    echo "✅ Translations saved: $filePath\n";
}

echo "🎉 All language files generated successfully!\n";




















//
//use Stichoza\GoogleTranslate\GoogleTranslate;
//
//require 'vendor/autoload.php';
//
//// Define target languages (ISO codes)
//$languages = [
//    'es' => 'Spanish',
////    'id' => 'Indonesian',
//];
//
//// Load extracted words from config/test.php
//$configFile = __DIR__ . '/config/test.php';
//
//if (!file_exists($configFile)) {
//    die("❌ config/test.php not found. Run extraction script first!\n");
//}
//
//$words = include $configFile;
//
//if (!is_array($words)) {
//    die("❌ Invalid config/test.php format. It should return an array.\n");
//}
//
//foreach ($languages as $langCode => $langName) {
//    $translator = new GoogleTranslate($langCode);
//    $translatedWords = [];
//
//    foreach ($words as $word) {
//        try {
//            $translatedWords[$word] = $translator->translate($word);
//        } catch (Exception $e) {
//            echo "⚠️ Error translating '$word' to $langName: " . $e->getMessage() . "\n";
//            $translatedWords[$word] = $word; // Fallback to original text
//        }
//    }
//
//    // Create lang directory if it doesn't exist
//    $langPath = __DIR__ . "/resources/lang";
//    if (!is_dir($langPath)) {
//        mkdir($langPath, 0777, true);
//    }
//
//    // Save translations in lang/es.json
//    $filePath = "$langPath/{$langCode}.json";
//    $content = json_encode($translatedWords, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//
//    file_put_contents($filePath, $content);
//    echo "✅ Translations saved: $filePath\n";
//}
//
//echo "🎉 All language files generated successfully!\n";
