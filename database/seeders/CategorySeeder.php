<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku-buku fiksi, novel, dan cerita'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku-buku ilmu pengetahuan dan faktual'],
            ['name' => 'Pendidikan', 'description' => 'Buku pelajaran dan pendidikan'],
            ['name' => 'Teknologi', 'description' => 'Buku tentang teknologi dan programming'],
            ['name' => 'Bisnis', 'description' => 'Buku bisnis, manajemen, dan keuangan'],
            ['name' => 'Agama', 'description' => 'Buku-buku keagamaan'],
            ['name' => 'Anak-anak', 'description' => 'Buku untuk anak-anak'],
            ['name' => 'Komik', 'description' => 'Komik dan manga'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
