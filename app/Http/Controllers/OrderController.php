<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return view('pages.orders.order', ['orders' => $orders]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $shipping = Shipping::find($order->shipping_id);
        return view('pages.orders.edit', [
            'shipping' => $shipping,
            'order' => $order,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'resi' => 'required',
        ]);

        $input = $request->all();

        $order = Order::find($id);

        $shipping = Shipping::find($order->shipping_id);
        $shipping['resi'] = $input['resi'];
        $shipping->save();

        $order->status = "processed";
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Nomor Resi Berhasil Diperbaharui');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['payment', 'detailOrder', 'shipping.address.province', 'shipping.address.city'])->where('order.id', $id)->first();

        return view('pages.orders.detail-order', ['order' => $order]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $order = Order::find($id);

        if ($request->status == "Sudah Dibayar") {
            $order->status = "processed";
        } else if ($request->status == "Sudah Diambil") {
            $order->status = "finished";
        }

        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Status Berhasil Diperbaharui');
    }
}
