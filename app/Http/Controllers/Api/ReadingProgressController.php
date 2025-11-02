<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReadingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadingProgressController extends Controller
{
    private function getUserId(): int
    {
        $user = DB::table('users')->first();
        return $user->id ?? 1;
    }

    public function index()
    {
        try {
            $userId = $this->getUserId();
            $progress = ReadingProgress::where('user_id', $userId)
                ->get()
                ->mapWithKeys(function ($p) {
                    $updatedAt = null;
                    if ($p->updated_at) {
                        $updatedAt = is_string($p->updated_at) 
                            ? strtotime($p->updated_at) 
                            : (method_exists($p->updated_at, 'timestamp') ? $p->updated_at->timestamp : time());
                    }
                    return [
                        (string)$p->book_id => [
                            'chapterId' => $p->chapter_id ? (string)$p->chapter_id : null,
                            'chapterNumber' => $p->chapter_number,
                            'updatedAt' => $updatedAt,
                        ],
                    ];
                });

            return response()->json($progress);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $bookId)
    {
        try {
            $userId = $this->getUserId();
            $progress = ReadingProgress::where('user_id', $userId)
                ->where('book_id', $bookId)
                ->first();

            if (!$progress) {
                return response()->json(null);
            }

            $updatedAt = null;
            if ($progress->updated_at) {
                $updatedAt = is_string($progress->updated_at) 
                    ? strtotime($progress->updated_at) 
                    : (method_exists($progress->updated_at, 'timestamp') ? $progress->updated_at->timestamp : time());
            }

            return response()->json([
                'chapterId' => $progress->chapter_id ? (string)$progress->chapter_id : null,
                'chapterNumber' => $progress->chapter_number,
                'updatedAt' => $updatedAt,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'bookId' => 'required|integer',
                'chapterId' => 'nullable|integer',
                'chapterNumber' => 'nullable|integer',
            ]);

            $userId = $this->getUserId();
            
            $progress = ReadingProgress::updateOrCreate(
                [
                    'user_id' => $userId,
                    'book_id' => $request->bookId,
                ],
                [
                    'chapter_id' => $request->chapterId,
                    'chapter_number' => $request->chapterNumber,
                ]
            );

            $updatedAt = null;
            if ($progress->updated_at) {
                $updatedAt = is_string($progress->updated_at) 
                    ? strtotime($progress->updated_at) 
                    : (method_exists($progress->updated_at, 'timestamp') ? $progress->updated_at->timestamp : time());
            }

            return response()->json([
                'chapterId' => $progress->chapter_id ? (string)$progress->chapter_id : null,
                'chapterNumber' => $progress->chapter_number,
                'updatedAt' => $updatedAt,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function hasProgress(string $bookId)
    {
        try {
            $userId = $this->getUserId();
            $exists = ReadingProgress::where('user_id', $userId)
                ->where('book_id', $bookId)
                ->exists();

            return response()->json(['hasProgress' => $exists]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
