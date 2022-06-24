<?php

namespace Modules\Core\Classes;

use Illuminate\Support\Str;

class FetchMenus
{

    public $menus = [];

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


    public function add_module_info($module, $data)
    {
        if (!array_key_exists($module, $this->menus)) {
            $this->menus[$module] = ['menus' => []];
        }

        $this->menus[$module] = array_merge($this->menus[$module], $data);
    }

    public function add_menu($module, $key, $title, $path, $icon, $position)
    {
        $this->menus[$module]['menus'][$key] = [
            'title' => $title,
            'path' => $path,
            'position' => $position,
            'icon' => $icon,
            'list' => []
        ];
    }

    public function add_submenu($module, $key, $title, $path, $position)
    {
        $this->menus[$module]['menus'][$key]['list'][] = [
            'title' => $title,
            'path' => $path,
            'position' => $position,
        ];
    }
}
