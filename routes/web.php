<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\Check;
use Illuminate\Http\Request;

use App\Http\Controllers\DemoController;


Route::view('/', 'welcome')->middleware(Check::class);

Route::get('/form', [RegisterController::class, 'index']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/view', [RegisterController::class, 'fetchdata']);

Route::get('/edit/{empid}', [RegisterController::class, 'updatedata']);

Route::post('/update/{empid}', [RegisterController::class, 'updated']);

Route::get('/del/{empid}', [RegisterController::class, 'delete']);

Route::get('/user/{id}', function ($id) {
    return "hello $id";
});


Route::get('/input', function () {
    return View('form');
});

Route::get('get-session', function (Request $request) {
    //    return $request->session()->get('fullname');
    //    return session('address');
    echo "<pre>";
    print_r(session()->all());
});



Route::get('put-session', function (Request $request) {
    // $request->session()->put('fullname', 'samiullah');
    // $request->session()->put('address', 'delhi');
    session(['fullname' => 'laravel', 'address' => 'bihar']);
    return 'Session stored successfully!';
});

Route::get('delete-session', function (Request $request) {
    $request->session()->forget('fullname');
    $request->session()->forget(['fullname', 'address']);
    $request->session()->flush();
});

Route::get('/log', [AuthController::class, 'index'])->middleware('guest');
Route::post('login', [AuthController::class, 'auth'])->middleware('guest');
Route::get('register', [AuthController::class, 'register']);

Route::get('dashboard', [DashboardController::class, 'index'])->middleware('userAuthenticate');
Route::get('logout', [DashboardController::class, 'logout']);



// ajax 

Route::get('ajax', [DemoController::class, 'ajaxSend']);
Route::post('ajax-send', [DemoController::class, 'ajaxGet'])->name('ajaxSend');
