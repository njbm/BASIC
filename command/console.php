<?php





// Theme replace 

Artisan::command('theme:replace', function () {
    $old = 'light';
    $new = 'spark';

    // 1. Rename assets/themes/light ➜ assets/themes/spark
    $themeAssetsOld = base_path("assets/themes/{$old}");
    $themeAssetsNew = base_path("assets/themes/{$new}");
    if (File::isDirectory($themeAssetsOld)) {
        File::moveDirectory($themeAssetsOld, $themeAssetsNew);
        $this->info("Renamed folder: assets/themes/{$old} ➜ {$new}");
    } else {
        $this->warn("Directory not found: assets/themes/{$old}");
    }

    // 2. Rename assets/preview/light ➜ assets/preview/spark
    $previewOld = base_path("assets/preview/{$old}");
    $previewNew = base_path("assets/preview/{$new}");
    if (File::isDirectory($previewOld)) {
        File::moveDirectory($previewOld, $previewNew);
        $this->info("Renamed folder: assets/preview/{$old} ➜ {$new}");
    } else {
        $this->warn("Directory not found: assets/preview/{$old}");
    }

    // 3. Rename resource/views/themes/light ➜ resource/views/themes/spark
    $themeOld = resource_path("views/themes/{$old}");
    $themeNew = resource_path("views/themes/{$new}");
    if (File::isDirectory($themeOld)) {
        File::moveDirectory($themeOld, $themeNew);
        $this->info("Renamed folder: resource/views/themes/{$old} ➜ {$new}");
    } else {
        $this->warn("Directory not found: resource/views/themes/{$old}");
    }

    // Update `basic_controls` table (optional)
    DB::table('basic_controls')->where('theme', $old)->update(['theme' => $new]);
    // Update `pages` table
    DB::table('pages')->where('template_name', $old)->update(['template_name' => $new]);
    // Update `contents` table
    DB::table('contents')->where('theme', $old)->update(['theme' => $new]);

    // Update `manage_menus` table
    DB::table('manage_menus')->where('theme', $old)->update(['theme' => $new]);


    //for extra theme add
    $date = now();
    $bulkInsert = [
        [
            'theme' => 'orbit',
            'menu_section' => 'header',
            'menu_items' => json_encode([]),
            'created_at' => $date,
            'updated_at' => $date,
        ],
        [
            'theme' => 'orbit',
            'menu_section' => 'footer',
            'menu_items' => json_encode([]),
            'created_at' => $date,
            'updated_at' => $date,
        ]
    ];
    DB::table('manage_menus')->insert($bulkInsert);


    $this->info("✅ Theme renaming completed.");
});






// change required forlder 

Artisan::command('theme:rename-folders', function () {
    $old = 'light';
    $new = 'rivo';

    // 1. Rename assets/themes/green ➜ assets/themes/nova
    $themeAssetsOld = base_path("assets/themes/{$old}");
    $themeAssetsNew = base_path("assets/themes/{$new}");
    if (File::isDirectory($themeAssetsOld)) {
        File::moveDirectory($themeAssetsOld, $themeAssetsNew);
        $this->info("Renamed folder: assets/themes/{$old} ➜ {$new}");
    } else {
        $this->warn("Directory not found: assets/themes/{$old}");
    }

    // 2. Rename assets/preview/green ➜ assets/preview/nova
    $previewOld = base_path("assets/preview/{$old}");
    $previewNew = base_path("assets/preview/{$new}");
    if (File::isDirectory($previewOld)) {
        File::moveDirectory($previewOld, $previewNew);
        $this->info("Renamed folder: assets/preview/{$old} ➜ {$new}");
    } else {
        $this->warn("Directory not found: assets/preview/{$old}");
    }

    // 3. Rename resource/views/themes/light ➜ resource/views/themes/spark
    $themeOld = resource_path("views/themes/{$old}");
    $themeNew = resource_path("views/themes/{$new}");
    if (File::isDirectory($themeOld)) {
        File::moveDirectory($themeOld, $themeNew);
        $this->info("Renamed folder: resource/views/themes/{$old} ➜ {$new}");
    } else {
        $this->warn("Directory not found: resource/views/themes/{$old}");
    }
    

    $this->info("✅ Theme renaming completed.");
});




// for change theme section names
Artisan::command('theme:rename-sections', function () {
    $old = 'green';
    $new = 'nova';

    $sectionPath = resource_path("views/themes/{$old}/sections");

    if (!File::isDirectory($sectionPath)) {
        $this->error("Directory not found: {$sectionPath}");
        return;
    }
    $files = File::files($sectionPath);


    foreach ($files as $file) {
        $oldFilename = $file->getFilename();

        if (str_contains($oldFilename, "_{$old}")) {
            $newFilename = str_replace("_{$old}", "_{$new}", $oldFilename);
            File::move($file->getPathname(), $file->getPath() . '/' . $newFilename);
            $this->info("Renamed: {$oldFilename} ➜ {$newFilename}");
        }
    }

    $this->info("Theme section files renamed from '{$old}' to '{$new}' successfully.");
});



