<?php

namespace App\Repository\Eloquent;

use App\Models\Comment;
use App\Models\News;
use App\Repository\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(News $news, array $attributes): void
    {
        $news->comments()->create([
            'parent_id' => $attributes['reply_id'] ?? null,
            'comment' => $attributes['comment'],
            'user_id' => $attributes['user_id'],
        ]);
    }

    public function isReplyComment(int $id): bool
    {
        return Comment::query()->where('id', $id)->isReply()->exists();
    }
}
