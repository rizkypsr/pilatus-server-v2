<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $address = Address::with(['province', 'city'])
            ->where('id', Auth::user()->address_id)
            ->first();

        return ResponseFormatter::success($address, 'Successfully Get Address');
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
            'street' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'district' => 'required',
        ]);

        $input = $request->all();

        $addressId = Auth::user()->address_id;

        if ($addressId != null) {
            $address = Address::where('id', $addressId)->update($input);
        } else {
            $address = Address::create($input);
            User::where('id', Auth::user()->id)->update(["address_id" => $address->id]);
        }

        return ResponseFormatter::success($address, 'Address Inserted Successfully');
    }
}
