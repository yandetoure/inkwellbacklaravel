<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReadingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadingListController extends Controller
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
            $lists = ReadingList::where('user_id', $userId)
                ->get()
                ->map(function ($list) {
                    $bookIds = $list->books()->pluck('books.id')->map(fn($id) => (string)$id)->toArray();
                    return [
                        'id' => (string)$list->id,
                        'name' => $list->name,
                        'bookIds' => $bookIds,
                        'createdAt' => $list->created_at ? $list->created_at->timestamp : time(),
                    ];
                });

            return response()->json($lists);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $userId = $this->getUserId();
            $list = ReadingList::create([
                'user_id' => $userId,
                'name' => $request->name,
            ]);

            return response()->json([
                'id' => (string)$list->id,
                'name' => $list->name,
                'bookIds' => [],
                'createdAt' => $list->created_at ? $list->created_at->timestamp : time(),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $userId = $this->getUserId();
        $list = ReadingList::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (!$list) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $bookIds = $list->books()->pluck('books.id')->map(fn($id) => (string)$id)->toArray();

        return response()->json([
            'id' => (string)$list->id,
            'name' => $list->name,
            'bookIds' => $bookIds,
            'createdAt' => $list->created_at ? $list->created_at->timestamp : time(),
        ]);
    }

    public function addBook(Request $request, string $listId)
    {
        $request->validate([
            'bookId' => 'required|integer',
        ]);

        $userId = $this->getUserId();
        $list = ReadingList::where('user_id', $userId)
            ->where('id', $listId)
            ->first();

        if (!$list) {
            return response()->json(['message' => 'Reading list not found'], 404);
        }

        $list->books()->syncWithoutDetaching([$request->bookId]);

        return response()->json(['message' => 'Book added to list'], 200);
    }

    public function removeBook(string $listId, string $bookId)
    {
        $userId = $this->getUserId();
        $list = ReadingList::where('user_id', $userId)
            ->where('id', $listId)
            ->first();

        if (!$list) {
            return response()->json(['message' => 'Reading list not found'], 404);
        }

        $list->books()->detach($bookId);

        return response()->json(['message' => 'Book removed from list'], 200);
    }

    public function destroy(string $id)
    {
        $userId = $this->getUserId();
        $list = ReadingList::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (!$list) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $list->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
