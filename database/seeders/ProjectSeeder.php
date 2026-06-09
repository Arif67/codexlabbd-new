<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('site.projects', []) as $i => $project) {
            Project::updateOrCreate(
                ['title' => $project['title']],
                [
                    'category'   => $project['category'],
                    'image'      => 'img/' . $project['img'],
                    'sort_order' => $i,
                    'is_active'  => true,
                ]
            );
        }
    }
}
