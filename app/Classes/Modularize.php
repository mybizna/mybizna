<?php

namespace App\Classes;

use Illuminate\Support\Str;

class Modularize
{
    public $module;
    public $model;
    public $menus = [];
    public $layouts = [];
    public $routes = [];

    function __construct($module = '', $model = '')
    {
        $this->module = $module;
        $this->model = $model;
    }
    public function getAllRecords($args)
    {
        $result = [
            'module'  => $this->module,
            'model'   => $this->model,
            'status'  => 0,
            'total'   => 0,
            'error'   => 1,
            'data'    => [],
            'message' => 'No Records'
        ];

        $defaults = [
            'limit'   => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
            'count'   => false,
            's'       => [],

        ];

        $params = array_merge($defaults, $args);

        $classname = $this->getClassName($this->module, $this->model);

        if ($classname) {
            if (method_exists($classname, 'getAllRecords')) {
                $classname->getAllRecords($params);
            } else {

                $query = $classname::select('*')
                    ->limit($params['limit']);

                ($params['order'] == 'DESC') ? $query->orderByDesc($params['order']) : $query->orderBy($params['order']);

                foreach ($params['s'] as $field => $s) {
                    if (is_array($s)) {
                        $query->where($field, $s['ope'], $s['str']);
                    } else {

                        $query->where($field, $s);
                    }
                }
                if ($params['count']) {
                    $request['total'] = $query->count();
                }

                $result['error'] = 0;
                $result['status'] = 1;
                $result['data'] = $query->get();
                $result['message'] = 'Records Found Successfully.';
            }
        } else {
            $result['message'] = 'No Model Found with name ' . $this->module . '-' . $this->model;
        }

        return $result;
    }

    private function getClassName()
    {
        $classname = 'Modules\\' . ucfirst($this->module) . '\Entities\\' . ucfirst(Str::camel($this->model));

        return (class_exists($classname)) ? new $classname() : false;
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Fetching Routes
    public function fetchRoutes()
    {

        $DS = DIRECTORY_SEPARATOR;

        $modules_path = realpath(base_path()) . $DS . 'Modules';

        $routes = [
            'web' => [
                'path' => '/web',
                'name' => 'web',
                'component' => 'router_view',
                'children' => []
            ],
            'admin' => [
                'path' => '/admin',
                'name' => 'admin',
                'component' => 'router_view',
                'children' => []
            ]
        ];

        if (is_dir($modules_path)) {

            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {

                    $module_name = $fileinfo->getFilename();

                    if ($module_name != '') {
                        $routes = $this->getModuleRoute($module_name, $routes);
                    }

                    $routes_file = $modules_path . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . 'routes.json';
                    if (file_exists($routes_file)) {
                        $routes_arr = json_decode(file_get_contents($routes_file));
                        $this->routes[] = $routes_arr;
                    }
                }
            }
        }

        $this->routes = array_merge($this->routes, [$routes['web']], [$routes['admin']]);

        return ['routes' => $this->routes, 'layouts' => $this->layouts];
    }

    public function getModuleRoute($module_name, $routes)
    {

        $DS = DIRECTORY_SEPARATOR;

        $module_path = realpath(base_path()) . $DS . 'Modules' . $DS . $module_name;

        foreach (['admin', 'web'] as $folder) {

            $module_route = $this->addRouteToList($module_name, $folder . '/' . $module_name,  $module_name);

            $vue_folders = $module_path . $DS  . 'views' . $DS . $folder;

            if (is_dir($vue_folders)) {

                $dir = new \DirectoryIterator($vue_folders);

                foreach ($dir as $fileinfo) {


                    if (!$fileinfo->isDot() && $fileinfo->isDir()) {

                        $vs_foldername = $fileinfo->getFilename();
                        $vs_folders = $vue_folders  . $DS . $vs_foldername;
                        $vs_path = $folder . '/' . $module_name . '/' . $vs_foldername;

                        $vs_route = $this->addRouteToList($vs_foldername, $vs_path, $vs_path);

                        if (is_dir($vs_folders)) {

                            $vs_dir = new \DirectoryIterator($vs_folders);

                            foreach ($vs_dir as $vs_fileinfo) {


                                if (!$vs_fileinfo->isDot() && !$vs_fileinfo->isDir()) {

                                    $vs_filename = $vs_fileinfo->getFilename();
                                    $vs_sx = str_replace('.vue', '', $vs_filename);
                                    $vs_path = $folder . '/' . $module_name . '/' . $vs_foldername  . '/'  . $vs_sx;

                                    $vs_route['children'][] = $this->addRouteToList($vs_sx,  'admin/' . $vs_path, $vs_path . '.vue');

                                    if (!in_array($vs_filename, ['create.vue', 'edit.vue', 'modify.vue', 'new.vue', 'update.vue'])) {
                                        $this->layouts[$module_name][$folder][$vs_foldername][] = $vs_filename;
                                    }
                                }
                            }
                        }

                        $module_route['children'][] = $vs_route;
                    }
                }
            }

            $routes[$folder]['children'][] = $module_route;
        }



        return $routes;
    }


    public function addRouteToList($path, $name, $component)
    {

        return [
            'path' => Str::lower($path),
            'name' => ucfirst(Str::camel(str_replace('/', '_', $name))),
            'component' => Str::lower($component)
        ];
    }


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Fetching Menu
    public function fetchMenus()
    {

        $DS = DIRECTORY_SEPARATOR;


        $modules_path = realpath(base_path()) . $DS . 'Modules';

        if (is_dir($modules_path)) {

            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                    $module_name = $fileinfo->getFilename();
                    $menu_file = $modules_path . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . 'menu.php';
                    if (file_exists($menu_file)) {
                        include_once $menu_file;
                    }
                }
            }
        }

        return $this->menus;
    }


    public function add_menu($module, $key, $title, $path, $icon, $position)
    {
        if (!array_key_exists($module, $this->menus)) {
            $this->menus[$module] = [];
        }

        $this->menus[$module][$key] = [
            'title' => $title,
            'path' => $path,
            'position' => $position,
            'icon' => $icon,
            'list' => []
        ];
    }

    public function add_submenu($module, $key, $title, $path, $position)
    {
        if (!array_key_exists($module, $this->menus)) {
            $this->menus[$module] = [];
        }

        if (!array_key_exists($key, $this->menus[$module])) {
            $this->menus[$module][$key] = [];
        }

        $this->menus[$module][$key]['list'][] = [
            'title' => $title,
            'path' => $path,
            'position' => $position,
        ];
    }
}
