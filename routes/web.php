<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityDateController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PromotextController;
use App\Http\Controllers\FeaturedStoreController;
use App\Http\Controllers\FeaturedProductController;
use App\Http\Controllers\FeaturedLocationController;
use App\Http\Controllers\CityRegionController;
use App\Http\Controllers\FeaturedCategoryController;
use App\Http\Controllers\MarketBannerController;
use App\Http\Controllers\MarketPopupController;
use App\Http\Controllers\ParentCategoryController;
use App\Http\Controllers\OgTagController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MobileLogController;
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
        // $_SESSION['country']="PAKISTAN";
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

    Route::get('/merchantappactivity', [UserController::class, "merchantappactivity"])->name('merchantappactivity');
    Route::get('/filter_merchantappactivity', [UserController::class, "filter_merchantappactivity"])->name('filter_merchantappactivity');
    Route::post('/filter_merchantappactivity', [UserController::class, "filter_merchantappactivity"])->name('filter_merchantappactivity');
    Route::post('/export_merchantappactivity', [UserController::class, "export_merchantappactivity"])->name('export_merchantappactivity');

    Route::get('/pendingrefund', [RefundController::class, "pendingrefund"])->name('pendingrefund');
    Route::post('/filter_pendingrefund', [RefundController::class, "filter_pendingrefund"])->name('filter_pendingrefund');
    Route::post('/export_pendingrefund', [RefundController::class, "export_pendingrefund"])->name('export_pendingrefund');
    Route::post('/update_refund', [RefundController::class, "update_refund"])->name('update_refund');

    Route::get('/refundhistory', [RefundController::class, "refundhistory"])->name('refundhistory');
    Route::post('/filter_refundhistory', [RefundController::class, "filter_refundhistory"])->name('filter_refundhistory');
    Route::post('/export_refundhistory', [RefundController::class, "export_refundhistory"])->name('export_refundhistory');

 
    Route::get('/useractivitylog', [ActivityController::class, "useractivitylog"])->name('useractivitylog');
    Route::post('/filter_useractivitylog', [ActivityController::class, "filter_useractivitylog"])->name('filter_refundhistory');
    Route::get('/filter_useractivitylog', [ActivityController::class, "filter_useractivitylog"])->name('filter_refundhistory');
    Route::post('/export_useractivitylog', [ActivityController::class, "export_useractivitylog"])->name('export_useractivitylog');
    Route::get('/getactivity_details/{sessionId}', [ActivityController::class, "getactivity_details"])->name('getactivity_details');
    Route::get('/getcart_details/{sessionId}', [ActivityController::class, "getcart_details"])->name('getcart_details');
    Route::get('/getorder_details/{sessionId}', [ActivityController::class, "getorder_details"])->name('getorder_details');

    Route::get('/usersitemap', [ActivityController::class, "usersitemap"])->name('usersitemap');
    Route::post('/filter_usersitemap', [ActivityController::class, "filter_usersitemap"])->name('filter_usersitemap');
    Route::get('/filter_usersitemap', [ActivityController::class, "filter_usersitemap"])->name('filter_usersitemap');
    Route::post('/export_usersitemap', [ActivityController::class, "export_usersitemap"])->name('export_usersitemap');

    Route::get('/userdata', [ActivityController::class, "userdata"])->name('userdata');
    Route::get('/filter_userdata', [ActivityController::class, "filter_userdata"])->name('filter_userdata');
    Route::get('/getuserdatadetails_incompleteorder/{customerId}', [ActivityController::class, "getuserdatadetails_incompleteorder"])->name('getuserdatadetails_incompleteorder');
    Route::get('/getuserdatadetails_completeorder/{customerId}', [ActivityController::class, "getuserdatadetails_completeorder"])->name('getuserdatadetails_completeorder');
    Route::get('/getuserdatadetails_abandoncart/{customerId}', [ActivityController::class, "getuserdatadetails_abandoncart"])->name('getuserdatadetails_abandoncart');
    Route::post('/filter_userdata', [ActivityController::class, "filter_userdata"])->name('filter_userdata');
    Route::post('/export_userdata', [ActivityController::class, "export_userdata"])->name('export_userdata');

    Route::get('/visitchannel', [ActivityController::class, "visitchannel"])->name('visitchannel');
    Route::post('/filter_visitchannel', [ActivityController::class, "filter_visitchannel"])->name('filter_visitchannel');
    Route::post('/export_visitchannel', [ActivityController::class, "export_visitchannel"])->name('export_visitchannel');

    Route::get('/userincompleteorder', [ActivityController::class, "userincompleteorder"])->name('userincompleteorder');
    Route::post('/filter_userincompleteorder', [ActivityController::class, "filter_userincompleteorder"])->name('filter_userincompleteorder');
    Route::get('/filter_userincompleteorder', [ActivityController::class, "filter_userincompleteorder"])->name('filter_userincompleteorder');
    Route::get('/getdetails_incompleteorder/{customerId}', [ActivityController::class, "getdetails_incompleteorder"])->name('getdetails_incompleteorder');
    Route::post('/export_userincompleteorder', [ActivityController::class, "export_userincompleteorder"])->name('export_userincompleteorder');

    Route::get('/useractivitysummary', [ActivityController::class, "useractivitysummary"])->name('useractivitysummary');
    Route::post('/filter_useractivitysummary', [ActivityController::class, "filter_useractivitysummary"])->name('filter_useractivitysummary');
    Route::post('/export_useractivitysummary', [ActivityController::class, "export_useractivitysummary"])->name('export_useractivitysummary');

    Route::get('/useractivitysummarydate', [ActivityDateController::class, "useractivitysummarydate"])->name('useractivitysummarydate');
    Route::post('/filter_useractivitysummarydate', [ActivityDateController::class, "filter_useractivitysummarydate"])->name('filter_useractivitysummarydate');
    Route::post('/export_useractivitysummarydate', [ActivityDateController::class, "export_useractivitysummarydate"])->name('export_useractivitysummarydate');

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
    Route::post('/voucherdelete', [VoucherController::class, "voucherdelete"])->name('voucherdelete');
    Route::post('/post_voucherdelete', [VoucherController::class, "post_voucherdelete"])->name('post_voucherdelete');
    Route::get('/voucherclaim/{voucherId}', [VoucherController::class, "voucherclaim"])->name('voucherclaim');
    Route::get('/voucherredeem/{voucherId}', [VoucherController::class, "voucherredeem"])->name('voucherredeem');
    Route::post('/export_voucherlist', [VoucherController::class, "export_voucherlist"])->name('export_voucherlist');

    Route::get('/promotext', [PromotextController::class, "index"])->name('promotext');
    Route::post('/add_promotext', [PromotextController::class, "add_promotext"])->name('add_promotext');
    Route::post('/edit_promotext', [PromotextController::class, "edit_promotext"])->name('edit_promotext');
    Route::post('/delete_promotext', [PromotextController::class, "delete_promotext"])->name('delete_promotext');
    Route::post('/post_editpromotext', [PromotextController::class, "post_editpromotext"])->name('post_editpromotext');
    Route::post('/filter_promotext', [PromotextController::class, "filter_promotext"])->name('filter_promotext');

    Route::get('/featuredstore', [FeaturedStoreController::class, "index"])->name('featuredstore');
    Route::post('/filter_store', [FeaturedStoreController::class, "filter_store"])->name('filter_store');
    Route::post('/add_featuredstore', [FeaturedStoreController::class, "add_featuredstore"])->name('add_featuredstore');
    Route::post('/edit_featuredstore', [FeaturedStoreController::class, "edit_featuredstore"])->name('edit_featuredstore');
    Route::post('/delete_featuredstore', [FeaturedStoreController::class, "delete_featuredstore"])->name('delete_featuredstore');
    Route::post('/deletemultiple_featuredstore', [FeaturedProductController::class, "deletemultiple_featuredstore"])->name('deletemultiple_featuredstore');
    Route::post('/post_editfeaturedstore', [FeaturedStoreController::class, "post_editfeaturedstore"])->name('post_editfeaturedstore');
    Route::post('/storeSearchByLocation', [FeaturedStoreController::class, "storeSearchByLocation"])->name('storeSearchByLocation');
    Route::post('/filterLocation', [FeaturedStoreController::class, "filterLocation"])->name('filterLocation');
    Route::post('/deletemultiple_featuredstore', [FeaturedStoreController::class, "deletemultiple_featuredstore"])->name('deletemultiple_featuredstore');
    
    Route::get('/featuredproduct', [FeaturedProductController::class, "index"])->name('featuredproduct');    
    Route::post('/filter_product', [FeaturedProductController::class, "filter_product"])->name('filter_product');
    Route::post('/add_featuredproduct', [FeaturedProductController::class, "add_featuredproduct"])->name('add_featuredproduct');
    Route::post('/edit_featuredproduct', [FeaturedProductController::class, "edit_featuredproduct"])->name('edit_featuredproduct');
    Route::post('/delete_featuredproduct', [FeaturedProductController::class, "delete_featuredproduct"])->name('delete_featuredproduct');
    Route::post('/deletemultiple_featuredproduct', [FeaturedProductController::class, "deletemultiple_featuredproduct"])->name('deletemultiple_featuredproduct');
    Route::post('/post_featuredproduct', [FeaturedProductController::class, "post_editfeaturedproduct"])->name('post_editfeaturedproduct');
    Route::post('/searchByLocation', [FeaturedProductController::class, "searchByLocation"])->name('searchByLocation');
    
    Route::get('/featuredlocation', [FeaturedLocationController::class, "index"])->name('featuredlocation');    
    Route::post('/filter_location', [FeaturedLocationController::class, "filter_location"])->name('filter_location');
    Route::post('/edit_featuredlocation', [FeaturedLocationController::class, "edit_featuredlocation"])->name('edit_featuredlocation');

    Route::get('/citylocation', [CityRegionController::class, "citylocation"])->name('citylocation');
    Route::post('/filter_citylocation', [CityRegionController::class, "filter_citylocation"])->name('filter_citylocation');
    Route::post('/add_location', [CityRegionController::class, "add_location"])->name('add_location');
    Route::post('/delete_location', [CityRegionController::class, "delete_location"])->name('delete_location');
    Route::post('/edit_location', [CityRegionController::class, "edit_location"])->name('edit_location');

    Route::get('/cityregion', [CityRegionController::class, "index"])->name('cityregion');            
    Route::post('/filterCity', [CityRegionController::class, "filterCity"])->name('filterCity');
    Route::post('/searchCity', [CityRegionController::class, "searchCity"])->name('searchCity');
    Route::post('/filter_cityregion', [CityRegionController::class, "filter_cityregion"])->name('filter_cityregion');
    Route::post('/add_cityregion', [CityRegionController::class, "add_cityregion"])->name('add_cityregion');
    Route::post('/delete_cityregion', [CityRegionController::class, "delete_cityregion"])->name('delete_cityregion');
    
    Route::get('/parentcategory', [ParentCategoryController::class, "index"])->name('parentcategory');
    Route::post('/filter_parentcategory', [ParentCategoryController::class, "filter_parentcategory"])->name('filter_parentcategory');
    Route::post('/add_parentcategory', [ParentCategoryController::class, "add_parentcategory"])->name('add_location');
    Route::post('/delete_parentcategory', [ParentCategoryController::class, "delete_parentcategory"])->name('delete_location');
    Route::post('/edit_parentcategory', [ParentCategoryController::class, "edit_parentcategory"])->name('edit_location');

    Route::get('/featuredcategory', [FeaturedCategoryController::class, "index"])->name('featuredcategory');   
    Route::post('/searchByVertical', [FeaturedCategoryController::class, "searchByVertical"])->name('searchByVertical');        
    Route::post('/searchCityCategory', [FeaturedCategoryController::class, "searchCityCategory"])->name('searchCityCategory');        
    Route::post('/filter_featuredcategory', [FeaturedCategoryController::class, "filter_featuredcategory"])->name('filter_featuredcategory');
    Route::post('/add_featuredcategory', [FeaturedCategoryController::class, "add_featuredcategory"])->name('add_featuredcategory');
    Route::post('/edit_featuredcategory', [FeaturedCategoryController::class, "edit_featuredcategory"])->name('edit_featuredcategory');
    Route::post('/delete_featuredcategory', [FeaturedCategoryController::class, "delete_featuredcategory"])->name('delete_featuredcategory');  

    Route::get('/marketbanner', [MarketBannerController::class, "index"])->name('marketbanner');    
    Route::post('/filter_marketbanner', [MarketBannerController::class, "filter_marketbanner"])->name('filter_marketbanner');
    Route::post('/add_marketbanner', [MarketBannerController::class, "add_marketbanner"])->name('add_marketbanner');   
    Route::post('/edit_marketbanner', [MarketBannerController::class, "edit_marketbanner"])->name('edit_marketbanner');
    Route::post('/delete_marketbanner', [MarketBannerController::class, "delete_marketbanner"])->name('delete_marketbanner'); 

    Route::get('/marketpopup', [MarketPopupController::class, "index"])->name('marketpopup');
    Route::post('/filter_marketpopup', [MarketPopupController::class, "filter_marketpopup"])->name('filter_marketpopup');    
    Route::post('/add_marketpopup', [MarketPopupController::class, "add_marketpopup"])->name('add_marketpopup');  
    Route::post('/edit_marketpopup', [MarketPopupController::class, "edit_marketpopup"])->name('edit_marketpopup');
    Route::post('/delete_marketpopup', [MarketPopupController::class, "delete_marketpopup"])->name('delete_marketpopup'); 

    Route::get('/ogtag', [OgTagController::class, "index"])->name('ogtag');
    Route::post('/index_filter', [OgTagController::class, "index_filter"])->name('index_filter');
    Route::post('/add_ogtag', [OgTagController::class, "add_ogtag"])->name('add_ogtag');
    Route::post('/edit_ogtag', [OgTagController::class, "edit_ogtag"])->name('edit_ogtag');
    Route::get('/edit_ogtag', [OgTagController::class, "edit_ogtag"])->name('edit_ogtag');
    Route::post('/delete_ogtag', [OgTagController::class, "delete_ogtag"])->name('delete_ogtag');
    Route::post('/post_edit_ogtag', [OgTagController::class, "post_edit_ogtag"])->name('post_edit_ogtag');
    Route::get('/post_edit_ogtag', [OgTagController::class, "post_edit_ogtag"])->name('post_edit_ogtag');

    Route::get('/groupsales', [UserController::class, "daily_group_details"])->name('groupsales');   
    Route::post('/filter_groupsales', [UserController::class, "filter_daily_group_details"])->name('filter_groupsales');
    Route::post('/export_groupsales', [UserController::class, "export_daily_group_details"])->name('export_groupsales');
      
    Route::get('/voucherredemption', [UserController::class, "voucherredemption"])->name('voucherredemption');   
    Route::post('/filter_voucherredemption', [UserController::class, "filter_voucherredemption"])->name('filter_voucherredemption');  
    Route::post('/export_voucherredemption', [UserController::class, "export_voucherredemption"])->name('export_voucherredemption');


    Route::get('/tag', [TagController::class, "index"])->name('tag');
    Route::post('/tag_filter', [TagController::class, "tag_filter"])->name('tag_filter');
    Route::post('/add_tag', [TagController::class, "add_tag"])->name('add_tag');
    Route::get('/edit_tag', [TagController::class, "edit_tag"])->name('edit_tag');
    Route::post('/save_edit_tag', [TagController::class, "save_edit_tag"])->name('save_edit_tag');
    Route::post('/delete_tag', [TagController::class, "delete_tag"])->name('delete_tag');
    Route::post('/post_edit_tag', [TagController::class, "post_edit_tag"])->name('post_edit_tag');

    Route::get('/add_tag_details', [TagController::class, "add_tag_details"])->name('add_tag_details');
    Route::post('/save_tag_details', [TagController::class, "save_tag_details"])->name('save_tag_details');
    Route::post('query_tag_details', [TagController::class, "query_tag_details"])->name('query_tag_details');
    Route::post('deletemultiple_tag_details', [TagController::class, "deletemultiple_tag_details"])->name('deletemultiple_tag_details');


    Route::get('/add_tag_config', [TagController::class, "add_tag_config"])->name('add_tag_config');
    Route::post('/save_tag_config', [TagController::class, "save_tag_config"])->name('save_tag_config');
    Route::post('query_tag_config', [TagController::class, "query_tag_config"])->name('query_tag_config');
    Route::post('deletemultiple_tag_config', [TagController::class, "deletemultiple_tag_config"])->name('deletemultiple_tag_config');
    Route::post('/filter_category', [FeaturedCategoryController::class, "filter_category"])->name('filter_category');


    Route::get('/mobilelog', [MobileLogController::class, "index"])->name('mobilelog');
    Route::post('/mobilelog_filter', [MobileLogController::class, "mobilelog_filter"])->name('mobilelog_filter');
});
