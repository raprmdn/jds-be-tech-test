<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait ImageTrait
{
    public function uploadImage(string $folder, UploadedFile $image, string $slug): string
    {
        $filename = \Str::slug($slug) . '-' . time() . '.' . $image->getClientOriginalExtension();

        return \Storage::putFileAs($folder, $image, $filename, 'public');
    }
}
