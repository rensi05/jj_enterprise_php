<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@index')->name('login');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/savelogin', 'LoginController@saveLogin')->name('savelogin');

Route::get('importdata', 'ArticleController@index')->name('importdata');
Route::post('articlesimport', 'ArticleController@import')->name('articlesimport');

Route::group(['middleware' => ['auth']], function () {
        
    Route::match(['get', 'post'], '/logout', 'LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardConroller@index')->name('dashboard');    

    //Update profile
    Route::get('/profile', 'Profilecontroller@index')->name('profile');
    Route::post('/updateprofile', 'Profilecontroller@updateprofile')->name('updateprofile');
    
    //Change Password
    Route::get('/changepassword', 'ChangepasswordController@index')->name('changepassword');
    Route::post('/updatepassword', 'ChangepasswordController@updatepassword')->name('updatepassword');
    
    //Unit
    Route::get('/unit', 'UnitController@index')->name('unit');
    Route::get('/addunit', 'UnitController@addUnit')->name('addunit');
    Route::post('/saveunit', 'UnitController@saveUnit')->name('saveunit');
    Route::get('/getunit', 'UnitController@getUnit')->name('getunit');
    Route::get('/editunit/{id}', 'UnitController@editUnit')->name('editunit');
    Route::Post('/updateunit', 'UnitController@updateUnit')->name('updateunit');
    Route::get('/unitdeletemodal/{id}', 'UnitController@unitDeleteModal')->name('unitdeletemodal');
    Route::post('/deleteunit', 'UnitController@deleteUnit')->name('deleteunit');
    Route::get('/changeunitstatus/{id}', 'UnitController@changeUnitStatus')->name('changeunitstatus');
    Route::post('/updateunitstatus', 'UnitController@updateUnitStatus')->name('updateunitstatus');
    
    //Item
    Route::get('/item', 'ItemController@index')->name('item');
    Route::get('/additem', 'ItemController@addItem')->name('additem');
    Route::post('/saveitem', 'ItemController@saveItem')->name('saveitem');
    Route::get('/getitem', 'ItemController@getItem')->name('getitem');
    Route::get('/edititem/{id}', 'ItemController@editItem')->name('edititem');
    Route::Post('/updateitem', 'ItemController@updateItem')->name('updateitem');
    Route::get('/itemdeletemodal/{id}', 'ItemController@itemDeleteModal')->name('itemdeletemodal');
    Route::post('/deleteitem', 'ItemController@deleteItem')->name('deleteitem');
    Route::get('/changeitemstatus/{id}', 'ItemController@changeItemStatus')->name('changeitemstatus');
    Route::post('/updateitemstatus', 'ItemController@updateItemStatus')->name('updateitemstatus');
    
    //Order
    Route::get('/order', 'OrderController@index')->name('order');
    Route::get('/addorder', 'OrderController@addOrder')->name('addorder');
    Route::post('/saveorder', 'OrderController@saveOrder')->name('saveorder');
    Route::get('/getorder', 'OrderController@getOrder')->name('getorder');
    Route::get('/editorder/{id}', 'OrderController@editOrder')->name('editorder');
    Route::Post('/updateorder', 'OrderController@updateOrder')->name('updateorder');
    Route::get('/orderdeletemodal/{id}', 'OrderController@orderDeleteModal')->name('orderdeletemodal');
    Route::post('/deleteorder', 'OrderController@deleteOrder')->name('deleteorder');
    Route::get('/changeorderstatus/{id}', 'OrderController@changeOrderStatus')->name('changeorderstatus');
    Route::post('/updateorderstatus', 'OrderController@updateOrderStatus')->name('updateorderstatus');
    
    //Customer
    Route::get('/customer', 'CustomerController@index')->name('customer');
    Route::get('/addcustomer', 'CustomerController@addCustomer')->name('addcustomer');
    Route::post('/savecustomer', 'CustomerController@saveCustomer')->name('savecustomer');
    Route::get('/getcustomer', 'CustomerController@getCustomer')->name('getcustomer');
    Route::get('/editcustomer/{id}', 'CustomerController@editCustomer')->name('editcustomer');
    Route::Post('/updatecustomer', 'CustomerController@updateCustomer')->name('updatecustomer');
    Route::get('/customerdeletemodal/{id}', 'CustomerController@customerDeleteModal')->name('customerdeletemodal');
    Route::post('/deletecustomer', 'CustomerController@deleteCustomer')->name('deletecustomer');
    Route::get('/changecustomerstatus/{id}', 'CustomerController@changeCustomerStatus')->name('changecustomerstatus');
    Route::post('/updatecustomerstatus', 'CustomerController@updateCustomerStatus')->name('updatecustomerstatus');
});
