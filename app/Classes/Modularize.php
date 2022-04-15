<?php

namespace App\Classes;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


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

        $routes = [];

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
                        $routes_arr = json_decode(file_get_contents($routes_file), true);
                        $this->routes = $routes_arr;
                    }
                }
            }
        }


        $this->routes = array_merge($this->routes, $routes);

        return ['routes' => $this->routes, 'layouts' => $this->layouts];
    }

    public function getModuleRoute($module_name, $routes)
    {

        $DS = DIRECTORY_SEPARATOR;

        $module_path = realpath(base_path()) . $DS . 'Modules' . $DS . $module_name;

        $m_folder_path =  $module_name;
        $module_route = $this->addRouteToList('/' . $module_name, $m_folder_path, 'router_view');

        foreach (['admin', 'web'] as $folder) {

            $vue_folders = $module_path . $DS  . 'views' . $DS . $folder;

            $f_folder_path =  $m_folder_path . '/' . $folder;
            $folder_route = $this->addRouteToList($folder, $f_folder_path, 'router_view');


            if (is_dir($vue_folders)) {

                $dir = new \DirectoryIterator($vue_folders);

                foreach ($dir as $fileinfo) {


                    if (!$fileinfo->isDot() && $fileinfo->isDir()) {

                        $vs_foldername = $fileinfo->getFilename();
                        $vs_folders = $vue_folders  . $DS . $vs_foldername;
                        $v_folder_path =  $f_folder_path . '/' . $vs_foldername;

                        $vs_route = $this->addRouteToList($vs_foldername, $v_folder_path, 'router_view');

                        if (is_dir($vs_folders)) {

                            $vs_dir = new \DirectoryIterator($vs_folders);

                            foreach ($vs_dir as $vs_fileinfo) {


                                if (!$vs_fileinfo->isDot() && !$vs_fileinfo->isDir()) {

                                    $vs_filename = $vs_fileinfo->getFilename();
                                    $vs_sx_filename = str_replace('.vue', '', $vs_filename);
                                    $vs_path = $module_name . '/' . $folder . '/' . $vs_foldername  . '/'  . $vs_sx_filename;

                                    $t_folder_path =  $v_folder_path . '/' . $vs_sx_filename;

                                    $vs_route['children'][] = $this->addRouteToList($vs_sx_filename, $t_folder_path, $vs_path . '.vue');

                                    if (!in_array($vs_filename, ['create.vue', 'edit.vue', 'modify.vue', 'new.vue', 'update.vue'])) {
                                        $this->layouts[$module_name][$folder][$vs_foldername][] = $vs_filename;
                                    }
                                }
                            }
                        }

                        if (!empty($vs_route['children'])) {
                            $folder_route['children'][] = $vs_route;
                        }
                    }
                }
            }

            if (!empty($folder_route['children'])) {
                $module_route['children'][] = $folder_route;
            }
        }



        if (!empty($module_route['children'])) {
            $routes[] = $module_route;
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
    //Discover Modules
    public function discoverModules()
    {

        $DS = DIRECTORY_SEPARATOR;


        $modules_path = realpath(base_path()) . $DS . 'Modules';

        if (is_dir($modules_path)) {

            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {

                    $module_name = $fileinfo->getFilename();

                    $module_folder = $modules_path . $DS . $module_name . $DS . 'views';
                    $public_folder = realpath(base_path()) . $DS . 'public' . $DS . 'assets' . $DS . Str::lower($module_name);

                    if (!File::exists($public_folder)) {
                        //File::makeDirectory($public_folder);
                        symlink($module_folder, $public_folder);
                    }
                }
            }
        }
        $comp_folder =realpath(base_path()) . $DS . 'resources'. $DS . 'js'. $DS . 'components';
        $comp_public_folder = realpath(base_path()) . $DS . 'public' . $DS . 'assets' . $DS . 'components';


        if (!File::exists($comp_public_folder)) {
            symlink($comp_folder, $comp_public_folder);
        }

        return;
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
                    $menu_file = $modules_path .  $DS . $module_name .  $DS . 'menu.php';
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
