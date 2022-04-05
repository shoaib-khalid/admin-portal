<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\VoucherController;
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

    Route::get('/settlement2', [SettlementController::class, "settlement2"])->name('settlement2');
    Route::post('/filter_settlement2', [SettlementController::class, "filter_settlement2"])->name('filter_settlement2');
    Route::post('/export_settlement2', [SettlementController::class, "export_settlement2"])->name('export_settlement2');
    Route::post('/update_settlement2', [SettlementController::class, "update_settlement2"])->name('update_settlement2');

    Route::get('/test_api', [UserController::class, "test_api"]);
    Route::get('/user', [ UserController::class, "index_view" ])->name('user');
    Route::view('/user/new', "pages.user.user-new")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');

    Route::get('/export', [UserController::class, "export"])->name('export');

    Route::get('/merchant', [UserController::class, "merchant"])->name('merchant');
    Route::post('/filter_merchant', [UserController::class, "filter_merchant"])->name('filter_merchant');
    Route::post('/export_merchant', [UserController::class, "export_merchant"])->name('export_merchant');
    
    Route::get('/pendingrefund', [RefundController::class, "pendingrefund"])->name('pendingrefund');
    Route::post('/filter_pendingrefund', [RefundController::class, "filter_pendingrefund"])->name('filter_pendingrefund');
    Route::post('/export_pendingrefund', [RefundController::class, "export_pendingrefund"])->name('export_pendingrefund');
    Route::post('/update_refund', [RefundController::class, "update_refund"])->name('update_refund');

    Route::get('/refundhistory', [RefundController::class, "refundhistory"])->name('refundhistory');
    Route::post('/filter_refundhistory', [RefundController::class, "filter_refundhistory"])->name('filter_refundhistory');
    Route::post('/export_refundhistory', [RefundController::class, "export_refundhistory"])->name('export_refundhistory');

    Route::get('/useractivitylog', [ActivityController::class, "useractivitylog"])->name('useractivitylog');
    Route::post('/filter_useractivitylog', [ActivityController::class, "filter_useractivitylog"])->name('filter_refundhistory');
    Route::post('/export_useractivitylog', [ActivityController::class, "export_useractivitylog"])->name('export_refundhistory');

    Route::get('/usersitemap', [ActivityController::class, "usersitemap"])->name('usersitemap');
    Route::post('/filter_usersitemap', [ActivityController::class, "filter_usersitemap"])->name('filter_usersitemap');
    Route::post('/export_usersitemap', [ActivityController::class, "export_usersitemap"])->name('export_usersitemap');

    Route::get('/useractivitysummary', [ActivityController::class, "useractivitysummary"])->name('useractivitysummary');
    Route::post('/filter_useractivitysummary', [ActivityController::class, "filter_useractivitysummary"])->name('filter_useractivitysummary');
    Route::post('/export_useractivitysummary', [ActivityController::class, "export_useractivitysummary"])->name('export_useractivitysummary');

    Route::get('/userabandoncartsummary', [ActivityController::class, "userabandoncartsummary"])->name('userabandoncartsummary');
    Route::post('/filter_userabandoncartsummary', [ActivityController::class, "filter_userabandoncartsummary"])->name('filter_userabandoncartsummary');
    Route::post('/export_userabandoncartsummary', [ActivityController::class, "export_userabandoncartsummary"])->name('export_userabandoncartsummary');

    Route::get('/userabandoncart', [ActivityController::class, "userabandoncart"])->name('userabandoncart');
    Route::post('/filter_userabandoncart', [ActivityController::class, "filter_userabandoncart"])->name('filter_userabandoncart');
    Route::post('/export_userabandoncart', [ActivityController::class, "export_userabandoncart"])->name('export_userabandoncart');

    Route::get('/voucheradd', [VoucherController::class, "voucheradd"])->name('voucheradd');
    Route::post('/post_voucheradd', [VoucherController::class, "post_voucheradd"])->name('post_voucheradd');
    Route::get('/voucherlist', [VoucherController::class, "voucherlist"])->name('voucherlist');
    Route::post('/filter_voucherlist', [VoucherController::class, "filter_voucherlist"])->name('filter_voucherlist');
    Route::post('/voucheredit', [VoucherController::class, "voucheredit"])->name('voucheredit');
    Route::post('/post_voucheredit', [VoucherController::class, "post_voucheredit"])->name('post_voucheredit');
});


