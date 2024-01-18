<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\QrcodeController;
use App\Http\Controllers\Api\AuthController;
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

Route::get('/employees',[EmployeeController::class, "getAllEmployees"]);
Route::post('/create-employee',[EmployeeController::class, "createEmployee"]);
Route::get('/employee/{id}',[EmployeeController::class, "getEmployeeById"]);
Route::put('/employee/update/{id}',[EmployeeController::class, "updateEmployee"]);
Route::delete('/employee/delete/{id}',[EmployeeController::class, "deleteEmployee"]);

Route::get('/qrcodes',[QrcodeController::class, "getAllQrcodes"]);
Route::post('/create-qrcode',[QrcodeController::class, "createQrcode"]);
Route::get('/qrcode/{id}',[QrcodeController::class, "getQrcodeById"]);
Route::put('/qrcode/update/{id}',[QrcodeController::class, "updateQrcode"]);
Route::delete('/qrcode/delete/{id}',[QrcodeController::class, "deleteQrcode"]);

// Stations routes
// Route::get('/get-all-stations',[StationController::class, "getAllStations"]);
// Route::post('/create-station',[StationController::class, "createStation"]);
// Route::get('/station/{id}',[StationController::class, "getStationById"]);
// Route::put('/station/update/{id}',[StationController::class, "updateStation"]);
// Route::delete('/station/delete/{id}',[StationController::class, "deleteStation"]);

// Companies routes
 });




