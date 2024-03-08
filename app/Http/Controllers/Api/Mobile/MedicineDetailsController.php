<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoseResource;
use App\Models\Medicine;
use App\Models\MedicineDetails;

class MedicineDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Medicine $medicine)
    {
        $doses = $medicine->details ?? [];
        return response()->json([
            'count' => count($doses),
            'types' => DoseResource::collection($medicine->details)
        ],200);
    }
}
