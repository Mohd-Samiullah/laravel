<?php

use App\Http\Controllers\AjaxForm;
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

Route::get('/view', [RegisterController::class, 'fetchdata'])->middleware('userAuthenticate');

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









Route::get('/log', [AuthController::class, 'index'])->name('log')->middleware('guest');
Route::post('login', [AuthController::class, 'auth'])->middleware('guest');
Route::post('registration', [AuthController::class, 'registration'])->name('registration');
Route::get('signup', [AuthController::class, 'signup'])->name('signup')->middleware('guest');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware('userAuthenticate');
Route::get('logout', [DashboardController::class, 'logout']);









Route::get('ajax', [DemoController::class, 'ajaxSend']);
Route::post('ajax-send', [DemoController::class, 'ajaxGet'])->name('ajaxSend');


// Route::get('ajaxform', [AjaxForm::class, 'index']);
// Route::post('ajaxinsert', [AjaxForm::class, 'insert'])->name('ajaxinsert');
// Route::get('ajaxform', [AjaxForm::class, 'fetch'])->name('ajaxfetch');

Route::get('ajaxform', [AjaxForm::class, 'index'])->name('ajaxform');
Route::post('ajaxinsert', [AjaxForm::class, 'insert'])->name('ajaxinsert');
Route::get('ajaxfetch', [AjaxForm::class, 'fetch'])->name('ajaxfetch');
Route::get('ajaxedit/{id}', [AjaxForm::class, 'edit'])->name('ajaxedit');
Route::put('ajaxupdate/{id}', [AjaxForm::class, 'update'])->name('ajaxupdate');
Route::delete('ajaxdelete/{id}', [AjaxForm::class, 'delete'])->name('ajaxdelete');