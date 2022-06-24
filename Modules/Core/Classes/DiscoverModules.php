<?php

namespace Modules\Core\Classes;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class DiscoverModules
{

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
                        messageBag('modularize_fold_missing_error', __('Folder Missing error.'));

                        //File::makeDirectory($public_folder);
                        if (File::exists($module_folder)) {
                            symlink($module_folder, $public_folder);
                        }
                    }
                }
            }
        }
        $comp_folder = realpath(base_path()) . $DS . 'resources' . $DS . 'js' . $DS . 'components';
        $comp_public_folder = realpath(base_path()) . $DS . 'public' . $DS . 'assets' . $DS . 'components';


        if (!File::exists($comp_public_folder)) {
            symlink($comp_folder, $comp_public_folder);
        }

        return;
    }
}
