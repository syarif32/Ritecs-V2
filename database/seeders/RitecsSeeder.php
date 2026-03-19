<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RitecsSeeder extends Seeder
{
     public function run(): void
    {

        // Categories - Books
        DB::table('categories')->insert([
            ['name' => 'Fiksi', 'type' => 'book'],
            ['name' => 'Non-Fiksi', 'type' => 'book'],
            ['name' => 'Edukasi', 'type' => 'book'],
            ['name' => 'Teknologi', 'type' => 'journal'],
            ['name' => 'Kesehatan', 'type' => 'journal'],
            ['name' => 'Sosial', 'type' => 'journal'],
        ]);

        // Keywords (contoh untuk jurnal)
        DB::table('keywords')->insert([
            ['name' => 'Artificial Intelligence'],
            ['name' => 'Machine Learning'],
            ['name' => 'Blockchain'],
            ['name' => 'Renewable Energy'],
            ['name' => 'Data Security'],
        ]);
    }
}
