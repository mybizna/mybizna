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

//register new user
Route::post('/register', [AuthenticationController::class, 'register']);

//login user
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['prefix' => 'api'], function () {
    Route::get('discover_modules',  'BaseController@discoverModules');
    Route::get('fetch_menus', 'BaseController@fetchMenus');
    Route::get('fetch_routes', 'BaseController@fetchRoutes');


    Route::middleware('auth:sanctum')->group(function () {
        $prefix = '{module}/admin/{model}';
        $apicontroller = 'BaseController';

        Route::get('current_user',  $apicontroller . '@currentUser');
        Route::get('dashboard_data',  $apicontroller . '@dashboardData');


        Route::get('api/current_user', $apicontroller . '@currentUser');
        Route::get('api/dashboard_data', $apicontroller . '@dashboardData');

        Route::get($prefix, $apicontroller . '@getAllRecords');
        Route::get($prefix . '/{id}', $apicontroller . '@getRecord');
        Route::get($prefix . '/recordselect', $apicontroller . '@getRecordSelect');
        Route::post($prefix, $apicontroller . '@createRecord');
        Route::put($prefix . '/{id}', $apicontroller . '@updateRecord');
        Route::delete($prefix . '/{id}', $apicontroller . '@deleteRecord');
        Route::match(['get', 'post'], $prefix . '/{function}/',  $apicontroller . '@functionCall');
    });
});
