<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DashboardMedicineResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories Retrieved Successfully',
            'count' => count($categories),
            'categories' => CategoryResource::collection($categories)
        ],200);
    }

    public function getMedicines(Category $category)
    {
        $medicines = $category->medicines()->where('warehouse_id',auth()->guard('sanctum')->user()->id)->get();
        if(!$medicines) {
            return response()->json([
                'message' => 'No Medicines Found',
            ],404);
        }
        return response()->json([
            'message' => 'All Medicines Retrieved',
            'count' => count($medicines),
            'medicines' => DashboardMedicineResource::collection($medicines)
        ],200);
    }
}
