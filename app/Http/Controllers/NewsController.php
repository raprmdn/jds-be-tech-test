<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Http\Resources\NewsResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\News;
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

    /**
     * @throws CustomException
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        $news = $this->newsService->update($news, $request->validated());

        return new ApiSuccessResponse(
            'News updated successfully.',
            new NewsResource($news),
            200,
        );
    }
}
