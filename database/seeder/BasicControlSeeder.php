<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BasicControl;

class BasicControlSeeder extends Seeder
{
    public function run(): void
    {
        BasicControl::updateOrCreate(
            ['theme' => 'spark'],
            [
                'site_title' => 'Marketlyst',
                'primary_color' => '#ffc800',
                'secondary_color' => '#f42525',
                'time_zone' => 'Asia/Dhaka',
                'sender_email' => 'support@mail.com',
                'sender_email_name' => 'Bug Admin',
                'email_description' => null,

                'logo' => 'logo/KRKHGWPKOnWNPkuEsHIs8SBTkZerBw.webp',
                'logo_driver' => 'local',
                'favicon' => 'logo/jJzaigi44Sq7OU7CB8h4CYVqbQi3LX.webp',
                'favicon_driver' => 'local',
                'admin_logo' => 'logo/v60rNnTRYGSMvavNZLihKHQzoRV3bgQ7h9em22EW.png',
                'admin_logo_driver' => 'local',
                'admin_dark_mode_logo' => 'logo/DfYBv0PbPakYkF3V0Uwe7QFKfTyHLP.webp',
                'admin_dark_mode_logo_driver' => 'local',

                'tawk_id' => 'OSLDSF465DD',
                'fb_app_id' => 'KLSDKF789',
                'fb_page_id' => '654646977',

                'currency_layer_access_key' => 'a7b7449c93d2e4bfffc7050b20a2c11',
                'currency_layer_auto_update_at' => 'everyMinute',
                'coin_market_cap_app_key' => '726ffba5-8523-4071-92d4-1775dbc481c4',
                'coin_market_cap_auto_update_at' => 'everyMinute',

                'cookie_title' => 'We use cookies!',
                'cookie_sub_title' => 'We use cookies to ensure that give you the best experience on your website',
                'cookie_url' => 'http://localhost/DigitMart/cookie-policy',

                'date_time_format' => 'd M Y',
                'refundable_time' => 100,
            ]
        );
    }
}

