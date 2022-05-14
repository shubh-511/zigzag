<?php

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
Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/', function () {
    //return view('frontend.index');
    return redirect('admin');
});

/*
*/
//Route::group(['middleware'=>['auth'],'prefix' => 'admin'],function(){
  Route::resource('/admin/provider-menu','ProviderMenuController');
  Route::resource('admin/customization','CustomisationController');
//});

//product customisation
Route::post('/admin/customisation','ProductController@customisation');

Route::get('reset-password/{email?}', 'HodController@reset_password')->name('reset-password');
Route::post('reset-password/{email?}', 'HodController@store_password')->name('reset-password');


Route::post('admin/logout','AdminController@logout')->name('logout');
//-------------------- Password Recovery Routes ------------- 
Route::get('/admin/forgotpass','AdminController@forgotpass');
Route::post('/admin/sendpassword','AdminController@sendpassword');

//search
Route::get('admin/search_app_user/','UsersController@search_app_user');
Route::get('admin/search_providers/','SignupAsProviderController@search_providers');
Route::get('admin/search_drivers/','UsersController@search_drivers');
Route::get('admin/search_orders/','OrderController@search_orders');

//----------------------- All Admin Routes -----------------
Route::post('/admin/{method?}/{id?}','AdminController@postMethods');
Route::get('/admin/{method1?}/{method2?}/{id?}','AdminController@getMethods');

//----------------------- All Service Provider Routes -----------------
Route::get('/signup-as-provider','SignupAsProviderController@addUserProvider');
Route::post('signupasprovider','SignupAsProviderController@PostUserProvider');

Route::resource('admin/provider-menu','ProviderMenuController');
Route::post('provider-menu/deleteallprovidermenu','ProviderMenuController@destroy_all');
Route::any('provider-menu/updateprovidermenustatus','ProviderMenuController@update_status');
Route::post('provider-menu/update_menu/{id?}','ProviderMenuController@update_menu');

Route::resource('admin/customization','CustomisationController');
Route::post('customization/deleteallcustomization','CustomisationController@destroy_all');
Route::any('customization/updatecustomizationstatus','CustomisationController@update_status');
Route::post('customization/update_customization/{id?}','CustomisationController@update_customization');

//********************** Delivery Charges ************;
	Route::get('admin/locations/search','DeliveryChargeController@search');
	Route::get('admin/locations','DeliveryChargeController@index');
	Route::get('admin/locations/view/{slug?}','DeliveryChargeController@view');
	Route::get('admin/locations/edit/{slug?}','DeliveryChargeController@edit');
	Route::post('admin/locations/update/{slug?}','DeliveryChargeController@update');
	Route::get('admin/locations/create/','DeliveryChargeController@create');
	Route::post('admin/locations/store/','DeliveryChargeController@store');
	Route::get('admin/locations/status','DeliveryChargeController@status');
	Route::post('admin/locations/delete','DeliveryChargeController@distroy');



//----------------------- All User Routes -----------------

Route::get('users/logout','UsersController@logout');

Route::get('users/{method?}','UsersController@getMethods');
Route::post('users/{method?}','UsersController@postMethods');









