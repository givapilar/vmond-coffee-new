<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;
class HistoryController extends Controller
{
    public function index($id)
    {
        // $ids = decrypt($id);
        // $decrypted = Crypt::decryptString($id);
        // $data['orders'] = Order::findorFail($decrypted);
        // dd($data['orders']->order);
        $data['orders'] = Order::findorFail($id);
        // dd($data['orders']->orderPivot);
        $data['orders_pivots'] = OrderPivot::get();
        // dd($data['orders_pivots'])->restaurant;

        return view('history.index',$data);
    }
    public function pdfExport($id)
    {
        $data = Order::findorFail($id);

        $pdf = PDF::loadview('history.cetak-pdf',['orders'=>$data]);
        return $pdf->download('History-pdf.pdf');
    }
}
