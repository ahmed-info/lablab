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


Route::get('/', [ViewController::class,'index']);
Route::post('/', [ViewController::class,'index'])->name('index');
Route::post('/export/qrcode/update/{id}',[ViewController::class, 'update'])->name('export.qrcode.update');
Route::get('/test',[ViewController::class, 'test']);

Auth::routes();
Route::get('/card', [CompanyCardController::class, 'index'])->name('card.index');
Route::get('/card/select/{company_id}', [CompanyCardController::class, 'select'])->name('card.select');

Route::get('ViewPages', [ViewController::class,'index']);
Route::post('ViewPages/{id}', [ViewController::class,'index'])->name('myview');


Route::post('/card/export', [CompanyCardController::class,'export'])->name('card.export');

Route::get('/card/upload', [CompanyCardController::class,'upload'])->name('card.upload');
Route::post('/card/import', [CompanyCardController::class,'import'])->name('card.import');

Route::any('/search', [CompanyCardController::class,'search'])->name('search');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/qrcode', [QrController::class,'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
