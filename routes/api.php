<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$apicontroller = 'App\Http\Controllers\ApiController';


Route::get('{module}/{model}', $apicontroller . '@getAllRecords');
Route::get('{module}/{model}/{id}', $apicontroller . '@getRecord');
Route::post('{module}/{model}', $apicontroller . '@createRecord');
Route::put('{module}/{model}/{id}', $apicontroller . '@updateRecord');
Route::delete('{module}/{model}/{id}', $apicontroller . '@deleteRecord');
Route::match(['get', 'post'], '{module}/{model}/{function}/',  $apicontroller . '@functionCall');


Route::get('{module}/{side}/{model}/{name}.vue', $apicontroller . '@fetchVue');
Route::get('fetch_menus', $apicontroller . '@fetchMenus');
