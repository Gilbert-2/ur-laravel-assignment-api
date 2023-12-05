<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\IndividualController;

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
Route::get('/employees',[EmployeeController::class, "getAllEmployees"]);
Route::post('/create-employee',[EmployeeController::class, "createEmployee"]);
Route::get('/employee/{id}',[EmployeeController::class, "getEmployeeById"]);
Route::put('/employee/update/{id}',[EmployeeController::class, "updateEmployee"]);
Route::delete('/employee/delete/{id}',[EmployeeController::class, "deleteEmployee"]);

Route::get('/individuals',[IndividualController::class, "getAllIndividuals"]);
Route::post('/create-individual',[IndividualController::class, "createIndividual"]);
Route::get('/individual/{id}',[IndividualController::class, "getIndividualById"]);
Route::put('/individual/update/{id}',[IndividualController::class, "updateIndividual"]);
Route::delete('/individual/delete/{id}',[IndividualController::class, "deleteIndividual"]);
