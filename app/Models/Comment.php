<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    public static function tree(): Collection
    {
        $comments = DB::table('comments')
            ->select('id', 'name', 'message', 'parent_id')
            ->get();
        $firstLevel = $comments->where('parent_id', null);
        $secondLevel = $comments->whereIn('parent_id', $firstLevel->pluck('id'));
        $thirdLevel = $comments->whereNotIn('parent_id', $firstLevel->pluck('id'))->whereNotNull('parent_id');

        $thirdLevelArr = [];
        foreach ($thirdLevel as $comment) {
            $comment->comments = [];
            $parentId = $comment->parent_id;
            unset($comment->parent_id);
            if (isset($thirdLevelArr[$parentId])) {
                $thirdLevelArr[$parentId][] = $comment;
            } else {
                $thirdLevelArr[$parentId] = [$comment];
            }
        }

        $secondLevelArr = [];
        foreach ($secondLevel as $comment) {
            $comment->comments = [];
            if (isset($thirdLevelArr[$comment->id])) {
                $comment->comments = $thirdLevelArr[$comment->id];
            }
            $parentId = $comment->parent_id;
            unset($comment->parent_id);
            if (isset($secondLevelArr[$parentId])) {
                $secondLevelArr[$parentId][] = $comment;
            } else {
                $secondLevelArr[$parentId] = [$comment];
            }
        }

        foreach ($firstLevel as $comment) {
            unset($comment->parent_id);
            $comment->comments = [];
            if (isset($secondLevelArr[$comment->id])) {
                $comment->comments = $secondLevelArr[$comment->id];
            }
        }

        return $firstLevel;
    }
}
