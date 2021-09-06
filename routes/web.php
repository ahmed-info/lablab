<?php

use App\Http\Controllers\CompanyCardController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ViewController;
use App\Models\Company;
use App\Models\CompanyCard;
use Illuminate\Support\Facades\Auth;
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
//     $cards = CompanyCard::paginate();
//     $companies = Company::all();

//     return view('card.index', compact('cards', 'companies'));
// });
Route::post('myauth/check', [ViewController::class, 'check'])->name('myauth.check');
Route::get('/myauth/logout',[ViewController::class, 'logout'])->name('myauth.logout');
Route::get('/test',[ViewController::class, 'test']);
Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('myauth/login', [ViewController::class, 'login'])->name('myauth.login');
    Route::any('/', [ViewController::class,'index']);
    Route::any('/', [ViewController::class,'index'])->name('index');
    Route::get('/', function(){
        if(session('email') =="admin@admin.com"){
            return redirect()->route('log.admin.index');
        }
        if(session('email') =="user@user.com"){
            return redirect()->route('log.user.index');
        }

    });
    Route::any('/logAdminIndex', [ViewController::class,'logAdminIndex'])->name('log.admin.index');
    Route::any('/logUserIndex', [ViewController::class,'logUserIndex'])->name('log.user.index');


    //Route::get('/admin/dashboard', [ViewController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/export/qrcode/update/{id}',[ViewController::class, 'update'])->name('export.qrcode.update');

    //Auth::routes();
    Route::get('/card', [CompanyCardController::class, 'index'])->name('card.index');
    Route::get('/card/select/{company_id}', [CompanyCardController::class, 'select'])->name('card.select');

    Route::get('ViewPages', [ViewController::class,'index']);
    Route::post('ViewPages/{id}', [ViewController::class,'index'])->name('myview');


    Route::post('/card/export', [CompanyCardController::class,'export'])->name('card.export');

    Route::get('/card/upload', [CompanyCardController::class,'upload'])->name('card.upload');
    Route::any('/card/import', [CompanyCardController::class,'import'])->name('card.import');

    Route::any('/search', [ViewController::class,'search'])->name('search');
    Route::any('/getCompany', [CompanyCardController::class, 'import'])->name('getCompany');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/qrcode', [QrController::class,'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
Auth::routes();

