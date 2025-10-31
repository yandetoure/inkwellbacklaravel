<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MockController extends BaseController
{
    private array $books;
    private array $user;

    public function __construct()
    {
        $this->books = [
            [
                'id' => '1',
                'title' => 'Les Royaumes Oubliés',
                'author' => 'Jean Martin',
                'authorId' => 'a1',
                'cover' => 'https://images.unsplash.com/photo-1711185892790-4cabb6701cb8?auto=format&fit=crop&w=600&q=80',
                'description' => 'Une aventure épique dans un monde de magie et de mystères',
                'totalLikes' => 2543,
                'isPaid' => true,
                'freeChaptersCount' => 7,
                'category' => 'Fantastique',
                'rating' => 4.8,
                'chapters' => [
                    [
                        'id' => 'c1',
                        'number' => 1,
                        'title' => 'Le Début',
                        'content' => "Il était une fois dans un royaume lointain...",
                        'wordCount' => 1250,
                        'likes' => 145,
                        'comments' => [],
                        'isLiked' => false,
                        'isPaid' => false,
                        'coinCost' => 0,
                    ],
                ],
            ],
            [
                'id' => '2',
                'title' => "Romance d'Été",
                'author' => 'Sophie Laurent',
                'authorId' => 'a2',
                'cover' => 'https://images.unsplash.com/photo-1711185897885-a0502b3f57c1?auto=format&fit=crop&w=600&q=80',
                'description' => "Une histoire d'amour sur la Côte d'Azur",
                'totalLikes' => 3821,
                'isPaid' => false,
                'freeChaptersCount' => 0,
                'category' => 'Romance',
                'rating' => 4.9,
                'chapters' => [
                    [
                        'id' => 'c11',
                        'number' => 1,
                        'title' => 'Arrivée à Nice',
                        'content' => "L'été promet d'être inoubliable...",
                        'wordCount' => 980,
                        'likes' => 245,
                        'comments' => [],
                        'isLiked' => false,
                        'isPaid' => false,
                        'coinCost' => 0,
                    ],
                ],
            ],
        ];

        $this->user = [
            'id' => '1',
            'name' => 'Marie Dubois',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
            'coins' => 150,
            'booksWritten' => 3,
        ];
    }

    public function books()
    {
        return response()->json($this->books);
    }

    public function book(string $id)
    {
        $book = collect($this->books)->firstWhere('id', $id);
        if (!$book) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($book);
    }

    public function chapter(string $bookId, string $chapterId)
    {
        $book = collect($this->books)->firstWhere('id', $bookId);
        if (!$book) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $chapter = collect($book['chapters'])->firstWhere('id', $chapterId);
        if (!$chapter) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($chapter);
    }

    public function me()
    {
        return response()->json($this->user);
    }
}


