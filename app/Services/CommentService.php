<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\News;
use App\Repository\CommentRepositoryInterface;

class CommentService
{

    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @throws CustomException
     */
    public function create(News $news, array $attributes): void
    {
        $isReply = isset($attributes['reply_id']) && $this->commentRepository->isReplyComment($attributes['reply_id']);
        if ($isReply) {
            throw CustomException::commentIsNotParent();
        }

        $attributes['user_id'] = auth()->id();
        dispatch(new \App\Jobs\CommentJob($news, $attributes, $this->commentRepository));
    }

}
