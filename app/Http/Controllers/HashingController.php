<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HashingController extends Controller
{
    public function index()
    {
        return view('hashing');
    }

    public function generate(Request $request)
    {

        $password = $request->input('plain_text');
        $hashedPassword = bcrypt($password, [
            'rounds' => $request->input('cost_factor')
        ]);

        return view('hashing', ['password' => $password, 'hashedPassword' => $hashedPassword]);
    }

    public function verify(Request $request)
    {
        // contoh hash yang disimpan di database
        $passwordVerify = $request->input('verify_plain_text');

        // contoh plaintext password yang akan divalidasi
        $hashVerify = $request->input('verify_hash');

        if (password_verify($passwordVerify, $hashVerify)) {
            return view('hashing', [
                'verify_plain_text' => $passwordVerify,
                'verify_hash' => $hashVerify,
                'verification' => 'valid'
            ]);
        } else {
            return view('hashing', [
                'verify_plain_text' => $passwordVerify,
                'verify_hash' => $hashVerify,
                'verification' => 'invalid'
            ]);
        }
    }
}
