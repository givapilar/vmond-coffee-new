<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class APIController extends Controller
{
    // public function checkDateSchedule(Request $request)
    // {
    //     try {
    //         $getAllPaidOrderTimeFrom = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('time_from')->toArray();
    //         $getAllPaidOrderTimeTo = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('time_to')->toArray();
    //         $getBiliard = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('biliard_id')->toArray();
    //         $mergeArray = array_merge($getAllPaidOrderTimeFrom, $getAllPaidOrderTimeTo,$getBiliard);
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'success',
    //             'times' => $mergeArray,
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => $th->getMessage(),
    //         ]);
    //     }

    // }
    public function checkDateSchedule(Request $request)
    {
        try {
            // billiard_id
            $orders = Order::where('status_pembayaran', 'Paid')
                ->whereDate('date', $request->date)
                ->where('biliard_id', $request->billiard_id)
                ->select('time_from', 'time_to', 'biliard_id')
                ->get();

            $timeFrom = [];
            $timeTo = [];
            $billiards = [];
            foreach ($orders as $order) {
                $timeFrom[] = substr($order->time_from, 0, 5);
                $timeTo[] = substr($order->time_to, 0, 5);
                $billiards[] = strval($order->biliard_id);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'timeFrom' => $timeFrom,
                'timeTo' => $timeTo,
                'billiards' => $billiards,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function checkDateScheduleMeeting(Request $request)
    {
        try {
            // Meeting_id
            $orders = Order::where('status_pembayaran', 'Paid')
                ->whereDate('date', $request->date)
                ->where('meeting_room_id', $request->meeting_room_id)
                ->select('time_from', 'time_to', 'meeting_room_id')
                ->get();

            $times = [];
            $meetings = [];
            foreach ($orders as $order) {
                $times[] = substr($order->time_from, 0, 5);
                $times[] = substr($order->time_to, 0, 5);
                $meetings[] = strval($order->meeting_room_id);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'times' => $times,
                'meetings' => $meetings,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }
    }

}
