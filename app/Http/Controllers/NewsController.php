<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function store(NewsRequest $request)
    {
        $news = $this->newsService->create($request->validated());

        return new ApiSuccessResponse(
            'News created successfully.',
            new NewsResource($news),
            201,
        );
    }
}
