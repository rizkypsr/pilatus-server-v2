<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DetailCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cart = Cart::with('detailCart.product')->where('user_id', Auth::user()->id)->first();
        return ResponseFormatter::success($cart, 'Successfully Get All Cart');
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
            'product_id'    => 'required',
        ]);

        $cart = Cart::where('user_id', Auth::user()->id)->first();

        if (empty($cart)) {
            $cart = Cart::create([
                'user_id' => Auth::user()->id,
            ]);
        }

        $detailCart = DetailCart::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!empty($detailCart)) {

            $detailCart->quantity = $detailCart->quantity + 1;
            $detailCart->save();

            return ResponseFormatter::success($detailCart, 'Cart Updated Successfully');
        }

        $detailCart = DetailCart::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => 1,
        ]);

        return ResponseFormatter::success($detailCart, 'Cart Inserted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detailCart = DetailCart::find($id);

        if ($detailCart->quantity == 1) {
            $detailCart->delete($id);
        } else {
            $detailCart->quantity =  $detailCart->quantity - 1;
            $detailCart->save();
        }

        return ResponseFormatter::success($detailCart, 'Cart Deleted Successfully');
    }
}
