<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthenticationController;

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

$apicontroller = 'App\Http\Controllers\ApiController';


Route::get('discover_modules', $apicontroller . '@discoverModules');
Route::get('fetch_menus', $apicontroller . '@fetchMenus');
Route::get('fetch_routes', $apicontroller . '@fetchRoutes');
Route::get('current_user', $apicontroller . '@currentUser');
Route::get('dashboard_data', $apicontroller . '@dashboardData');


//register new user
Route::post('/register', [AuthenticationController::class, 'register']);

//login user
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    $apicontroller = 'App\Http\Controllers\ApiController';

    Route::get('{module}/admin/{model}', $apicontroller . '@getAllRecords');
    Route::get('{module}/admin/{model}/{id}', $apicontroller . '@getRecord');
    Route::post('{module}/admin/{model}', $apicontroller . '@createRecord');
    Route::put('{module}/admin/{model}/{id}', $apicontroller . '@updateRecord');
    Route::delete('{module}/admin/{model}/{id}', $apicontroller . '@deleteRecord');
    Route::match(['get', 'post'], '{module}/admin/{model}/{function}/',  $apicontroller . '@functionCall');
});

//using middleware
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
