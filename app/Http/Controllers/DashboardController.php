<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    public function index()
    {
        return "welcome to dashboard " . Session::get('name');
    }
    public function logout()
    {
        Session::flush();
        redirect('/log');
    }
}
