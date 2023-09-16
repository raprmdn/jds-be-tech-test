<?php

namespace App\Repository;

interface NewsRepositoryInterface
{
    public function create(array $attributes);
    public function slugExists(string $slug);
}
