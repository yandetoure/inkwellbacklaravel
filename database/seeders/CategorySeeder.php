<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Pour SQLite, on désactive les contraintes de clés étrangères
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::table('categories')->truncate();
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('categories')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $categories = [
            ['name' => 'Romance', 'icon' => '💕'],
            ['name' => 'Aventure', 'icon' => '⚔️'],
            ['name' => 'Fantastique', 'icon' => '✨'],
            ['name' => 'Thriller', 'icon' => '🔪'],
            ['name' => 'Horreur', 'icon' => '👻'],
            ['name' => 'Science-Fiction', 'icon' => '🚀'],
            ['name' => 'Mystère', 'icon' => '🔍'],
            ['name' => 'Historique', 'icon' => '📜'],
            ['name' => 'Comédie', 'icon' => '😄'],
            ['name' => 'Drame', 'icon' => '🎭'],
            ['name' => 'Action', 'icon' => '💥'],
            ['name' => 'Manga', 'icon' => '🇯🇵'],
        ];

        foreach ($categories as $c) {
            DB::table('categories')->insert($c + ['created_at'=>now(),'updated_at'=>now()]);
        }
    }
}



