<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyV2Resource;
use App\Http\Resources\MedicineResource;
use App\Models\Company;
use App\Models\Warehouse;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Warehouse::find(request()->warehouse_id)->companies;
        return response()->json([
            'companies' => CompanyV2Resource::collection($companies)
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return response()->json([
            'companies' => new CompanyResource($company)
        ],200);
    }

    public function getMedicines(Company $company)
    {
        $medicines = $company->medicines;
        return response()->json([
            'medicines' => MedicineResource::collection($medicines)
        ],200);
    }
}
