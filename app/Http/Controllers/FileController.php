<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    protected $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function upload(StoreFileRequest $request)
    {


        try {

            $response = $this->fileRepository->uploadFile(
                $request->file('file'),
                $request->category_id,
                $request->title
            );

            return Redirect::back()->with('success', 'Category Updated successfully.');
        } catch (\Exception $e) {

            return Redirect::back()->withErrors([
                'error' => 'Failed to update the category. ' . $e->getMessage(),
            ])->withInput();
        }
        // return response()->json($response, 201);
    }

    public function delete(int $id)
    {
        $response = $this->fileRepository->deleteFile($id);
        if ($response['status'] === 'success') {
            // Redirect back to the previous page with a success message
            return redirect()->back()->with('message', 'File deleted successfully.');
        } else {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['message' => 'File not found.']);
        }

        // return response()->json($response, $response['status'] === 'success' ? 200 : 404);
    }

    public function download(int $id)
    {
        return $this->fileRepository->downloadFile($id);
    }

    public function display(int $id)
    {
        return $this->fileRepository->displayFile($id);
    }
}
