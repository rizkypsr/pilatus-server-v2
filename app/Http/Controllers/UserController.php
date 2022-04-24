<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{

    use HasApiTokens;

    public function index()
    {
        $users = User::all();
        return view('pages.users.user', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.users.create');
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
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required',
            'gender'   => 'required',
            'roles'    => 'required',
            'phone'    => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        User::Create($input);

        return redirect()->route('users.index')
            ->with('success', 'User Berhasil Ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required',
        ]);

        $input = $request->all();

        $user->update($input);

        return redirect()->route('users.index')
            ->with('success', 'User Berhasil Diperbaharui');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return redirect()->route('dashboard');
    }
}
