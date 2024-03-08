<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // public function createInvoice(Request $request) {
    //     $orders = Order::whereIn('id', $request->id)->get();
    //     $data = [
    //         'orders' => $orders
    //     ];

    //     $pdf = Pdf::loadView('invoice', $data);
    //     return $pdf->stream();
    // }

    public function createInvoice(Request $request) {
        $orders = Order::betweenDates([$request->start, $request->end])
                        ->where('warehouse_id', auth()->guard('sanctum')->user()->id)->get();
        $data = [
            'orders' => $orders,
            'start_date' => $request->start,
            'end_date' => $request->end,
        ];

        $pdf = Pdf::loadView('invoice-dashboard', $data);
        $output = $pdf->output();
        return response()->json([
            'pdf' => base64_encode($output)
        ]);
        // return $pdf->stream();
    }
}
