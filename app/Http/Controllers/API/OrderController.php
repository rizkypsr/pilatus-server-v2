<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $order = Order::with('detailOrder.product')->where('user_id', Auth::user()->id)
            ->where('status', $status)
            ->get();

        return ResponseFormatter::success($order, 'Successfully Get All Orders');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'products'      => 'required',
            'total' => 'required',
        ]);

        $shipping = null;

        if ($request->shipping_cost != null) {
            $shipping = Shipping::create([
                'address_id'    => $request->address_id,
                'courier'       => $request->courier,
                'shipping_cost' => $request->shipping_cost,
                'service'       => $request->service,
            ]);
        }

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'shipping_id' => $shipping != null ? $shipping->id : null,
            'status' => 'unpaid',
            'total' => $request->total
        ]);

        $products = $request->products;

        foreach ($products as $product) {
            DetailOrder::create([
                'order_id' => $order->id,
                'product_id' => $product["product_id"],
                'quantity' => $product["quantity"],
            ]);
        }

        return ResponseFormatter::success($order->id, 'Order Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $order = Order::with(['product', 'user', 'payment', 'shipping'])->find($id);

        $order = Order::with(['detailOrder.product', 'payment', 'shipping.address', 'shipping.address.province', 'shipping.address.city'])
            ->where('id', $id)
            ->first();

        return ResponseFormatter::success($order, 'Successfully Get Order');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'required'
        ]);

        if ($request->file('file')) {
            $file = $request->file->store('assets/payment', 'public');

            $payment = Payment::create([
                'photo' => $file
            ]);

            $order = Order::findOrFail($id);
            $order->payment_id = $payment->id;
            $order->update();

            return ResponseFormatter::success([$file], 'Order Successfully Updated');
        }
    }

    public function finishOrder(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = "finished";
        $order->save();

        return ResponseFormatter::success([$order, 'Order Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        Shipping::destroy($order->shipping_id);
        DetailOrder::where("order_id", $id)->delete();

        if ($order->payment_id) {
            Payment::destroy($order->payment_id);
        }

        Order::destroy($id);

        return ResponseFormatter::success($order, 'Order Successfully Deleted');
    }
}
