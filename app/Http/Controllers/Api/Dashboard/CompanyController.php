<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\DashboardMedicineResource;
use App\Models\Company;

class CompanyController extends Controller
{

    public function index() {
        return response()->json([
            'message' => 'Companies Retrieved',
            'count' => count(Auth()->guard('sanctum')->user()->companies),
            'companies' => CompanyResource::collection(Auth()->guard('sanctum')->user()->companies)
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return response()->json([
            'message' => 'Company Retrieved',
            'companies' => new CompanyResource($company)
        ],200);
    }

    public function getMedicines(Company $company)
    {
        $warehouse = auth()->guard('sanctum')->user();
        $medicines = $warehouse->medicines()->where('company_id', $company->id)->get();
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
