<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'company_name' => 'Rextertech',
            'company_logo' => null,
            'default_user_role' => 'user',
            'supplier_login_expiry_hour_limit' => '360',
            'user_registration_enabled' => '1',
            'email_verification_required' => '0',
            'max_login_attempts' => '5',
            'layout_type' => 'ltr',
            'sidebar_type' => 'compact-sidebar',
            'sidebar_icon' => 'stroke-svg',
            'theme_color' => 'color-1',
            'dark_mode' => 'light',
            'primary_color' => '#2B5F60',
            'secondary_color' => '#C06240',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
