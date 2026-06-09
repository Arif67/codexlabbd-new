<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('site.services', []) as $i => $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                [
                    'icon'        => $service['icon'],
                    'description' => $service['desc'],
                    'sort_order'  => $i,
                    'is_active'   => true,
                ]
            );
        }
    }
}
