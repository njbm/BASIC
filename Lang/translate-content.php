

<?php

use App\Models\ContentDetails;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Adjust settings
set_time_limit(0);

$sourceLangId = 1;
$targetLangId = 2;
$sourceLang = 'en';
$targetLang = 'es';

$count = 0;

ContentDetails::where('language_id', $sourceLangId)->chunk(50, function ($items) use ($sourceLang, $targetLang, $targetLangId) {
    foreach ($items as $item) {

        $count++;
        echo "[$count] Translating: {$item->content_id}...\n";

        $tr = new GoogleTranslate();
        $tr->setSource($sourceLang);
        $tr->setTarget($targetLang);

        $arrDetails = [];
        foreach ((array) $item->description as $key => $value) {
            $arrDetails[$key] = $tr->translate($value);
        }

        $exists = DB::table('content_details')
            ->where('content_id', $item->content_id)
            ->where('language_id', $targetLangId)
            ->exists();

        $descriptionValue = empty($arrDetails) ? null : json_encode($arrDetails);

        if ($exists) {
            DB::table('content_details')
                ->where('content_id', $item->content_id)
                ->where('language_id', $targetLangId)
                ->update(['description' => $descriptionValue]);
        } else {
            DB::table('content_details')
                ->insert([
                    'content_id' => $item->content_id,
                    'language_id' => $targetLangId,
                    'description' => $descriptionValue
                ]);
        }
    }
});

echo "Translation completed in chunks.\n";
