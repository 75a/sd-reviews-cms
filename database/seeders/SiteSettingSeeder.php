<?php

namespace Database\Seeders;


use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSetting::firstOrNew(['key' => "header_logo_url"])->save();
        SiteSetting::firstOrNew(['key' => "footer_logo_url"])->save();
        SiteSetting::firstOrNew(['key' => "footer_contents"])->save();
        SiteSetting::firstOrNew(['key' => "meta_title"])->save();

    }
}
