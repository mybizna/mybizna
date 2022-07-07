<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

$apicontroller = 'Modules\Core\Http\Controllers\BaseController';

Route::get('discover_modules', $apicontroller . '@discoverModules');
Route::get('fetch_menus', $apicontroller . '@fetchMenus');
Route::get('fetch_routes', $apicontroller . '@fetchRoutes');
Route::get('current_user', $apicontroller . '@currentUser');
Route::get('dashboard_data', $apicontroller . '@dashboardData');

Route::group(['middleware' => ['auth:sanctum']], function () {

    $apicontroller = 'Modules\Core\Http\Controllers\BaseController';

    Route::get('{module}/admin/{model}', $apicontroller . '@getAllRecords');
    Route::get('{module}/admin/{model}/{id}', $apicontroller . '@getRecord');
    Route::get('{module}/admin/{model}/recordselect', $apicontroller . '@getRecordSelect');
    Route::post('{module}/admin/{model}', $apicontroller . '@createRecord');
    Route::put('{module}/admin/{model}/{id}', $apicontroller . '@updateRecord');
    Route::delete('{module}/admin/{model}/{id}', $apicontroller . '@deleteRecord');
    Route::match(['get', 'post'], '{module}/admin/{model}/{function}/',  $apicontroller . '@functionCall');

    $DS = DIRECTORY_SEPARATOR;
    $modules_path = realpath(base_path()) . $DS . 'Modules';
    print_r($modules_path); exit;

    if (is_dir($modules_path)) {
        $dir = new \DirectoryIterator($modules_path);

        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                $module_name = $fileinfo->getFilename();
                $camel_module_name = ucfirst(Str::camel($module_name));
                $snake_module_name = Str::lower(Str::snake($module_name));

                $entities_path = $modules_path . $DS . $module_name . $DS . 'Entities';

                if (is_dir($entities_path)) {
                    $dir = new \DirectoryIterator($entities_path);

                    foreach ($dir as $fileinfo) {
                        if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                            $entity_name = $fileinfo->getFilename();
                            $entity_name_arr = explode('.', $entity_name);
                            $camel_entity_name = ucfirst(Str::camel($entity_name_arr[0]));
                            $snake_entity_name = Str::lower(Str::snake($entity_name_arr[0]));

                            $controller_path = realpath(base_path().'Modules/' . $camel_module_name . '/Http/Controllers/' . $camel_entity_name . 'Controller.php');
                            $controller = 'Modules\\' . $camel_module_name . '\Http\Controllers\\' . $camel_entity_name . 'Controller';
                            $prefix = $snake_module_name . '/admin//' . $snake_entity_name;

                            print_r($controller_path); exit;

                            if (file_exists($controller_path)) {
                                Route::get($prefix, $controller . '@getAllRecords');
                                Route::get($prefix . '/{id}', $controller . '@getRecord');
                                Route::get($prefix . '/recordselect', $controller . '@getRecordSelect');
                                Route::post($prefix, $controller . '@createRecord');
                                Route::put($prefix . '/{id}', $controller . '@updateRecord');
                                Route::delete($prefix . '/{id}', $controller . '@deleteRecord');
                                Route::match(['get', 'post'], $prefix . '/{function}//',  $controller . '@functionCall');
                            }
                        }
                    }
                }
            }
        }
    }
});

//register new user
Route::post('/register', [AuthenticationController::class, 'register']);

//login user
Route::post('/login', [AuthenticationController::class, 'login']);

//using middleware
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
