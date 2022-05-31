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

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    $apicontroller = 'App\Http\Controllers\ApiController';

    Route::get('{module}/{model}', $apicontroller . '@getAllRecords');
    Route::get('{module}/{model}/{id}', $apicontroller . '@getRecord');
    Route::post('{module}/{model}', $apicontroller . '@createRecord');
    Route::put('{module}/{model}/{id}', $apicontroller . '@updateRecord');
    Route::delete('{module}/{model}/{id}', $apicontroller . '@deleteRecord');
    Route::match(['get', 'post'], '{module}/{model}/{function}/',  $apicontroller . '@functionCall');
});


Route::middleware('throttle:240,1')->group(
    function () {

        $apicontroller = 'App\Http\Controllers\ApiController';

        Route::get('{module}/{side}/{model}/{name}.vue', $apicontroller . '@fetchVue');
        Route::get('{module}/widgets/{name}.vue', $apicontroller . '@fetchVueWidgets');
    }
);

//using middleware
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
