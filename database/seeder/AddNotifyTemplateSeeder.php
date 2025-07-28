<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AddNotifyTemplateSeeder extends Seeder
{
    public function run()
    {
        $message = "Your comment deletion request has been rejected. [[reason]]";
        DB::table('notification_templates')->updateOrInsert(
            [
                'template_key' => 'COMMENT_DELETE_REJECT',
            ],
            [
                'language_id' => 1,
                'name' => 'Comment Delete Rejected',
                'email_from' => 'support@mail.net',
                'subject' => 'Product Comment Delete Rejected',
                'short_keys' => json_encode([
                        'comment' => 'Comment content',
                        'reason' => 'Delete reason',
                    ]
                ),
                'email' => $message,
                'sms' => $message,
                'in_app' => $message,
                'push' => $message,
                'status' => json_encode(['mail' => '1', 'sms' => '1', 'in_app' => '1', 'push' => '1']),
                'notify_for' => 0,
                'lang_code' => 'en',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
