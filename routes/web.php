<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\AnalysisController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/group/create', [GroupController::class, 'create']);
Route::get('/forum/create', [ForumController::class, 'create']);


Route::apiResource('/wall', PublicationController::class);

Route::apiResource('/group', GroupController::class);
Route::apiResource('/forum', ForumController::class);
Route::apiResource('/friend', FriendController::class);
Route::apiResource('/beneficiary', BeneficiaryController::class);
Route::apiResource('/analysis', AnalysisController::class);
//Rutas de enlaces 



//Route::get('/investigation_groups', [App\Http\Controllers\GroupController::class, 'index'])->name('investigation_groups');
//
//Route::get('/friends', [App\Http\Controllers\FriendController::class, 'index'])->name('friends');
//Route::get('/beneficiaries', [App\Http\Controllers\BeneficiaryController::class, 'index'])->name('beneficiaries');
//Route::get('/analysis', [App\Http\Controllers\AnalysisController::class, 'index'])->name('analysis');
