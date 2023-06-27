<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function checkDateSchedule(Request $request)
    {
        try {
            $getAllPaidOrderTimeFrom = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('time_from')->toArray();
            $getAllPaidOrderTimeTo = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('time_to')->toArray();
            $mergeArray = array_merge($getAllPaidOrderTimeFrom, $getAllPaidOrderTimeTo);
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'times' => $mergeArray,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
