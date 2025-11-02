<?php declare(strict_types=1); 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $books = DB::table('books')
            ->leftJoin('users', 'users.id', '=', 'books.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
            ->select('books.*', DB::raw("COALESCE(users.nickname, users.name) as author"), 'users.id as authorId', 'categories.name as category')
            ->get();

        $books = $books->map(function ($b) {
            $chapters = DB::table('chapters')->where('book_id', $b->id)->orderBy('number')->get();
            $b->chapters = $chapters->map(function ($c) {
                return [
                    'id' => (string)$c->id,
                    'number' => (int)$c->number,
                    'title' => $c->title,
                    'content' => $c->content,
                    'wordCount' => (int)$c->word_count,
                    'views' => (int)$c->views,
                    'likes' => (int)$c->likes,
                    'comments' => [],
                    'isLiked' => (bool)$c->is_liked,
                    'isPaid' => (bool)$c->is_paid,
                    'coinCost' => (int)$c->coin_cost,
                ];
            })->toArray();
            return $b;
        });

        return response()->json($books);
    }

    public function show(string $id)
    {
        $book = DB::table('books')
            ->leftJoin('users', 'users.id', '=', 'books.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
            ->select('books.*', DB::raw("COALESCE(users.nickname, users.name) as author"), 'users.id as authorId', 'categories.name as category')
            ->where('books.id', $id)
            ->first();
        if (!$book) return response()->json(['message' => 'Not found'], 404);
        $chapters = DB::table('chapters')->where('book_id', $book->id)->orderBy('number')->get();
        $book->chapters = $chapters->map(function ($c) {
            return [
                'id' => (string)$c->id,
                'number' => (int)$c->number,
                'title' => $c->title,
                'content' => $c->content,
                'wordCount' => (int)$c->word_count,
                'views' => (int)$c->views,
                'likes' => (int)$c->likes,
                'comments' => [],
                'isLiked' => (bool)$c->is_liked,
                'isPaid' => (bool)$c->is_paid,
                'coinCost' => (int)$c->coin_cost,
            ];
        })->toArray();
        return response()->json($book);
    }

    public function chapter(string $bookId, string $chapterId)
    {
        $chapter = DB::table('chapters')->where('book_id', $bookId)->where('id', $chapterId)->first();
        if (!$chapter) return response()->json(['message' => 'Not found'], 404);
        return response()->json([
            'id' => (string)$chapter->id,
            'number' => (int)$chapter->number,
            'title' => $chapter->title,
            'content' => $chapter->content,
            'wordCount' => (int)$chapter->word_count,
            'views' => (int)$chapter->views,
            'likes' => (int)$chapter->likes,
            'comments' => [],
            'isLiked' => (bool)$chapter->is_liked,
            'isPaid' => (bool)$chapter->is_paid,
            'coinCost' => (int)$chapter->coin_cost,
        ]);
    }

    public function me()
    {
        // simple mock user in DB users if exists, else static
        $user = DB::table('users')->first();
        return response()->json([
            'id' => (string)($user->id ?? 1),
            'name' => $user->name ?? 'Marie Dubois',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
            'coins' => 150,
            'booksWritten' => 3,
        ]);
    }
}
