<?php declare(strict_types=1); 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('comments')->truncate();
        DB::table('chapters')->truncate();
        DB::table('books')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $catRomance = DB::table('categories')->insertGetId(['name' => 'Romance', 'icon' => '💕', 'created_at'=>now(), 'updated_at'=>now()]);
        $catFantasy = DB::table('categories')->insertGetId(['name' => 'Fantastique', 'icon' => '✨', 'created_at'=>now(), 'updated_at'=>now()]);

        $user1 = DB::table('users')->first();
        if (!$user1) {
            $user1 = (object)['id' => DB::table('users')->insertGetId([
                'name' => 'Auteur Démo',
                'nickname' => 'Demo',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'created_at'=>now(),'updated_at'=>now(),
            ])];
        }

        $book1 = DB::table('books')->insertGetId([
            'user_id' => $user1->id,
            'category_id' => $catFantasy,
            'title' => 'Les Royaumes Oubliés',
            'cover' => 'https://images.unsplash.com/photo-1711185892790-4cabb6701cb8?auto=format&fit=crop&w=600&q=80',
            'description' => 'Une aventure épique dans un monde de magie et de mystères',
            'total_likes' => 2543,
            'is_paid' => 1,
            'free_chapters_count' => 7,
            'category' => 'Fantastique',
            'rating' => 4.8,
            'created_at'=>now(),'updated_at'=>now(),
        ]);

        for ($i = 1; $i <= 7; $i++) {
            DB::table('chapters')->insert([
                'book_id' => $book1,
                'number' => $i,
                'title' => 'Chapitre ' . $i,
                'content' => 'Il était une fois... (chapitre ' . $i . ')',
                'word_count' => 1200 + $i * 50,
                'views' => 1000 + $i * 100,
                'likes' => 100 + $i * 5,
                'is_liked' => 0,
                'is_paid' => 0,
                'coin_cost' => 0,
                'created_at'=>now(),'updated_at'=>now(),
            ]);
        }

        DB::table('chapters')->insert([
            'book_id' => $book1,
            'number' => 8,
            'title' => 'Chapitre Premium',
            'content' => 'Contenu verrouillé',
            'word_count' => 1950,
            'views' => 980,
            'likes' => 98,
            'is_liked' => 0,
            'is_paid' => 1,
            'coin_cost' => 5,
            'created_at'=>now(),'updated_at'=>now(),
        ]);

        DB::table('books')->insert([
            'user_id' => $user1->id,
            'category_id' => $catRomance,
            'title' => "Romance d'Été",
            'cover' => 'https://images.unsplash.com/photo-1711185897885-a0502b3f57c1?auto=format&fit=crop&w=600&q=80',
            'description' => "Une histoire d'amour sur la Côte d'Azur",
            'total_likes' => 3821,
            'is_paid' => 0,
            'free_chapters_count' => 0,
            'category' => 'Romance',
            'rating' => 4.9,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
    }
}
