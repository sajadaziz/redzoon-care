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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['register'=>true ]);
/*Route::middleware(['auth'])->group(function () {
    Route::get('/approval', 'HomeController@approval')->name('approval');
  Route::middleware(['approved'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
  });
});*/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('admin/home','HomeController@index')->name('admin.home')->middleware('is_admin');
Route::get('/New-book','RecieptBooksController@create')->name('Rt2registerbook');
Route::get('/donation','HomeController@donation')->name('Rt3donar');
Route::get('/user','HomeController@userRegistraton')->name('Rt4userRegistration');
Route::get('/Dispose/RecieptBook','RecieptBooksController@disposeRecieptbook')->name('disposeRecieptBook');
//recipet book
Route::post('/AddNewRecieptBook','RecieptBooksController@AddNewRecieptBook')->name('Rt5Save');
Route::get('/Assign','RecieptBooksController@VassignRbooks')->name('RtVassignRbooks');
Route::get('/getDonees/{id}','RecieptBooksController@getDonees');
Route::get('users-list', 'RecieptBooksController@DoneesList');
Route::post('/Assign/Recipt/Book','RecieptBooksController@addAsignRbooks')->name('Rtsave-assign-book');
Route::get('/view-detail/{AssignmentID}','RecieptBooksController@ShowReceiptBookAssignmentDetail');
Route::get('/RecieveRBook/{AssignmentID}','RecieptBooksController@RecieveRBook');
Route::get('/CloseRBook/{AssignmentID}','RecieptBooksController@CloseRBook');
Route::get('/Download/{AssignmnetID}','RecieptBooksController@generateReceiptBookPDF')->name('pdf');
Route::get('/Download/Disposed/Recieptbooks','RecieptBooksController@disposedRecieptbookPDF')->name('dispRbPdf');
//donar
Route::get('Donar','DonarController@index')->name('RtDonar');
Route::get('/Add/Donee','DonarController@Vb_Donee')->name('Rt6getDonee');
Route::post('/Save/Donee','DonarController@saveDonee')->name('Rt7AddDonee');
Route::get('/getDoneesByBookNo/{bookNo}','DonarController@getDoneesByBookNo');
Route::post('/acceptDonation','DonarController@SaveDonation')->name('acceptDonation');
Route::get('/CancelBookLeaf/{donerID}','DonarController@cancelBookLeaf');
//App Settings
Route::get('/FyIntialisation','fyintialController@index')->name('setFyIntialisation');
Route::get('/fiscalyear','fyintialController@fyintialisation')->name('savefyintialisation');
Route::get('/close/Fy','fyintialController@closeAndArchiveFY')->name('closeandArchive');
Route::get('/AppSetting','sapp\appSettingController@index')->name('AppSetting');
Route::post('/addoptions','sapp\appSettingController@addoptions')->name('addoptions');
Route::get('/getOption/{type}','sapp\appSettingController@getOption');
Route::post('/uploadlogo','sapp\appSettingController@uploadlogo')->name('upload');
Route::post('/save/Registration','sapp\appSettingController@saveEstbRegistration')->name('appRegistration');
Route::get('/checkRegistration','sapp\appSettingController@checkRegistration');
Route::post('/save/Bank-Account-Details','sapp\appSettingController@savebankaccounts')->name('savebankaccount');
//Dash board links
Route::get('/Assigned Reciept Books','DashBoard\ReportController@dbrecieptbook')->name('showAssignedrecieptbooks');
Route::get('user-list','DashBoard\ReportController@Dlist');
Route::get('Establishment/Donars','DashBoard\ReportController@AllEstbDonars')->name('estbDonars');
Route::get('Establishment/Collections','DashBoard\ReportController@AllEstbCollection')->name('estbCollection');
Route::get('Establishment/donars/{estbbook}','DashBoard\ReportController@DonarsOfEstablishment')->name('estbbook');
Route::get('/DownloadFyReport/{establishment}','DashBoard\ReportController@DownloadFyEstbCollectionPDF')->name('downloadPDFestb');
Route::get('Bank/Account/list','DashBoard\ReportController@viewAllBankAccounts')->name('getBankList');
Route::get('Bank/Account/Detail/{acid}','DashBoard\ReportController@ViewAccountDetailByAcid')->name('accountDetail');
Route::get('/Download/Account/Detail/{acid}','DashBoard\ReportController@downloadAccountDetailByAcid')->name('downloadAccountDetail');
//Archive's
Route::get('fyarchive/{fyid}/{fystart}/{fyend}','DashBoard\ReportController@fyarchives')->name('fy.archived');
//Banking
Route::get('/Bank/','Banking\BankController@index')->name('bankledger');
Route::get('/getAllBankData/{acid}','Banking\BankController@getAllBankData');
Route::post('/Save/Transaction','Banking\BankController@AddBankTrnx')->name('AddBankTrnx');