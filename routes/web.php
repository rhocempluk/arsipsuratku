<?php

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

// Route::get('/', function () {
//     return view('auth/login');
// });

Auth::routes();

Route::get('/home', 'HomeController@userHome')->name('user.home');
//Route::get('admin/home', 'HomeController@index')->name('admin.home')->middleware('role');
Route::get('admin/home', 'Admin\DashboardController@index')->name('admin.home')->middleware('role');
Route::group(['middleware' => 'auth'], function () {
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
   // Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

    Route::resource('user', 'Admin\UserController');
    Route::get('/user', 'Admin\UserController@getUser')->middleware('role');
    //Route::get('user/{name}/cari', 'Admin\UserController@search');

    Route::resource('jenissurat', 'Admin\JenisSuratController');
    Route::get('/jenissurat', 'Admin\JenisSuratController@getsurat')->middleware('role');
    Route::get('/showjenissurat', 'Admin\JenisSuratController@showjenissurat')->name('showjenissurat');

    Route::resource('unitbagian', 'Admin\BagianController');
    Route::get('/viewunitbagian', 'Admin\BagianController@getbagian')->middleware('role');
    Route::get('/showbagian', 'Admin\BagianController@showbagian')->name('showbagian');

    Route::resource('suratmasuk', 'Admin\SuratMasukController');
    Route::get('/viewsuratmasuk', 'Admin\SuratMasukController@getsuratmasuk')->name('viewsuratmasuk');
    Route::get('/tampilsuratmasuk/{id}', 'Admin\SuratMasukController@tampilsuratmasuk');
    Route::post('/simpan', 'Admin\SuratMasukController@simpan');
    Route::post('/ubah/{id}', 'Admin\SuratMasukController@ubah');
    Route::post('ubahstatus/{no_surat}/edit', 'Admin\SuratMasukController@ubahstatus')->name('ubahstatus');

    Route::resource('disposisi', 'Admin\DisposisiController');
    Route::get('/viewdisposisi', 'Admin\DisposisiController@getdisposisi')->name('viewdisposisi');
    Route::post('simpandisposisi', 'Admin\DisposisiController@store')->name('simpandisposisi');
    Route::post('savedisposisi', 'Admin\DisposisiController@simpan')->name('savedisposisi');
    Route::get('/tampildispo/{id}', 'Admin\DisposisiController@suratdispo');
    Route::get('/cetaklembardispo/{id}', 'Admin\DisposisiController@cetakdispo');
    Route::get('/dispo/pdf', 'Admin\DisposisiController@createPDF');
    Route::post('rubahstatus/{no_surat}/edit', 'Admin\DisposisiController@rubahstatus')->name('rubahstatus');
    //Route::get('/jenissurat', 'Admin\JenisSuratController@getsurat')->middleware('role');

    Route::resource('suratkeluar', 'Admin\SuratKeluarController');
    Route::get('/viewsuratkeluar', 'Admin\SuratKeluarController@getsuratkeluar')->name('viewsuratkeluar');
    Route::get('/tampilsuratkeluar/{id}', 'Admin\SuratKeluarController@tampilsuratkeluar');
    Route::post('/simpansuratkeluar', 'Admin\SuratKeluarController@simpansuratkeluar');
    Route::post('/ubahsuratkeluar/{id}', 'Admin\SuratKeluarController@ubahsuratkeluar');

    //Route::get('/showbagian', 'Admin\bagianController@showbagian')->name('showbagian');

    // Route::resource('report', 'Admin\ReportController');
    // Route::post('/report/tampil', 'Admin\ReportController@getreport');
    // Route::get('/getreport/pdf/{id}', 'Admin\ReportController@getPDF');


    Route::resource('reportsuratmasuk', 'Admin\ReportMasukController');
    Route::get('/viewreportsuratmasuk', 'Admin\ReportMasukController@index');
    //Route::resource('reportsuratkeluar', 'Admin\ReportKeluarController');
    //Route::get('/laporansuratmasuk/{bagian}/{tglawal}/{tglakhir}', 'Admin\ReportMasukController@getdata');
    //Route::post('/reportmasuk/pdf?bagian=semua', 'Admin\ReportMasukController@getPDF');
    Route::post('reportmasuk/tampilpdf', 'Admin\ReportMasukController@getreport');

    Route::resource('reportsuratkeluar', 'Admin\ReportKeluarController');
    Route::get('/viewreportsuratkeluar', 'Admin\ReportKeluarController@index');
    Route::post('reportkeluar/tampilpdf', 'Admin\ReportKeluarController@getreport');
});

