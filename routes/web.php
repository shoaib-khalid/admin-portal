<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    if(auth()->user()){
        return redirect('dashboard');
    }else{
        // return view('auth.login');
        return redirect('login');
    }
});

Route::group([ "middleware" => ['auth:sanctum', 'verified'] ], function() {

    Route::get('/dashboard', [UserController::class, "daily_sales"])->name('dashboard');
    Route::post('/filter_dashboard', [UserController::class, "daily_sales_filter"])->name('filter_dashboard');
    Route::post('/export_dashboard', [UserController::class, "export_dashboard"])->name('export_dashboard');

    Route::get('/detail', [UserController::class, "daily_details"])->name('detail');
    Route::post('/filter_detail', [UserController::class, "daily_details_filter"])->name('filter_detail');
    Route::post('/export_detail', [UserController::class, "export_detail"])->name('export_detail');

    Route::get('/settlement', [UserController::class, "dashboard_view"])->name('settlement');
    Route::get('/test_api', [UserController::class, "test_api"]);
    Route::get('/user', [ UserController::class, "index_view" ])->name('user');
    Route::view('/user/new', "pages.user.user-new")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');

    Route::get('/export', [UserController::class, "export"])->name('export');

});


