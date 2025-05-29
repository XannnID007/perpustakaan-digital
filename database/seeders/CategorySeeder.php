<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Novel dan cerita fiksi',
                'color' => '#FF6B6B',
                'icon' => 'fas fa-magic'
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Buku tentang teknologi dan programming',
                'color' => '#4ECDC4',
                'icon' => 'fas fa-laptop-code'
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Buku edukasi dan pembelajaran',
                'color' => '#45B7D1',
                'icon' => 'fas fa-graduation-cap'
            ],
            [
                'name' => 'Sejarah',
                'description' => 'Buku sejarah dan biografi',
                'color' => '#96CEB4',
                'icon' => 'fas fa-landmark'
            ],
            [
                'name' => 'Sains',
                'description' => 'Buku sains dan penelitian',
                'color' => '#FFEAA7',
                'icon' => 'fas fa-atom'
            ],
            [
                'name' => 'Bisnis',
                'description' => 'Buku bisnis dan ekonomi',
                'color' => '#DDA0DD',
                'icon' => 'fas fa-chart-line'
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Buku kesehatan dan medis',
                'color' => '#98D8C8',
                'icon' => 'fas fa-heartbeat'
            ],
            [
                'name' => 'Horor',
                'description' => 'Cerita horor dan thriller',
                'color' => '#2D3436',
                'icon' => 'fas fa-ghost'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
