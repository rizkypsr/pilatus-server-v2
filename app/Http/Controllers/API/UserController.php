<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    use PasswordValidationRules;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request([
                'email',
                'password'
            ]);

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'user'         => $user
            ], 'Authenticated');
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error'   => $err
            ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string',
                'email'    => 'required|string|email|unique:users',
                'password' => 'required',
                'phone'    => 'required',
                'street'   => 'required',
                'province_id' => 'required',
                'city_id'     => 'required',
                'postal_code' => 'required',
                'district'    => 'required'
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(['error' => $validator->errors()], 'Register Failed', 403);
            }

            $address =  Address::Create([
                'street'      => $request->street,
                'province_id' => $request->province_id,
                'city_id'     => $request->city_id,
                'postal_code' => $request->postal_code,
                'district'    => $request->district
            ]);

            User::Create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make($request->password),
                'phone'  => $request->phone,
                'address_id' => $address->id
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'user'         => $user
            ], 'Authenticated', 201);
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error'   => $err
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        // Auth()->user()->tokens()->delete();

        return redirect()->route('dashboard');
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Successfully get User');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error' => $validator->errors()], 'Register Failed', 403);
        }

        $user = Auth::user();

        $user->email = $request->email;
        $user->name = $request->name;
        $user->update();

        return ResponseFormatter::success($user, 'User Updated Successfully');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                ["error" => $validator->errors()],
                'Update Photo Failed',
                401
            );
        }

        if ($request->file('file')) {
            $file = $request->file->store('assets/user', 'public');

            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([
                $file
            ], 'Successfuly Uploaded');
        }
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();

        if ($data['email'] == $user->email) {
            $user->update([
                "name" => $data["name"]
            ]);
        } else if ($data['name'] == $user->name) {
            $user->update([
                "email" => $data["email"]
            ]);
        }

        return ResponseFormatter::success($user, 'Profile Updated');
    }
}
