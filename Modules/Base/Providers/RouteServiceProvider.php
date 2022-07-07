<?php

namespace Modules\Base\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Base\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $DS = DIRECTORY_SEPARATOR;
        $modules_path = realpath(base_path()) . $DS . 'Modules';

        if (is_dir($modules_path)) {
            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                    $module_name = $fileinfo->getFilename();

                    if (file_exists($modules_path . $DS . $module_name . $DS . 'Routes/web.php')) {
                        Route::middleware('web')
                            ->namespace('Modules\\' . $module_name . '\Http\Controllers')
                            ->group(module_path($module_name, '/Routes/web.php'));
                    }
                }
            }
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $DS = DIRECTORY_SEPARATOR;
        $modules_path = realpath(base_path()) . $DS . 'Modules';

        if (is_dir($modules_path)) {
            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                    $module_name = $fileinfo->getFilename();

                    if (file_exists($modules_path . $DS . $module_name . $DS . 'Routes/api.php')) {
                        Route::prefix('api')
                            ->middleware('api')
                            ->namespace('Modules\\' . $module_name . '\Http\Controllers')
                            ->group(module_path($module_name, '/Routes/api.php'));
                    }
                }
            }
        }

        $this->mapGeneralApiRoutes();
    }

    private function mapGeneralApiRoutes()
    {
        $apicontroller = 'Modules\Base\Http\Controllers\BaseController';

        Route::get('discover_modules', $apicontroller . '@discoverModules');
        Route::get('fetch_menus', $apicontroller . '@fetchMenus');
        Route::get('fetch_routes', $apicontroller . '@fetchRoutes');
        Route::get('current_user', $apicontroller . '@currentUser');
        Route::get('dashboard_data', $apicontroller . '@dashboardData');

        Route::group(['middleware' => ['auth:sanctum']], function () {
            $prefix ='{module}/admin/{model}';
            $apicontroller = 'Modules\Base\Http\Controllers\BaseController';

            Route::get($prefix, $apicontroller . '@getAllRecords');
            Route::get($prefix . '/{id}', $apicontroller . '@getRecord');
            Route::get($prefix . '/recordselect', $apicontroller . '@getRecordSelect');
            Route::post($prefix, $apicontroller . '@createRecord');
            Route::put($prefix . '/{id}', $apicontroller . '@updateRecord');
            Route::delete($prefix . '/{id}', $apicontroller . '@deleteRecord');
            Route::match(['get', 'post'], $prefix . '/{function}/',  $apicontroller . '@functionCall');
        });

        Route::group(['middleware' => ['auth:sanctum']], function () {
            $DS = DIRECTORY_SEPARATOR;
            $modules_path = realpath(base_path()) . $DS . 'Modules';

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
                                if (!$fileinfo->isDir()) {

                                    $entity_name = $fileinfo->getFilename();
                                    $entity_name_arr = explode('.', $entity_name);
                                    $camel_entity_name = ucfirst(Str::camel($entity_name_arr[0]));
                                    $snake_entity_name = Str::lower(Str::snake($entity_name_arr[0]));

                                    $controller_path = realpath(base_path()) . $DS . 'Modules' . $DS . $camel_module_name . $DS . 'Http' . $DS . 'Controllers' . $DS . $camel_entity_name . 'Controller.php';
                                    $controller = 'Modules\\' . $camel_module_name . '\Http\Controllers\\' . $camel_entity_name . 'Controller';
                                    $prefix = $snake_module_name . '/admin/' . $snake_entity_name;

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
    }
}
