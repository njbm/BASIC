<?php

use App\Models\PageDetail;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

set_time_limit(0);

$sourceLangId = 1;
$targetLangId = 2;
$sourceLang = 'en';
$targetLang = 'es';
$now = now();

$count = 0;
PageDetail::where('language_id', $sourceLangId)->chunk(50, function ($items) use ($sourceLang, $targetLang, $targetLangId, $now,$count) {
    foreach ($items as $item) {

        $count++;
        echo "[$count] Translating: {$item->name}...\n";

        $tr = new GoogleTranslate();
        $tr->setSource($sourceLang);
        $tr->setTarget($targetLang);

        $translatedName = $tr->translate($item->name);

        $exists = DB::table('page_details')
            ->where('page_id', $item->page_id)
            ->where('language_id', $targetLangId)
            ->exists();

        $data = [
            'page_id'     => $item->page_id,
            'language_id' => $targetLangId,
            'name'        => $translatedName,
            'content'     => $item->content,
            'sections'    => is_null($item->sections)
                ? null
                : (is_array($item->sections)
                    ? json_encode($item->sections)
                    : $item->sections),
            'updated_at'  => $now,
        ];

        if ($exists) {
            DB::table('page_details')
                ->where('page_id', $item->page_id)
                ->where('language_id', $targetLangId)
                ->update($data);
        } else {
            $data['created_at'] = $now;
            DB::table('page_details')->insert($data);
        }
    }
});

echo "Page translation completed (only name translated).\n";
