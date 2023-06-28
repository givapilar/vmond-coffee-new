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
            $mejaBilliard = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('biliard_id')->toArray();
            $mergeArray = array_merge($getAllPaidOrderTimeFrom, $getAllPaidOrderTimeTo);
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'times' => $mergeArray,
                'billiardIds' => $mejaBilliard,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }

        try {
            $times = Order::where('status_pembayaran', 'Paid')
                ->where('date', $request->date)
                ->where(function ($query) use ($request) {
                    $query->where('time_from', '<=', $request->time_to)
                        ->where('time_to', '>=', $request->time_from);
                })
                ->pluck('biliard_id')
                ->toArray();
        
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'times' => $times,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }
                
        
    }
}
