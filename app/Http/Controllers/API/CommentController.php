<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $commentsTree = Comment::tree()->values();
        return response()->json($commentsTree);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        DB::table('comments')->insert([
            'name' => $request->get('name'),
            'message' => $request->get('message'),
            'parent_id' => $request->get('parent_id'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['status' => 'OK']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $updatedRows = DB::table('comments')
            ->where('id', $id)
            ->update([
                'name' => $request->get('name'),
                'message' => $request->get('message'),
                'updated_at' => Carbon::now(),
            ]);

        if (!$updatedRows) {
            return response()->json([['status' => 'ERROR', 'message' => "Comment #$id not found."]], 404);
        }

        return response()->json(['status' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedRows = DB::table('comments')->where('id', $id)->delete();

        if (!$deletedRows) {
            return response()->json([['status' => 'ERROR', 'message' => "Comment #$id not found."]], 404);
        }

        return response()->json(['status' => 'OK']);
    }
}
