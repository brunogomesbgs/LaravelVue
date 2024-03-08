<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User as Users;
use Illuminate\Support\Facades\Auth;

class User extends Controller
{
    public function logIn(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt([
            'name' => $request['name'],
            'password' => $request['password']
        ])) {
            return response()->json(Users::where('name', $request['name'])->get());
        }

        return response()->json("User or Password dont match", 401);
    }

    public function addUser(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
            'name' => 'required'
        ]);

        if (!$validate) {
            return response()->json('User not add', 400);
        }

        $user = new Users();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->save();

        return response()->json( $user,201);
    }

    public function getAll()
    {
        return response()->json(Users::all());
    }
}
