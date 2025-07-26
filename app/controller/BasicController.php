




Route::get('/trans', function () {
    set_time_limit(0); // Still recommended

    \App\Models\ContentDetails::where('language_id', 1)->chunk(50, function ($items) {
        foreach ($items as $item) {
            $tr = new GoogleTranslate();
            $tr->setSource('en');
            $tr->setTarget('es');

            $arrDetails = [];
            foreach ((array)$item->description as $key => $value) {
                $arrDetails[$key] = $tr->translate($value);
            }

            $exists = \DB::table('content_details')
                ->where('content_id', $item->content_id)
                ->where('language_id', 2)
                ->exists();

            $descriptionValue = empty($arrDetails) ? null : json_encode($arrDetails);

            if ($exists) {
                \DB::table('content_details')
                    ->where('content_id', $item->content_id)
                    ->where('language_id', 2)
                    ->update(['description' => $descriptionValue]);
            } else {
                \DB::table('content_details')
                    ->insert(['content_id' => $item->content_id, 'language_id' => 2, 'description' => $descriptionValue]);
            }
        }
    });

    return 'Translation completed in chunks.';
});