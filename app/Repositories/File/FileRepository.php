<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileRepository implements FileRepositoryInterface
{
    use ResponseTrait;
    public function uploadFile($file, int $categoryId, string $title)
    {
        $path = $file->store("files/$categoryId", 'public');

        $fileRecord = File::create([
            'category_id' => $categoryId,
            'title' => $title,
            'path' => 'public/' . Storage::url($path),
            'mime' => $file->getClientOriginalExtension(),
            'size' => $file->getSize() / 1024,
        ]);

        return $this->formatResponse('success', 'File uploaded successfully.', $fileRecord);
    }


    public function deleteFile(int $id)
    {
        $file = File::find($id);

        if (!$file) {
            return $this->formatResponse('error', 'File not found.', null);
        }

        // dd(str_replace(Storage::url(''), '', $file->path));
        Storage::delete(str_replace(Storage::url(''), '', $file->path));
        $file->delete();

        return $this->formatResponse('success', 'File deleted successfully.', null);
    }


    public function downloadFile(int $id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        $filePath = str_replace(Storage::url(''), '', $file->path);

        return new StreamedResponse(function () use ($filePath) {
            echo Storage::get($filePath);
        }, 200, [
            'Content-Type' => $file->mime,
            'Content-Disposition' => 'attachment; filename="' . basename($file->title . "." . $file->mime) . '"',
        ]);
    }




    public function displayFile(int $id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Fetch the correct file path from storage
        $filePath = str_replace(Storage::url(''), '', $file->path);

        // Ensure the file exists
        if (!Storage::exists($filePath)) {
            return response()->json(['error' => 'File not found on server.'], 404);
        }

        // Get the MIME type of the file
        $mimeType = $file->mime;

        // Handle files that can be displayed inline
        if ($mimeType === 'pdf') {
            return response()->file(Storage::path($filePath), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($file->path) . '"',
            ]);
        }

        return new StreamedResponse(function () use ($filePath) {
            echo Storage::get($filePath);
        }, 200, [
            'Content-Type' => $file->mime,
            'Content-Disposition' => 'attachment; filename="' . basename($file->title . "." . $file->mime) . '"',
        ]);
    }
}
