<?php declare(strict_types=1); 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Pour SQLite, on désactive les contraintes de clés étrangères
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::table('books')->truncate();
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('books')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $authors = DB::table('users')->where('is_author', 1)->get();
        
        $categories = DB::table('categories')->get();
        $categoryIds = $categories->pluck('id')->toArray();

        $books = [
            ['title' => 'Les Royaumes Oubliés', 'category' => 'Fantastique', 'setting' => 'fantastique', 'words' => 1500, 'likes' => 2543, 'rating' => 4.8, 'paid' => 1, 'free' => 7, 'cover' => 'https://images.unsplash.com/photo-1711185892790-4cabb6701cb8?auto=format&fit=crop&w=600&q=80', 'traits' => ['calme','courageux']],
            ['title' => "Romance d'Été", 'category' => 'Romance', 'setting' => 'moderne', 'words' => 1200, 'likes' => 3821, 'rating' => 4.9, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1711185897885-a0502b3f57c1?auto=format&fit=crop&w=600&q=80', 'traits' => ['possessif','attentionné']],
            ['title' => "L'Ombre du Passé", 'category' => 'Thriller', 'setting' => 'moderne', 'words' => 1800, 'likes' => 5432, 'rating' => 4.7, 'paid' => 1, 'free' => 5, 'cover' => 'https://images.unsplash.com/photo-1636303626647-5e4c51f3f778?auto=format&fit=crop&w=600&q=80', 'traits' => ['suspicieux','intelligent']],
            ['title' => 'Cité des Ténèbres', 'category' => 'Horreur', 'setting' => 'moderne', 'words' => 2000, 'likes' => 1892, 'rating' => 4.5, 'paid' => 1, 'free' => 3, 'cover' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=600&q=80', 'traits' => ['courageux','rebellious']],
            ['title' => 'Étoiles et Destins', 'category' => 'Science-Fiction', 'setting' => 'futuriste', 'words' => 1700, 'likes' => 6712, 'rating' => 4.9, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=600&q=80', 'traits' => ['curieux','audacieux']],
            ['title' => 'Le Mystère de la Tour', 'category' => 'Mystère', 'setting' => 'moderne', 'words' => 1600, 'likes' => 3456, 'rating' => 4.6, 'paid' => 1, 'free' => 8, 'cover' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80', 'traits' => ['observateur','patient']],
            ['title' => 'Au Temps des Rois', 'category' => 'Historique', 'setting' => 'médiéval', 'words' => 2200, 'likes' => 8923, 'rating' => 4.8, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=600&q=80', 'traits' => ['noble','loyal']],
            ['title' => 'Rires et Délires', 'category' => 'Comédie', 'setting' => 'moderne', 'words' => 1100, 'likes' => 2345, 'rating' => 4.4, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?auto=format&fit=crop&w=600&q=80', 'traits' => ['drôle','optimiste']],
            ['title' => 'Larmes de Cœur', 'category' => 'Drame', 'setting' => 'moderne', 'words' => 1900, 'likes' => 5123, 'rating' => 4.7, 'paid' => 1, 'free' => 6, 'cover' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=600&q=80', 'traits' => ['émotionnel','sensible']],
            ['title' => 'Chasseurs Épiques', 'category' => 'Action', 'setting' => 'moderne', 'words' => 2100, 'likes' => 7890, 'rating' => 4.9, 'paid' => 1, 'free' => 4, 'cover' => 'https://images.unsplash.com/photo-1547683905-f6866236637b?auto=format&fit=crop&w=600&q=80', 'traits' => ['agile','déterminé']],
            ['title' => 'Naruto: La Légende', 'category' => 'Manga', 'setting' => 'fantastique', 'words' => 1400, 'likes' => 12345, 'rating' => 5.0, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?auto=format&fit=crop&w=600&q=80', 'traits' => ['persévérant','driven']],
            ['title' => 'Château des Secrets', 'category' => 'Romance', 'setting' => 'médiéval', 'words' => 1300, 'likes' => 6789, 'rating' => 4.8, 'paid' => 1, 'free' => 10, 'cover' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=600&q=80', 'traits' => ['passionné','intense']],
            ['title' => 'Forêt Enchantée', 'category' => 'Fantastique', 'setting' => 'fantastique', 'words' => 1600, 'likes' => 4567, 'rating' => 4.6, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=600&q=80', 'traits' => ['magique','sage']],
            ['title' => 'Enfers Urbains', 'category' => 'Horreur', 'setting' => 'moderne', 'words' => 1750, 'likes' => 3210, 'rating' => 4.5, 'paid' => 1, 'free' => 2, 'cover' => 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?auto=format&fit=crop&w=600&q=80', 'traits' => ['sombre','mystérieux']],
            ['title' => 'Nébulexus Alpha', 'category' => 'Science-Fiction', 'setting' => 'futuriste', 'words' => 1950, 'likes' => 9876, 'rating' => 4.9, 'paid' => 1, 'free' => 5, 'cover' => 'https://images.unsplash.com/photo-1614730321146-b6fa6a46bcb4?auto=format&fit=crop&w=600&q=80', 'traits' => ['logique','innovant']],
            ['title' => 'Le Code Perdu', 'category' => 'Mystère', 'setting' => 'moderne', 'words' => 1450, 'likes' => 4321, 'rating' => 4.7, 'paid' => 1, 'free' => 9, 'cover' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=600&q=80', 'traits' => ['analytique','perspicace']],
            ['title' => 'Chevaliers du Temps', 'category' => 'Historique', 'setting' => 'médiéval', 'words' => 2050, 'likes' => 8765, 'rating' => 4.8, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1611619466807-a1f4b60f0e54?auto=format&fit=crop&w=600&q=80', 'traits' => ['brave','honorable']],
            ['title' => 'Comédie Marine', 'category' => 'Comédie', 'setting' => 'moderne', 'words' => 1150, 'likes' => 2987, 'rating' => 4.3, 'paid' => 0, 'free' => 0, 'cover' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80', 'traits' => ['espiègle','charmeur']],
            ['title' => 'Adieux Sans Retour', 'category' => 'Drame', 'setting' => 'moderne', 'words' => 1850, 'likes' => 5678, 'rating' => 4.6, 'paid' => 1, 'free' => 7, 'cover' => 'https://images.unsplash.com/photo-1438183972690-6d4658e3290e?auto=format&fit=crop&w=600&q=80', 'traits' => ['triste','profound']],
            ['title' => 'Ultime Combat', 'category' => 'Action', 'setting' => 'moderne', 'words' => 1650, 'likes' => 10987, 'rating' => 5.0, 'paid' => 1, 'free' => 3, 'cover' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=600&q=80', 'traits' => ['combattant','indomptable']],
        ];

        foreach ($books as $bookData) {
            $category = $categories->firstWhere('name', $bookData['category']);
            $categoryId = $category ? $category->id : $categoryIds[array_rand($categoryIds)];
            $author = $authors->random();

        DB::table('books')->insert([
                'user_id' => $author->id,
                'category_id' => $categoryId,
                'title' => $bookData['title'],
                'cover' => $bookData['cover'],
                'description' => "Une histoire captivante de {$bookData['category']} qui vous tiendra en haleine.",
                'intrigue' => 'Un récit palpitant qui explore des thèmes profonds et des personnages complexes.',
                'setting' => $bookData['setting'],
                'approx_words_per_chapter' => $bookData['words'],
                'character_traits' => json_encode($bookData['traits']),
                'total_likes' => $bookData['likes'],
                'is_paid' => $bookData['paid'],
                'free_chapters_count' => $bookData['free'],
                'category' => $bookData['category'],
                'rating' => $bookData['rating'],
                'created_at'=>now(),'updated_at'=>now(),
        ]);
        }
    }
}



