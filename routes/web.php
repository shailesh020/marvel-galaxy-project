<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CampaigningController;
use App\Http\Controllers\ClientGroupController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();
Route::get('/logout',[LoginController::class,'logout'])->name('cst_logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('clients', UserController::class);
    Route::resource('engineers', UserController::class);
    Route::resource('machine', MachineController::class);
    Route::resource('purchase', PurchaseHistoryController::class);
    Route::resource('campaigning', CampaigningController::class);
    Route::resource('client-group', ClientGroupController::class);
    Route::resource('notification', NotificationController::class);
    Route::resource('complaint', ComplaintController::class);
    Route::resource('location', HomeController::class);
});
