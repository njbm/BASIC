<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ClearSession extends Command
{
    protected $signature = 'session:clear {key?}';
    protected $description = 'Clear specific session data or all session data for a given session ID';

    public function handle()
    {
        $key = $this->argument('key');
        $sessionFiles = File::allFiles(storage_path('framework/sessions'));
        if (empty($sessionFiles)) {
            $this->error('No session files found.');
            return;
        }

        $sessionFileNames = [];
        foreach ($sessionFiles as $file) {
            $sessionFileNames[] = $file->getBasename();
        }

        $sessionId = $this->choice('Choose a session ID from the list', $sessionFileNames);
        $sessionFilePath = storage_path('framework/sessions/' . $sessionId);
        $sessionData = File::get($sessionFilePath);

        $session = unserialize($sessionData);
        if ($key) {
            if (isset($session[$key])) {
                unset($session[$key]);
                File::put($sessionFilePath, serialize($session));
                $this->info("Session data for '{$key}' has been cleared.");
            } else {
                $this->info("No session data found for '{$key}'.");
            }
        } else {
            File::put($sessionFilePath, serialize([]));
            $this->info("All session data has been cleared.");
        }
    }
}
