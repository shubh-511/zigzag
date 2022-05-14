<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



//==================== Zig-Zag ==========================


Route::get('assign','ApisController@api_assignDriverUsingLink');

Route::post('signup','ApisController@api_signup');

Route::post('signout','ApisController@api_logout');

Route::post('login','ApisController@api_login');

Route::post('home_page','ApisController@api_home_page');

Route::post('get_category_based_providers','ApisController@api_getProvidersList');

Route::post('verify_otp','ApisController@api_verify_otp');

Route::post('verify_otp_driver','ApisController@api_verify_otpDriver');

Route::post('update_profile','ApisController@api_update_profile');

Route::post('rate_restaurant','ApisController@api_rateRestaurant');

Route::post('view_restaurants','ApisController@api_viewRestraurants');

Route::post('restaurant_detail','ApisController@api_RestaurantDetail');

Route::post('make_fav_restaurant','ApisController@api_makeFavourite_Restaurant');

Route::post('rate_dish','ApisController@api_rateDish');

Route::post('dish_detail','ApisController@api_DishDetail');

Route::post('restaurant_profile_tabs','ApisController@api_Restraurant_detail');

Route::post('contact_admin','ApisController@api_contactAdmin');

Route::post('get_menu_dishes','ApisController@api_getMenuDishes');

Route::post('add_to_cart','ApisController@api_addToCart');

Route::post('add_address','ApisController@api_addAddress');

Route::post('get_all_address','ApisController@api_getUserAddress');

Route::post('edit_address','ApisController@api_editUserAddress');

Route::post('make_default_address','ApisController@api_setDefaultAddress');

Route::post('delete_address','ApisController@api_deleteAddress');

Route::post('countries','ApisController@api_countryList');

Route::post('update_profile_driver','ApisController@api_update_profileDriver');

Route::post('upload_documents','ApisController@api_uploadDocuments');

Route::post('add_card','ApisController@api_saveCard');

Route::post('edit_card','ApisController@api_editCard');

Route::post('delete_card','ApisController@api_deleteCard');

Route::post('saved_card_list','ApisController@api_getSavedCards');

Route::post('updateCart','ApisController@api_updateCart');

Route::post('get_cart_items','ApisController@api_getCartItems');

Route::post('get_dish_customisation','ApisController@api_getDishCustomisation');

Route::get('uploadFile','ApisController@apiTestUpload');//not required

Route::post('get_favourite_providers','ApisController@api_getFavouriteRestaurants');

Route::post('search','ApisController@api_search');

Route::post('delete_previous_cart_items','ApisController@api_getAlertFromDifferentProviders');

Route::post('get_profile','ApisController@api_getProfile');

Route::post('get_user_cart_customise_items','ApisController@api_getCartCustomiseItems');

Route::post('removeFavourite_Restaurant','ApisController@api_removeFavourite_Restaurant');

Route::post('payment','ApisController@api_makePayment');

Route::post('order_history','ApisController@api_orderHistory');

Route::post('assigntodriver','ApisController@AssignToDriver');

Route::post('cancel_order','ApisController@api_cancelOrder');

Route::get('page','ApisController@api_pages');

Route::post('driver_home_page','ApisController@api_driverHomePage');

Route::post('order_history_driver','ApisController@api_driverOrderDeliveredHistory');

//Route::post('order_history_driver','ApisController@api_driverOrderDeliveredHistory');

Route::post('get_curr_latlong_driver','ApisController@api_updateDriverLatlong');

Route::post('accept_order','ApisController@api_acceptOrder');

Route::post('deliver_order','ApisController@api_deliverOrder');

Route::post('out_for_delivery','ApisController@api_outForDelivery');

Route::post('out_for_delivery_orders_list','ApisController@api_ordersOutForDelivery');

Route::post('track_order','ApisController@api_trackOrder');

Route::post('rate_driver','ApisController@api_rateDriver');



