<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\GroupRequestController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProfileController;
use App\Models\GroupRequest;
use Illuminate\Support\Facades\Auth;

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

Route::get('/wall', [App\Http\Controllers\PublicationController::class, 'index'])->name('wall');


Route::get('/group/create', [GroupController::class, 'create']);
Route::get('/forum/create', [ForumController::class, 'create']);


Route::apiResource('/wall', PublicationController::class);
Route::post('/wall/publicaciones', 'App\Http\Controllers\PublicationController@store')->name('guardarpublicaciones');
Route::post('/group/save', 'App\Http\Controllers\GroupController@store')->name('guardargrupo');
Route::get('/group/{id}/index','App\Http\Controllers\GroupController@ingroup')->name('auth');
Route::post('/idea/save', 'App\Http\Controllers\GroupController@storeidea')->name('guardaridea');
// Route::post('/group/send-request/{group}', 'GroupController@sendRequest')->name('send.request');
Route::post('/group/send-request/{group_id}', 'App\Http\Controllers\GroupController@sendRequest')->name('send.request');
Route::get('group/{groupId}/requests', 'App\Http\Controllers\GroupRequestController@showRequests')->name('group.requests');
// Route::post('group/{groupId}/accept-request/{requestId}', 'App\Http\Controllers\GroupController@acceptRequest')->name('group.acceptRequest');
Route::post('group/{groupId}/accept-request/{requestId}', 'App\Http\Controllers\GroupController@acceptRequest')->name('group.acceptRequest');
Route::post('group/{groupId}/reject-request/{requestId}', 'App\Http\Controllers\GroupController@rejectRequest')->name('group.rejectRequest');
Route::post('like/toggle/{publication}', 'App\Http\Controllers\LikeController@like')->name('like.toggle');
Route::post('like/{idea}', 'App\Http\Controllers\LikeController@likeIdea')->name('like.idea');
Route::post('like/forum/{exp}', 'App\Http\Controllers\LikeController@likeExp')->name('like.idea.forum');
Route::post('like/information/{inf}', 'App\Http\Controllers\LikeController@likeInf')->name('like.information');
Route::get('/users/{user}/edit', 'App\Http\Controllers\BeneficiaryController@edit')->name('users.edit');
Route::put('/users/{user}', 'App\Http\Controllers\BeneficiaryController@update')->name('users.update');
Route::put('/users/{user}/profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
Route::post('/users/password/{user}', 'App\Http\Controllers\BeneficiaryController@updatePasssword')->name('reset.password');
Route::put('/users/admin/{user}', 'App\Http\Controllers\BeneficiaryController@updateAdmin')->name('users.update.admin');
Route::get('/users/create', 'App\Http\Controllers\BeneficiaryController@create')->name('users.create');
Route::post('/users/store', 'App\Http\Controllers\BeneficiaryController@store')->name('users.store');
Route::post('/forum/save', 'App\Http\Controllers\ForumController@store')->name('guardarforo');
Route::get('/forum/{id}/index','App\Http\Controllers\ForumController@inforum')->name('auth');
Route::post('/idea/forum/save', 'App\Http\Controllers\ForumController@storeideaForum')->name('guardaridea.forum');
Route::post('/comentarios/store', 'App\Http\Controllers\ComentarioController@store')->name('comentarios.store');
Route::post('/comentarios/group/store', 'App\Http\Controllers\ComentarioController@storeGroup')->name('comentarios.group.store');
Route::post('/comentarios/forum/store', 'App\Http\Controllers\ComentarioController@storeForum')->name('comentarios.forum.store');
Route::post('/comentarios/information/store', 'App\Http\Controllers\ComentarioController@storeInfo')->name('comentarios.info.store');

// Ruta para actualizar un comentario
Route::put('/comentarios/{id}', 'App\Http\Controllers\ComentarioController@update')->name('comentarios.update');

// Ruta para eliminar un comentario
Route::delete('/comentarios/{id}', 'App\Http\Controllers\ComentarioController@destroy')->name('comentarios.destroy');

Route::delete('/publicaciones/{id}', 'App\Http\Controllers\PublicationController@destroy')->name('eliminar-publicacion');
Route::delete('/informacion/{id}', 'App\Http\Controllers\InformationController@destroy')->name('eliminar-information');
Route::delete('/ideas/{id}', 'App\Http\Controllers\GroupController@destroyIdea')->name('eliminar-idea');
Route::delete('/experiencias/{id}', 'App\Http\Controllers\ForumController@destroyExp')->name('eliminar-idea-forum');
Route::post('/wall/informacion', 'App\Http\Controllers\InformationController@store')->name('guardarinformacion');





Route::get('/update-emails', 'App\Http\Controllers\BeneficiaryController@updateEmails')->name('updateEmails');

Route::get('/analysis/{analysis}/edit', 'App\Http\Controllers\AnalysisController@edit')->name('analysis.edit');
Route::put('/analysis/{analysis}', 'App\Http\Controllers\AnalysisController@update')->name('analysis.update');
Route::get('/analysis/create', 'App\Http\Controllers\AnalysisController@create')->name('analysis.create');
Route::post('/analysis/store', 'App\Http\Controllers\AnalysisController@store')->name('analysis.store');



Route::apiResource('/group', GroupController::class);
Route::apiResource('/forum', ForumController::class);
Route::apiResource('/friend', FriendController::class);
Route::apiResource('/beneficiary', BeneficiaryController::class);
Route::apiResource('/analysis', AnalysisController::class);
Route::apiResource('/solicitudes', GroupRequestController::class);
Route::apiResource('/informacion', InformationController::class);
Route::apiResource('/profile', ProfileController::class);
//Rutas de enlaces 



//Route::get('/investigation_groups', [App\Http\Controllers\GroupController::class, 'index'])->name('investigation_groups');
//
//Route::get('/friends', [App\Http\Controllers\FriendController::class, 'index'])->name('friends');
//Route::get('/beneficiaries', [App\Http\Controllers\BeneficiaryController::class, 'index'])->name('beneficiaries');
//Route::get('/analysis', [App\Http\Controllers\AnalysisController::class, 'index'])->name('analysis');
