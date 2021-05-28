<?php
date_default_timezone_set('Asia/Jakarta');
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

Route::post('/login','AuthController@login');
Route::post('/logout','AuthController@logout');

Route::get('/','DashboardController@login')->name('login');
Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');

Route::prefix('/cashier')->group(function(){
	Route::get('/','CashierController@index')->name('cashier.index');
	Route::get('/detail','CashierController@getModalCashierData')->name('cashier.detail');
	Route::post('/','CashierController@store')->name('cashier.store');
	Route::put('/{id}','CashierController@update')->name('cashier.update');
	Route::delete('/{id}','CashierController@destroy')->name('cashier.destroy');
});

Route::prefix('/drug-category')->group(function(){
	Route::get('/','DrugCategoryController@index')->name('drug-category.index');
	Route::get('/detail','DrugCategoryController@getModalDrugCategory')->name('drug-category.detail');
	Route::post('/','DrugCategoryController@store')->name('drug-category.store');
	Route::put('/{id}','DrugCategoryController@update')->name('drug-category.update');
	Route::delete('/{id}','DrugCategoryController@destroy')->name('drug-category.destroy');
});

Route::prefix('/drug-type')->group(function(){
	Route::get('/','DrugTypeController@index')->name('drug-type.index');
	Route::get('/detail','DrugTypeController@getModalDrugType')->name('drug-type.detail');
	Route::post('/','DrugTypeController@store')->name('drug-type.store');
	Route::put('/{id}','DrugTypeController@update')->name('drug-type.update');
	Route::delete('/{id}','DrugTypeController@destroy')->name('drug-type.destroy');
});

Route::prefix('/drug')->group(function(){
	Route::get('/','DrugController@index')->name('drug.index');
	Route::get('/detail','DrugController@getModalDrug')->name('drug.detail');
	Route::post('/','DrugController@store')->name('drug.store');
	Route::put('/{id}','DrugController@update')->name('drug.update');
	Route::delete('/{id}','DrugController@destroy')->name('drug.destroy');

	Route::get('/stock-detail','DrugController@getModalDrugStock')->name('drug.stock');
	Route::put('/update-stock/{id}','DrugController@updateStock')->name('drug.update-stock');
	Route::get('/transaction-detail','DrugController@getModalDrugTransaction')->name('drug.transaction');
});

Route::prefix('/supplier')->group(function(){
	Route::get('/','SupplierController@index')->name('supplier.index');
	Route::get('/detail','SupplierController@getModalSupplier')->name('supplier.detail');
	Route::post('/','SupplierController@store')->name('supplier.store');
	Route::put('/{id}','SupplierController@update')->name('supplier.update');
	Route::delete('/{id}','SupplierController@destroy')->name('supplier.destroy');
});

Route::prefix('/medical-device')->group(function(){
	Route::get('/','MedicalDeviceController@index')->name('medical-device.index');
	Route::get('/detail','MedicalDeviceController@getModalMedicalDevice')->name('medical-device.detail');
	Route::post('/','MedicalDeviceController@store')->name('medical-device.store');
	Route::put('/{id}','MedicalDeviceController@update')->name('medical-device.update');
	Route::delete('/{id}','MedicalDeviceController@destroy')->name('medical-device.destroy');

	Route::get('/stock-detail','MedicalDeviceController@getModalMedicalDeviceStock')->name('medical-device.stock');
	Route::put('/update-stock/{id}','MedicalDeviceController@updateStock')->name('medical-device.update.stock');
	Route::get('/transaction-detail','MedicalDeviceController@getModalMedicalDeviceTransaction')->name('medical-device.transaction');
});

Route::prefix('/supplement')->group(function(){
	Route::get('/','SupplementController@index')->name('supplement.index');
	Route::get('/detail','SupplementController@getModalSupplement')->name('supplement.detail');
	Route::post('/','SupplementController@store')->name('supplement.store');
	Route::put('/{id}','SupplementController@update')->name('supplement.update');
	Route::delete('/{id}','SupplementController@destroy')->name('supplement.destroy');

	Route::get('/stock-detail','SupplementController@getModalSupplementStock')->name('supplement.stock');
	Route::put('/update-stock/{id}','SupplementController@updateStock')->name('supplement.update.stock');
	Route::get('/transaction-detail','SupplementController@getModalSupplementTransaction')->name('supplement.transaction');
});

Route::put('/notification','NotificationController@update')->name('notification.update');

Route::prefix('/transaction')->group(function(){
	Route::get('/','TransactionController@index')->name('transaction.index');
	Route::post('/{id}/{item}','TransactionController@store')->name('transaction.store');
});

Route::prefix('/shipping-history')->group(function(){
	Route::get('/','ShippingController@index')->name('shipping-history.index');
	Route::delete('/{id}','ShippingController@destroy')->name('shipping-history.destroy');
});

Route::prefix('/report')->group(function(){
    Route::get('/cashier','ReportController@CashierReport')->name('report.cashier');
    Route::get('/drug-category','ReportController@DrugCategoryReport')->name('report.drug-category');
    Route::get('/drug-type','ReportController@DrugTypeReport')->name('report.drug-type');
    Route::get('/drug','ReportController@DrugReport')->name('report.drug');
    Route::get('/medical-device','ReportController@MedicalDeviceReport')->name('report.medical-device');
    Route::get('/supplement','ReportController@SupplementReport')->name('report.supplement');
    Route::get('/supplier','ReportController@SupplierReport')->name('report.supplier');
});
