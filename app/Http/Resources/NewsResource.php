<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'thumbnail' => $this->whenLoaded('thumbnail', function () {
                return $this->thumbnail->fullUrl;
            }),
            'author' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return CommentResource::collection($this->comments);
            }),
            'created_at' => [
                'formatted' => $this->created_at->diffForHumans(),
                'date' => $this->created_at->format('d F Y, H:i:s'),
            ]
        ];
    }
}
