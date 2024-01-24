<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\QrcodeController;
use App\Http\Controllers\Api\StationScheduleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']);

Route::post('/login',[AuthController::class,'Login'] );

// Employees routes

//Protected routes-Only authenticated users can have access to protected routes//
Route::group(['middleware' => ['auth:sanctum']], function () {
// Employees routes
Route::get('/employees',[EmployeeController::class, "getAllEmployees"]);
Route::post('/create-employee',[EmployeeController::class, "createEmployee"]);
Route::get('/employee/{id}',[EmployeeController::class, "getEmployeeById"]);
Route::put('/employee/update/{id}',[EmployeeController::class, "updateEmployee"]);
Route::delete('/employee/delete/{id}',[EmployeeController::class, "deleteEmployee"]);
// Qrcodes routes
Route::get('/qrcodes',[QrcodeController::class, "getAllQrcodes"]);
Route::post('/create-qrcode',[QrcodeController::class, "createQrcode"]);
Route::get('/qrcode/{id}',[QrcodeController::class, "getQrcodeById"]);
Route::post('/qrcode/update',[QrcodeController::class, "updateQrcode"]);
Route::delete('/qrcode/delete/{id}',[QrcodeController::class, "deleteQrcode"]);
// Stations schedules routes
Route::get('/station-schedules',[StationScheduleController::class, "getAllStationSchedules"]);
Route::post('/create-station-schedule',[StationScheduleController::class, "createStationSchedule"]);
Route::get('/station-schedule/{id}',[StationScheduleController::class, "getStationScheduleById"]);
Route::post('/station-schedule/update',[StationScheduleController::class, "updateStationSchedule"]);
Route::delete('/station-schedule/delete/{id}',[StationScheduleController::class, "deleteStationSchedule"]);

// Wallets routes
Route::get('/get-all-wallets',[WalletController::class, "getAllWallets"]);
Route::post('/create-wallet',[WalletController::class, "createWallet"]);
Route::get('/wallet/{id}',[WalletController::class, "getWalletById"]);
Route::put('/wallet/update/{id}',[WalletController::class, "updateWallet"]);
Route::delete('/wallet/delete/{id}',[WalletController::class, "deleteWallet"]);

// Companies routes
 });




