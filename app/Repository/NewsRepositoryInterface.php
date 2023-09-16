<?php

namespace App\Repository;

use App\Models\News;

interface NewsRepositoryInterface
{
    public function create(array $attributes);
    public function slugExists(string $slug);
    public function update(News $news, array $attributes);
    public function show(News $news);
    public function delete(News $news);
}
