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
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validate) {
            $user = $request->only('email', 'password');
            // print_r($user);
            // die;
            if (Auth::attempt($user)) {
                if (Auth::check()) {
                    $userDetails = Auth::user();
                    // print_r($userDetails);
                    // die;
                    Session::put('name', $userDetails->name);
                    Session::put('userID', $userDetails->id);
                    return redirect('/view');
                }
            }
        } else {
            return redirect()->back();
        }
    }
    public function register()
    {
        // print_r($request->all());
        // die;
        $user = new User;
        $pass = 'sami@123';

        $user->name = 'sami';
        $user->username = 'sami';
        $user->email = 'sami@gmail.com';
        $user->password = Hash::make($pass);
        $user->save();
    }
    public function signup()
    {
        return view('signup');
    }
    public function registration(Request $request)
    {
        // print_r($request->all());
        // die;
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User;
        $pass = $request->password;

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($pass);
        $user->save();
        return view('login');
    }
}
