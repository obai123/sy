<?php

namespace App\Repositories\File;

use Illuminate\Http\UploadedFile;

interface FileRepositoryInterface
{
    public function uploadFile(UploadedFile $file, int $categoryId, string $title);
    public function deleteFile(int $id);
    public function downloadFile(int $id);
    public function displayFile(int $id);
}
