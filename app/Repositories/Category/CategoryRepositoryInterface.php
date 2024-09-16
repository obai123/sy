<?php

namespace App\Repositories\Category;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAllParenteCategories();
    public function getCategoryById(int $id);
    public function createCategory(array $data);
    public function updateCategory(array $data);
    public function deleteCategory(int $id);
}
