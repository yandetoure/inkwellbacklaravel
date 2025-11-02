<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        // Pour SQLite, on désactive les contraintes de clés étrangères
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::table('chapters')->truncate();
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('chapters')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $books = DB::table('books')->get();
        foreach ($books as $book) {
            $freeChapters = $book->free_chapters_count ?? 0;
            $approxWords = $book->approx_words_per_chapter ?: 1500;
            $isPaidBook = $book->is_paid ?? false;
            
            // Créer 20 chapitres par livre
            for ($i = 1; $i <= 20; $i++) {
                $isPaidChapter = $isPaidBook && $i > $freeChapters;
                $coinCost = $isPaidChapter ? rand(5, 15) : 0;
                
                DB::table('chapters')->insert([
                    'book_id' => $book->id,
                    'number' => $i,
                    'title' => "Chapitre " . $i . ($isPaidChapter ? ' (Premium)' : ''),
                    'content' => $isPaidChapter 
                        ? "Contenu verrouillé - Chapitre premium du livre '{$book->title}'. Vous devez dépenser {$coinCost} pièces pour débloquer ce chapitre."
                        : "Contenu du chapitre {$i} du livre '{$book->title}'. Ce chapitre fait partie des chapitres gratuits et vous pouvez le lire immédiatement.",
                    'word_count' => $approxWords + rand(-200, 200),
                    'views' => rand(100, 5000) + ($i * 50),
                    'likes' => rand(10, 500) + ($i * 10),
                    'is_liked' => 0,
                    'is_paid' => $isPaidChapter ? 1 : 0,
                    'coin_cost' => $coinCost,
                    'created_at'=>now(),'updated_at'=>now(),
                ]);
            }
        }
    }
}



