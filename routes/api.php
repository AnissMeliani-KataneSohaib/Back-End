<?php

use App\Http\Controllers\Api\MedcinController;
use App\Http\Controllers\Api\ReceptionnisteController;
use App\Http\Controllers\Api\ModerateurController;
use App\Http\Controllers\Api\DepartementController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientConntroller;
use App\Http\Controllers\CondidatConntroller;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StripePaymentController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});


Route::get('/medcins' , [MedcinController::class , 'index']);
Route::post('add/medcins' , [MedcinController::class , 'store']);
Route::get('/medcins/show/{id}' , [MedcinController::class , 'show']);
Route::get('/medcins/search/{departement_id}', [MedcinController::class, 'search']);
Route::put('/medcins/{id}' , [MedcinController::class , 'update']);
Route::delete('/medcins/{id}' , [MedcinController::class , 'destroy']);

Route::get('receptionnistes' , [ReceptionnisteController::class , 'index']);
Route::get('receptionnistes/show/{id}' , [ReceptionnisteController::class , 'show']);
Route::put('receptionnistes/{id}' , [ReceptionnisteController::class , 'update']);
Route::delete('receptionnistes/{id}' , [ReceptionnisteController::class , 'destroy']);

Route::get('moderateurs' , [ModerateurController::class , 'index']);
Route::get('moderateurs/show/{id}' , [ModerateurController::class , 'show']);
Route::put('moderateurs/{id}' , [ModerateurController::class , 'update']);
Route::delete('moderateurs/{id}' , [ModerateurController::class , 'destroy']);

Route::get('departements' , [DepartementController::class , 'index']);
Route::get('departements/show/{id}' , [DepartementController::class , 'show']);
Route::post('add/departements' , [DepartementController::class , 'store']);
Route::put('departements/{id}' , [DepartementController::class , 'update']);
Route::delete('departements/{id}' , [DepartementController::class , 'destroy']);


Route::get('reservations' , [ReservationController::class , 'index']);
Route::post('add/reservations' , [ReservationController::class , 'store']);


Route::resource( 'patients',PatientConntroller::class );

Route::resource( 'Condidats', CondidatConntroller::class );
Route::get('Condidats/cv/{cvPath}', [CondidatConntroller::class, 'showCv']);

Route::resource( 'message', MessageController::class );

Route::post('payment/create',[StripePaymentController::class,'createPayment']);





