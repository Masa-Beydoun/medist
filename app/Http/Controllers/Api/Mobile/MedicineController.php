<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineStoreRequest;
use App\Http\Resources\DoseResource;
use App\Http\Resources\MedicineDetailsResource;
use App\Http\Resources\MedicineResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Medicine;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $warehouse = Warehouse::find($request->warehouse_id);
        $medicines = $warehouse->medicines;
        $type = $request->type ?? null;
        if($type) {
            $medicines = Medicine::whereHas('details', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
        }
        return response()->json([
            'message' => 'Found Successfully',
            'count' => count($medicines),
            'medicines' => MedicineResource::collection($medicines)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        return response()->json([
            'message' => 'Found Successfully',
            'medicine' => new MedicineDetailsResource($medicine),
        ]);
    }

    public function search(Request $request)
    {
        $medicines = [];
        if($request->searchBy == 'medicine') {
            $data = Medicine::where('commercial_name', 'like', '%' . $request->search . '%')
                            ->orWhere('scientific_name', 'like', '%' . $request->search . '%')
                            ->get();
            foreach($data as $medicine) {
                if($medicine->warehouse_id == $request->warehouse_id) {
                    $medicines[] = $medicine;
                }
            }
        }
        else {
            $categories = Category::where('name','like', '%' . ucfirst($request->search) . '%')->get();
            foreach($categories as $category) {
                foreach($category->medicines as $medicine) {
                    if($medicine->warehouse_id == $request->warehouse_id) {
                        $medicines[] = $medicine;
                    }
                }
            }
        }
        if(!$medicines) {
            return response()->json([
                'message' => 'No Medicine Found'
            ],404);
        }
        return response()->json([
            'message' => 'Found Successfully',
            'count' => count($medicines),
            'medicines' => MedicineResource::collection($medicines)
        ],200);
    }
}
