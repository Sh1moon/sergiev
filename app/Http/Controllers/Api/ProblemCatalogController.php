<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProblemDetail;
use App\Models\ProblemSubcategory;

class ProblemCatalogController extends Controller
{
    public function subcategories(int $categoryId)
    {
        return ProblemSubcategory::query()
            ->where('problem_category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function details(int $subcategoryId)
    {
        return ProblemDetail::query()
            ->where('problem_subcategory_id', $subcategoryId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
