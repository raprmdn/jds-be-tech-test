<?php

namespace App\Repository;

use App\Models\News;

interface CommentRepositoryInterface
{
    public function create(News $news, array $attributes);
    public function isReplyComment(int $id);
}
