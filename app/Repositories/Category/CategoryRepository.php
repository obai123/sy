<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryRepository implements CategoryRepositoryInterface
{
    use ResponseTrait;

    public function getAllParenteCategories()
    {
        return Category::whereNull('parent_category_id')->get();


        // return $this->formatResponse('success', 'Categories retrieved successfully.', $categories);
    }

    public function getCategoryById(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->formatResponse('error', 'Category not found.', null);
        }

        $category['subcategories'] = $category->subcategories;
        $category['files'] = $category->files;

        return $this->formatResponse('success', 'Category retrieved successfully.', $category);
    }


    public function createCategory(array $data)
    {
        $category = new Category();
        $category->parent_category_id = $data['parent_category_id'] ?? null;
        $category->title = $data['title'];

        if (isset($data['picture'])) {
            $category->picture = $this->uploadPicture($data['picture']);
        }

        $category->description = $data['description'] ?? null;
        $category->location = $data['location'] ?? null;
        $category->save();

        return $this->formatResponse('success', 'Category created successfully.', $category);
    }

    public function updateCategory(array $data)
    {
        $category = Category::find($data['id']);

        if (!$category) {
            return $this->formatResponse('error', 'Category not found.', null);
        }

        $category->title = $data['title'] ?? $category->title;

        if (isset($data['picture'])) {
            if ($category->picture && file_exists(public_path($category->picture))) {
                unlink(public_path($category->picture)); // Delete the old picture from public folder
            }
            $category->picture = $this->uploadPicture($data['picture']);
        }

        $category->description = $data['description'] ?? $category->description;
        $category->location = $data['location'] ?? $category->location;
        $category->save();

        return $this->formatResponse('success', 'Category updated successfully.', $category);
    }



    public function deleteCategory(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->formatResponse('error', 'Category not found.', null);
        }

        if (count($category->files) || count($category->subcategories)) {
            return $this->formatResponse('error', 'Category not empty.', null);
        }

        // Delete the picture if it exists
        if ($category->picture && file_exists(public_path($category->picture))) {
            unlink(public_path($category->picture)); // Delete the picture from public folder
        }

        $category->delete();

        return $this->formatResponse('success', 'Category deleted successfully.', null);
    }



    private function uploadPicture($picture)
    {
        $filename = rand(1111, 9999) . '_' . time() . '_' . $picture->getClientOriginalName();
        $picture->move(public_path('pictures'), $filename); // Save the file to public/pictures
        return 'pictures/' . $filename; // Return the relative path
    }
}
