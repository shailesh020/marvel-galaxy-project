<?php

use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\MachineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\FeedBackController;
use App\Http\Controllers\Api\MachinesConrtoller;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login',[LoginController::class,'login']);
Route::post('otp-verify',[LoginController::class,'otpVerify']);

//admin panel
Route::get('remove-machine-image/{id}', [MachineController::class, 'removeMachineImage'])->name('remove-machine-image');


Route::middleware('auth:sanctum')->group(function(){
    Route::post('edit-profile',[APIController::class,'editProfile']);
    Route::post('my-profile',[APIController::class,'myProfile']);

    Route::get('products',[APIController::class,'products']);
    Route::get('clients',[APIController::class,'clients']);

    // Clients
    Route::post('book-service',[ServicesController::class,'store']);
    Route::get('pending-service',[ServicesController::class,'pendingService']);
    Route::get('allocate-service',[ServicesController::class,'allocateService']);
    Route::get('active-service',[ServicesController::class,'activeService']);
    Route::post('service/{services_id}/complete',[ServicesController::class,'completeService']);
    Route::get('complete-service',[ServicesController::class,'completeServiceList']);
    Route::get('client/{client_id}/machine',[APIController::class,'clientMachine']);

    Route::post('otp-verify',[ServicesController::class,'OTPVerify']);
    Route::get('machin-list',[MachinesConrtoller::class,'machinList']);
    Route::post('machin-details',[MachinesConrtoller::class,'machineDetails']);
    Route::post('machin-edit',[MachinesConrtoller::class,'machinEdit']);
    //feed back 
    Route::post('feed-back',[FeedBackController::class,'feedBack']);
});
