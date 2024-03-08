<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineStoreRequest;
use App\Http\Resources\DashboardMedicineDetailsResource;
use App\Http\Resources\DashboardMedicineResource;
use App\Http\Resources\DoseResource;
use App\Http\Resources\ExpiredDosesResource;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use App\Models\MedicineDetails;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineStoreRequest $request)
    {
        $data = $request->validated();
        $medicine = Medicine::create([
            'commercial_name' => [
                'en' => $data['commercial_name'],
                'ar' => $request->ar_commercial_name,
            ],
            'scientific_name' => [
                'en' => $data['scientific_name'],
                'ar' => $request->ar_scientific_name,
            ],
            'description' => [
                'en' => $data['description'],
                'ar' => $request->ar_description,
            ],
        ]);
        $image = $data['image'];
        $imageName = time() . '.' . 'jpg';
        $medicine->addMediaFromBase64($image)->usingFileName($imageName)->toMediaCollection('medicine');
        // $medicine->addMedia("download.jpg")->preservingOriginal()->toMediaCollection('medicines');
        $medicine->category()->associate($data['category_id']);
        $medicine->company()->associate($data['company_id']);
        $medicine->warehouse()->associate(auth()->guard('sanctum')->user()->id);
        $medicine->save();
        return response()->json([
            'message' => 'Medicine Added',
            'medicine' => new DashboardMedicineResource($medicine)
        ], 200);
    }

    public function search(Request $request)
    {
        $data = Medicine::where('commercial_name', 'like', '%' . $request->search . '%')
            ->orWhere('scientific_name', 'like', '%' . $request->search . '%')
            ->get();
        $medicines = [];
        foreach ($data as $medicine) {
            if ($medicine->warehouse_id == auth()->guard('sanctum')->user()->id) {
                $medicines[] = $medicine;
            }
        }
        if (!$medicines) {
            return response()->json([
                'message' => 'No Medicine Found'
            ], 404);
        }
        return response()->json([
            'message' => 'All Company Medicines Retrieved Successfully',
            'count' => count($medicines),
            'medicine' => DashboardMedicineResource::collection($medicines)
        ], 200);
    }

    public function index()
    {
        $medicines = Medicine::where('warehouse_id', auth()->guard('sanctum')->user()->id)->get();
        return response()->json([
            'message' => 'All Medicines Retrieved Successfully Successfully',
            'count' => count($medicines),
            'medicine' => DashboardMedicineResource::collection($medicines)
        ], 200);
    }

    public function destroy(string $id)
    {
        $medicine = Medicine::find($id);
        if (auth()->guard('sanctum')->user()->id != $medicine->warehouse_id) {
            return response()->json([
                'message' => 'Not Authorized To Delete This Medicine',
            ], 400);
        }
        $medicine->details()->delete();
        $medicine->delete();
        return response()->json([
            'message' => 'Medicine Deleted Successfully',
        ], 200);
    }


    public function expired(Medicine $medicine)
    {
        $doses = $medicine->details->where('is_expired', true);
        return response()->json([
            'message' => 'Expired Doses Retrieved Successfully',
            'count' => count($doses),
            'expired_doses' => ExpiredDosesResource::collection($doses)
        ], 200);
    }

    public function show(Medicine $medicine)
    {
        return response()->json([
            'message' => 'Medicine Details Retrieved Successfully',
            'medicine' => new DashboardMedicineDetailsResource($medicine)
        ], 200);
    }
}
