<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\ContentDetails;
use Illuminate\Support\Facades\DB;

class ContentTranslationService
{
    protected string $sourceLang;
    protected string $targetLang;

    public function __construct(string $sourceLang = 'en', string $targetLang = 'es')
    {
        $this->sourceLang = $sourceLang;
        $this->targetLang = $targetLang;
    }

    // This is the method the route will call
    public function translate()
    {
        set_time_limit(0); // recommended for long-running

        ContentDetails::where('language_id', 1)
            ->chunk(50, function ($items) {
                foreach ($items as $item) {
                    $tr = new GoogleTranslate();
                    $tr->setSource($this->sourceLang);
                    $tr->setTarget($this->targetLang);

                    $arrDetails = [];
                    foreach ((array)$item->description as $key => $value) {
                        $arrDetails[$key] = $tr->translate($value);
                    }

                    $exists = DB::table('content_details')
                        ->where('content_id', $item->content_id)
                        ->where('language_id', 2)
                        ->exists();

                    $descriptionValue = empty($arrDetails) ? null : json_encode($arrDetails);

                    if ($exists) {
                        DB::table('content_details')
                            ->where('content_id', $item->content_id)
                            ->where('language_id', 2)
                            ->update(['description' => $descriptionValue]);
                    } else {
                        DB::table('content_details')
                            ->insert([
                                'content_id' => $item->content_id,
                                'language_id' => 2,
                                'description' => $descriptionValue
                            ]);
                    }
                }
            });

        return 'Translation completed in chunks.';
    }
}
