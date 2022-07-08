<?php

namespace Modules\Base\Classes;

use Illuminate\Support\Str;

class Modularize
{
    public $module;
    public $model;
    public $menus = [];
    public $layouts = [];

    function __construct($module = '', $model = '')
    {
        $this->module = $module;
        $this->model = $model;
    }

    public function getAllRecords($args)
    {
        $classname = $this->getClassName($this->module, $this->model);

        if ($classname) {
            if (method_exists($classname, 'getAllRecords')) {
                $result = $classname->getAllRecords($args);
            }
        } else {
            $result['message'] = 'No Model Found with name ' . $this->module . '-' . $this->model;
        }

        return $result;
    }


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Fetching Routes
    public function fetchRoutes()
    {
        $fetchroutes = new FetchRoutes();

        return $fetchroutes->fetchRoutes();
    }
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Discover Modules
    public function discoverModules()
    {
        $discover_modules = new DiscoverModules();

        return $discover_modules->discoverModules();
    }
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Fetching Menu
    public function fetchMenus()
    {
        $fetchmenus = new FetchMenus();

        return $fetchmenus->fetchMenus();
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //General Classes
    private function getClassName()
    {
        $classname = 'Modules\\' . ucfirst($this->module) . '\Entities\\' . ucfirst(Str::camel($this->model));

        return (class_exists($classname)) ? new $classname() : false;
    }
}
