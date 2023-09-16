<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\CommentRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\News;
use App\Services\CommentService;

class CommentController extends Controller
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @throws CustomException
     */
    public function __invoke(News $news, CommentRequest $request)
    {
        $this->commentService->create($news, $request->validated());

        return new ApiSuccessResponse(
            'Comment created successfully',
            null,
            201
        );
    }
}
