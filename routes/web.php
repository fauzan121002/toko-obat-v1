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
// Route::group(['middleware'=>'kasirAuth'],function(){
Route::get('/','DashboardController@login')->name('formlogin');
Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');
Route::get('/kasir','CashierController@index');
Route::get('/obat','DashboardController@obat');
Route::get('/jenisobat','DashboardController@jenisObat');
Route::get('/kategoriobat','DashboardController@kategoriObat');
Route::get('/alatkesehatan','DashboardController@alatKesehatan');
Route::get('/pelanggan','DashboardController@pelanggan');
Route::get('/suplemen','DashboardController@suplemen');
Route::get('/supplier','DashboardController@supplier');
Route::put('/ubahpengumuman','FeatureController@ubahpengumuman');
Route::get('/customstruk','DashboardController@customstruk');
Route::get('/riwayattransaksi',function(App\transaksi $transaksi){
    // dd($transaksi->all());
    return view('feature.riwayattransaksi',['transaksi'=>$transaksi->select('kode_transaksi','nama_pesanan','jumlah_pesanan','uang_diterima','nama_kasir')->paginate(5)]);
});

Route::post('/transaksi/{id}/{barang}','DashboardController@transaksi');
Route::post('/cart','DashboardController@cart');
// });
Route::get('/riwayatpengiriman','DashboardController@riwayatpengiriman');
Route::delete('/hapusriwayatpengiriman/{id}','FeatureController@hapusriwayatpengiriman');

Route::prefix('/kasir')->group(function(){
	Route::get('/detailkasir','DashboardController@getModalDataKasir');
	Route::post('/tambahdatakasir','CashierController@store');
	Route::put('/{id}','CashierController@update');
	Route::delete('/{id}','CashierController@destroy');
});

Route::prefix('/kategoriobat')->group(function(){
	Route::get('/detailkategoriobat','DashboardController@getModalKategoriObat');
	Route::post('/tambahkategoriobat','FeatureController@tambahkategoriobat');
	Route::delete('/{id}','FeatureController@hapuskategoriobat');
	Route::put('/{id}','FeatureController@ubahkategoriobat');
});

Route::prefix('/jenisobat')->group(function(){
	Route::get('/detailjenisobat','DashboardController@getModalJenisObat');
	Route::post('/tambahjenisobat','FeatureController@tambahjenisobat');
	Route::delete('/{id}','FeatureController@hapusjenisobat');
	Route::put('/{id}','FeatureController@ubahjenisobat');
});

Route::prefix('/obat')->group(function(){
	Route::get('/detailobat','DashboardController@getModalObat');
	Route::post('/tambahobat','FeatureController@tambahobat');
	Route::delete('/{id}','FeatureController@hapusobat');
	Route::put('/{id}','FeatureController@ubahobat');

	Route::get('/detailtambahstokobat','DashboardController@getModalStokObat');
	Route::put('/tambahstokobat/{id}','FeatureController@tambahstokobat');
	Route::get('/detailtransaksi','DashboardController@getModalTransaksiObat');
});

Route::prefix('/supplier')->group(function(){
	Route::get('/detailsupplier','DashboardController@getModalSupplier');
	Route::post('/tambahsupplier','FeatureController@tambahsupplier');
	Route::delete('/{id}','FeatureController@hapussupplier');
	Route::put('/{id}','FeatureController@ubahsupplier');
});

Route::prefix('/alatkesehatan')->group(function(){
	Route::get('/detailalatkesehatan','DashboardController@getModalAlatKesehatan');
	Route::post('/tambahalatkesehatan','FeatureController@tambahalatkesehatan');
	Route::delete('/{id}','FeatureController@hapusalatkesehatan');
	Route::put('/{id}','FeatureController@ubahalatkesehatan');

	Route::get('/detailtambahstokalatkesehatan','DashboardController@getModalStokAlatKesehatan');
	Route::put('/tambahstokalatkesehatan/{id}','FeatureController@tambahstokalatkesehatan');	
	Route::get('/detailtransaksi','DashboardController@getModalTransaksiAlatKesehatan');
});

Route::prefix('/suplemen')->group(function(){
	Route::get('/detailsuplemen','DashboardController@getModalSuplemen');
	Route::post('/tambahsuplemen','FeatureController@tambahsuplemen');
	Route::delete('/{id}','FeatureController@hapussuplemen');
	Route::put('/{id}','FeatureController@ubahsuplemen');

	Route::get('/detailtambahstoksuplemen','DashboardController@getModalStokSuplemen');
	Route::put('/tambahstoksuplemen/{id}','FeatureController@tambahstoksuplemen');		
	Route::get('/detailtransaksi','DashboardController@getModalTransaksiSuplemen');
});

Route::prefix('/laporan')->group(function(){
    Route::get('/kasir','PDFController@laporan_kasir')->name('laporan.kasir');
    Route::get('/kategori','PDFController@laporan_kategori')->name('laporan.kategori');
    Route::get('/jenis','PDFController@laporan_jenis')->name('laporan.jenis');
    Route::get('/obat','PDFController@laporan_obat')->name('laporan.obat');
    Route::get('/alat-kesehatan','PDFController@laporan_alatkesehatan')->name('laporan.alat-kesehatan');
    Route::get('/suplemen','PDFController@laporan_suplemen')->name('laporan.suplemen');
    Route::get('/supplier','PDFController@laporan_supplier')->name('laporan.supplier');
});

Route::post('/login','AuthController@login');
Route::post('/logout','AuthController@logout');

