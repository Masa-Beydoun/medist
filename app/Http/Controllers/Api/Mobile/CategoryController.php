<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MedicineResource;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    public function getMedicines(Request $request, Category $category)
    {
        $medicines = $category->medicines->where('warehouse_id', request()->warehouse_id);
        $type = $request->type ?? null;
        if($type) {
            $medicines = Medicine::whereHas('details', function ($query) use ($type) {
                            $query->where('type', $type);
                        })
                        ->where('category_id', $category->id)
                        ->where('warehouse_id', $request->warehouse_id)
                        ->get();
        }
        if(sizeof($medicines) == 0) {
            return response()->json([
                'message' => 'No Medicines Found',
            ],400);
        }
        return response()->json([
            'message' => 'All Medicines Retrieved',
            'count' => count($medicines),
            'medicines' => MedicineResource::collection($medicines)
        ]);
    }

    public function search(Request $request)
    {
        $category = Category::where('name->en','like', '%' . $request->search . '%')->get();
        if(count($category) == 0) {
            return response()->json([
                'message' => 'No Category Found'
            ],400);
        }
        return response()->json([
            'message' => 'Found Successfully',
            'count' => count($category),
            'category' => CategoryResource::collection($category)
        ]);
    }
}
