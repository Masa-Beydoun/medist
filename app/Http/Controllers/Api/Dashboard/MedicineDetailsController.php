<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoseStoreRequest;
use App\Http\Resources\DoseResource;
use App\Models\Medicine;
use App\Models\MedicineDetails;
use Illuminate\Http\Request;

class MedicineDetailsController extends Controller
{

    public function index(Request $request, Medicine $medicine)
    {
        $doses = $medicine->details;
        return response()->json([
            'message' => 'Doses Retrieved Successfully',
            'count' => count($doses),
            'doses' => DoseResource::collection($doses)
        ],200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(DoseStoreRequest $request, Medicine $medicine)
    {
        $data = $request->validated();
        $dose = MedicineDetails::create($data);
        $medicine->details()->save($dose);
        $dose->quantity()->create([
            'available' => $data['quantity'],
        ]);
        $dose->quantity->warehouse_id = auth()->guard('sanctum')->user()->id;
        $dose->quantity->save();
        return response()->json([
            'message' => 'Dose Added Successfully',
            'dose' => new DoseResource($dose)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateQuantity(Request $request, Medicine $medicine, string $dose_id)
    {
        $dose = MedicineDetails::find($dose_id);
        if(!$medicine || !$dose) {
            return response()->json([
                'message' => 'Medicine Not Found',
            ],404);
        }
        if($request->quantity < 0) {
            return response()->json([
                'message' => 'Quantity Added Cant Be Less Than Zero',
            ],400);
        }
        $dose->quantity->available += (int)$request->quantity;
        $dose->quantity->save();
        return response()->json([
            'message' => 'Dose Quantity Updated Successfully',
            'dose' => new DoseResource($dose)
        ],200);
    }

    public function updatePrice(Request $request, Medicine $medicine, string $dose_id)
    {
        $dose = MedicineDetails::find($dose_id);
        if(!$medicine || !$dose) {
            return response()->json([
                'message' => 'Medicine Not Found',
            ],404);
        }
        if($request->price < 0) {
            return response()->json([
                'message' => 'Price Cant Be Less Than Zero',
            ],400);
        }
        $dose->price = (int)$request->price;
        $dose->save();
        return response()->json([
            'message' => 'Dose Price Updated Successfully',
            'dose' => new DoseResource($dose)
        ],200);
    }

    public function destroy(Medicine $medicine, MedicineDetails $dose)
    {
        // $dose = MedicineDetails::find($id);
        $dose->delete();
        return response()->json([
            'message' => 'Dose Deleted Successfully',
        ],200);
    }
}
