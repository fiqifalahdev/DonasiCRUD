<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return 'OK';
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|min:8|max:20',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|confirmed',
            'name' => 'required|max:30',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        dd($validatedData);
    }
}
