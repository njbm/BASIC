<?php

use Stichoza\GoogleTranslate\GoogleTranslate;

require 'vendor/autoload.php';

/**
 * Translate words from a given PHP file.
 *
 * @param array|null $languages List of target languages with ISO codes (optional)
 * @param string|null $filePath Path to the file with words to translate (optional)
 */
function translateWords(?array $languages = null, ?string $filePath = null)
{
    if ($languages === null) {
        $languages = [
            'es' => 'Spanish'
        ];
    }
    if ($filePath === null) {
        $filePath = __DIR__ . '/config/test.php';
    }

    if (!file_exists($filePath)) {
        die("❌ The file '$filePath' was not found. Please provide a valid file.\n");
    }

    $words = include $filePath;

    if (!is_array($words)) {
        die("❌ Invalid file format. It should return an array.\n");
    }



    // 🔁 Step 1: Move words into en.json
    $enLangPath = __DIR__ . '/resources/lang/en.json';
    $langDir = dirname($enLangPath);

    // Make sure lang dir exists
    if (!is_dir($langDir)) {
        mkdir($langDir, 0777, true);
    }

    // Convert words to ["Hello" => "Hello"] format
    $normalized = [];
    foreach ($words as $word) {
        $normalized[$word] = $word;
    }

    // Load existing en.json if available
    $existing = [];
    if (file_exists($enLangPath)) {
        $existing = json_decode(file_get_contents($enLangPath), true) ?? [];
    }

    // Merge: keep existing values
    $merged = $existing + $normalized;
    // Save updated en.json
    file_put_contents($enLangPath, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "📁 Base language file updated: resources/lang/en.json\n";



    $totalWords = count($words); // Get the total number of words to be translated

    foreach ($languages as $langCode => $langName) {
        $translator = new GoogleTranslate($langCode);
        $translatedWords = [];

        echo "\n🗣️ Translating to $langName...\n";

        $batchSize = 10; // Set batch size
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
            sleep(1);

            // Display progress bar
            $progress = floor(($wordCount / $totalWords) * 100);
            echo "🔄 Progress: $progress% ($wordCount/$totalWords words)\n";
        }

        // Create lang directory if it doesn't exist
        $langPath = __DIR__ . "/resources/lang";
        if (!is_dir($langPath)) {
            mkdir($langPath, 0777, true);
        }

        // Save translations in lang/{langCode}.json
        $filePath = "$langPath/{$langCode}.json";
        $content = json_encode($translatedWords, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents($filePath, $content);
        echo "✅ Translations saved: $filePath\n";
    }

    echo "🎉 All language files generated successfully!\n";
}

/*run default*/
translateWords();



/*for extra languages and path*/

//$languages = ['id'=> 'Indonesia','es'=>'Spanish'];
//$filePath = __DIR__ . "/config/test.php";
//translateWords($languages,$filePath);
