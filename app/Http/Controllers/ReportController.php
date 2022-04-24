<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'detailOrder', 'shipping.address.province', 'shipping.address.city'])->get();

        // dd($orders);

        return view('pages.reports.reports', [
            'orders' => $orders
        ]);
    }
}
