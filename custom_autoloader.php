<?php
// custom_autoloader.php

spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'Modules')) {
        $class_arr = explode('\\', $class);
        
        if ($class_arr[1] != 'Partner' && $class_arr[1] != 'Base' && $class_arr[1] != 'Core') {
            
            $paths = glob( '../../*/Modules/' . $class_arr[1]);
         
            if (!empty($paths)) {

                unset($class_arr[0]);
                unset($class_arr[1]);

                include $paths[0] . '/' . implode('/', $class_arr) . '.php';
            }

        }
    }
});
