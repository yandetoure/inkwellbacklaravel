<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DemoSeeder extends Seeder
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
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $authorId1 = DB::table('users')->insertGetId([
            'name' => 'Jean Martin',
            'nickname' => 'Jean M.',
            'avatar' => 'https://images.unsplash.com/photo-1618673827854-0065d21af001?auto=format&fit=crop&w=200&q=80',
            'cover_photo' => 'https://images.unsplash.com/photo-1530519696590-a11640ae14e3?auto=format&fit=crop&w=1080&q=80',
            'email' => 'jean@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(), 'updated_at' => now(),
        ]);
        Role::findOrCreate('author');
        DB::table('model_has_roles')->insert([
            'role_id' => Role::findByName('author')->id,
            'model_type' => \App\Models\User::class,
            'model_id' => $authorId1,
        ]);

        $authorId2 = DB::table('users')->insertGetId([
            'name' => 'Sophie Laurent',
            'nickname' => 'Sophie L.',
            'avatar' => 'https://images.unsplash.com/photo-1722371131066-e37037ecf109?auto=format&fit=crop&w=200&q=80',
            'cover_photo' => 'https://images.unsplash.com/photo-1581779124574-bc0da275e520?auto=format&fit=crop&w=1080&q=80',
            'email' => 'sophie@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => Role::findByName('author')->id,
            'model_type' => \App\Models\User::class,
            'model_id' => $authorId2,
        ]);

        $book1 = DB::table('books')->insertGetId([
            'user_id' => $authorId1,
            'title' => 'Les Royaumes Oubliés',
            'cover' => 'https://images.unsplash.com/photo-1711185892790-4cabb6701cb8?auto=format&fit=crop&w=600&q=80',
            'description' => 'Une aventure épique dans un monde de magie et de mystères',
            'total_likes' => 2543,
            'is_paid' => 1,
            'free_chapters_count' => 7,
            'category' => 'Fantastique',
            'rating' => 4.8,
            'created_at' => now(), 'updated_at' => now(),
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
                'created_at' => now(), 'updated_at' => now(),
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
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $book2 = DB::table('books')->insertGetId([
            'user_id' => $authorId2,
            'title' => "Romance d'Été",
            'cover' => 'https://images.unsplash.com/photo-1711185897885-a0502b3f57c1?auto=format&fit=crop&w=600&q=80',
            'description' => "Une histoire d'amour sur la Côte d'Azur",
            'total_likes' => 3821,
            'is_paid' => 0,
            'free_chapters_count' => 0,
            'category' => 'Romance',
            'rating' => 4.9,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        DB::table('chapters')->insert([
            'book_id' => $book2,
            'number' => 1,
            'title' => 'Arrivée à Nice',
            'content' => "L'été promet d'être inoubliable...",
            'word_count' => 980,
            'views' => 650,
            'likes' => 245,
            'is_liked' => 0,
            'is_paid' => 0,
            'coin_cost' => 0,
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }
}
