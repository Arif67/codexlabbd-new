<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'name'            => config('site.name'),
            'tagline'         => config('site.tagline'),
            'address'         => config('site.address'),
            'phone'           => config('site.phone'),
            'email'           => config('site.email'),
            'social_facebook' => config('site.social.facebook'),
            'social_twitter'  => config('site.social.twitter'),
            'social_instagram' => config('site.social.instagram'),
            'social_linkedin' => config('site.social.linkedin'),
            'social_youtube'  => config('site.social.youtube'),
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
