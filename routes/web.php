<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProjectController as UserProject;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProject;

/*s
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

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/removeAvatar', [ProfileController::class, 'removeAvatar'])->name('removeAvatar');
        Route::post('/changeAvatar', [ProfileController::class, 'changeAvatar'])->name('changeAvatar');
        Route::post('/changeProfile', [ProfileController::class, 'changeProfile'])->name('changeProfile');
        Route::post('/changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::group(['prefix' => 'project', 'as' => 'project.'], function () {
            Route::get('/', [UserProject::class, 'index'])->name('index');
            Route::get('/{id}/edit', [UserProject::class, 'edit'])->name('edit')->where('id', '[0-9]+');
            Route::get('/{id}', [UserProject::class, 'show'])->name('show')->where('id', '[0-9]+');
            Route::get('/create', [UserProject::class, 'create'])->name('create');
            Route::post('/', [UserProject::class, 'store'])->name('store');
            Route::patch('/{id}', [UserProject::class, 'update'])->name('update')->where('id', '[0-9]+');
            Route::delete('/{id}', [UserProject::class, 'destroy'])->name('destroy');
            Route::get('/downloadExample', [UserProject::class, 'downloadExample'])->name('downloadExample');
            Route::post('/importExcel', [UserProject::class, 'importExcel'])->name('importExcel');
        });
    });

    Route::group(['middleware' => ['isAdmin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['prefix' => 'project', 'as' => 'project.'], function () {
            Route::get('/', [AdminProject::class, 'index'])->name('index');
            Route::get('/{id}/edit', [AdminProject::class, 'edit'])->name('edit')->where('id', '[0-9]+');
            Route::get('/{id}', [AdminProject::class, 'show'])->name('show')->where('id', '[0-9]+');
            Route::get('/create', [AdminProject::class, 'create'])->name('create');
            Route::post('/', [AdminProject::class, 'store'])->name('store');
            Route::patch('/{id}', [AdminProject::class, 'update'])->name('update')->where('id', '[0-9]+');
            Route::delete('/{id}', [AdminProject::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
            Route::delete('/deleteAllProjects', [AdminProject::class, 'deleteAllProjects'])->name('deleteAllProjects');
            Route::get('/downloadExample', [AdminProject::class, 'downloadExample'])->name('downloadExample');
            Route::post('/importExcel', [AdminProject::class, 'importExcel'])->name('importExcel');
        });
    });
});