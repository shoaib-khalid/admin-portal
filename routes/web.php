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

    // enhancement 
    // 1. After sort, url changed to filter_settlement instead of changed url name, better go with settlement?from=data&to=date
    // 2. By doing that, current page load can use datarange data from previous on excel upload
    Route::get('/settlement', [UserController::class, "settlement"])->name('settlement');
    Route::post('/filter_settlement', [UserController::class, "filter_settlement"])->name('filter_settlement');
    Route::post('/export_settlement', [UserController::class, "export_settlement"])->name('export_settlement');

    Route::get('/test_api', [UserController::class, "test_api"]);
    Route::get('/user', [ UserController::class, "index_view" ])->name('user');
    Route::view('/user/new', "pages.user.user-new")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');

    Route::get('/export', [UserController::class, "export"])->name('export');

    Route::get('/merchant', [UserController::class, "merchant"])->name('merchant');
    Route::post('/filter_merchant', [UserController::class, "filter_merchant"])->name('filter_merchant');
    Route::post('/export_merchant', [UserController::class, "export_merchant"])->name('export_merchant');
    

});


