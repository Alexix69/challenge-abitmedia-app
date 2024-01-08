<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SoftwareController;
use App\Models\OperatingSystem;
use Illuminate\Support\Facades\Route;

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

/*====================================== SERVICES ROUTES ======================================*/

Route::get('/services/servicesList', [ServiceController::class, 'servicesList']);
Route::get('/services/getService/{id}', [ServiceController::class, 'getService']);
Route::post('/services/saveService', [ServiceController::class, 'saveService']);
Route::put('/services/updateService', [ServiceController::class, 'updateService']);
Route::delete('/services/deleteService/{service}', [ServiceController::class, 'deleteService']);

/*================================== SOFTWARE (LICENSES) ROUTES =================================*/

Route::get('/software/licenseList', [SoftwareController::class, 'licenseList']);
Route::get('/software/getLicense/{id}', [SoftwareController::class, 'getLicense']);
Route::post('/software/saveLicense', [SoftwareController::class, 'saveLicense']);
Route::put('/software/updateLicense', [SoftwareController::class, 'updateLicense']);
Route::delete('/software/deleteLicense/{license}', [SoftwareController::class, 'deleteLicense']);

/*======= AUX VIEW O.S. ROUTE =======*/
Route::get('/os', function () {
    return OperatingSystem::all();
});
