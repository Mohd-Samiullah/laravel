<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function auth(Request $request)
    {
        // print_r($request->all());
        // die;
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validate) {
            $user = $request->only('username', 'password');
            // print_r($user);
            // die;
            if (Auth::attempt($user)) {
                if (Auth::check()) {
                    $userDetails = Auth::user();
                    // print_r($userDetails);
                    Session::put('name', $userDetails->name);
                    Session::put('userID', $userDetails->id);
                    return redirect('/dashboard');
                }
            }
        } else {
            return redirect()->back();
        }
    }
    public function register()
    {
        $user = new User;
        $pass = 'sami@123';

        $user->name = 'sami';
        $user->username = 'sami';
        $user->email = 'sami@gmail.com';
        $user->password = Hash::make($pass);
        $user->save();
    }
}
