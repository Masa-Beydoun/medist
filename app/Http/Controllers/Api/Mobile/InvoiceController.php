<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function createInvoice(Request $request) {
        $orders = Order::whereIn('id', $request->id)->get();
        $pharmacist = auth()->guard('sanctum')->user();
        $data = [
            'orders' => $orders,
            'pharmacist' => $pharmacist
        ];

        $pdf = Pdf::loadView('invoice', $data);
        $output = $pdf->output();
        return response()->json([
            'pdf' => base64_encode($output)
        ]);
        // return $pdf->stream();
    }
}
