<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {

        $categories = $this->categoryRepository->getAllParenteCategories();
        return Inertia::render('Welcome', [
            'categories' => $categories
        ]);
        // return response()->json($this->categoryRepository->getAllParenteCategories());
    }

    public function show(int $id)
    {


        $response = $this->categoryRepository->getCategoryById($id);

        return Inertia::render('Category/models/CatigoryDetails', [
            'data' => $response
        ]);

        // if ($response['status'] === 'error') {
        //     return response()->json($response, 404);
        // }
        // return response()->json($this->categoryRepository->getCategoryById($id), 200);
    }

    public function store(StoreCategoryRequest $request)
    {

        try {
            $category = $this->categoryRepository->createCategory($request->validated());


            return Redirect::back()->with('success', 'Category created successfully.');
        } catch (\Exception $e) {

            return Redirect::back()->withErrors([
                'error' => 'Failed to create the category. ' . $e->getMessage(),
            ])->withInput();
        }

        // return response()->json($this->categoryRepository->createCategory($request->validated()), 201);
    }

    public function update(UpdateCategoryRequest $request)
    {

        try {
            $category = $this->categoryRepository->updateCategory($request->validated());


            return Redirect::back()->with('success', 'Category Updated successfully.');
        } catch (\Exception $e) {

            return Redirect::back()->withErrors([
                'error' => 'Failed to update the category. ' . $e->getMessage(),
            ])->withInput();
        }

        // return response()->json($this->categoryRepository->updateCategory($request->validated()));
    }


    public function destroy(int $id)
    {
        $response = $this->categoryRepository->deleteCategory($id);

        if ($response['status'] === 'error') {
            return Redirect::back()->withErrors([
                'error' => $response['message'],
            ]);
        }

        return Redirect::back()->with('success', 'Category deleted successfully.');
    }
}
