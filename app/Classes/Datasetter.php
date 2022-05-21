<?php

namespace App\Classes;

use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Base\Entities\DataMigrated;

class Datasetter
{


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Data Modules
    public function dataProcess()
    {
        $models = collect();

        $DS = DIRECTORY_SEPARATOR;

        $modules_path = realpath(base_path()) . $DS . 'Modules';

        if (is_dir($modules_path)) {
            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                    $module_name = $fileinfo->getFilename();

                    $namespace = 'Modules\\'  . $module_name . '\\Entities\\Data';
                    $data_folder = $modules_path .  $DS . $module_name .  $DS . 'Entities' . $DS . 'Data';

                    if (is_dir($data_folder)) {
                        $data_dir = new \DirectoryIterator($data_folder);

                        foreach ($data_dir as $fileinfo) {
                            if ($fileinfo->isFile()) {
                                $data_name = $fileinfo->getFilename();

                                $model = $namespace  . str_replace(
                                    ['/', '.php'],
                                    ['\\', ''],
                                    '\\' . $data_name
                                );

                                if (method_exists($model, 'data')) {
                                    $models->push([
                                        'object' => $object = app($model),
                                        'order' => $object->ordering ?? 0,
                                    ]);


                                }
                                // include_once $menu_file;
                            }
                        }
                    }
                }
            }

            foreach ($models->sortBy('order') as $model) {
                $model['object']->data($this);
            }
        }
    }

    public function add_data($module, $model, $main_field, $data)
    {
        $data_to_migrate = array(
            'module' => $module,
            'table_name' => $model,
            "array_key" => $data[$main_field],
        );

        $class_name = $this->getClassName($module, $model);

        $data_migrated = DataMigrated::where($data_to_migrate)
            ->whereNotNull('item_id')->first();

        if ($data_migrated && $data_migrated->item_id) {
            $saved_record = $class_name::find($data_migrated->item_id);

            if (!$saved_record->is_modified) {
                $saved_record->fill($data);
                $saved_record->save();
            }

            $data_migrated->counter = $data_migrated->counter + 1;
            $data_migrated->save();

        } else {
            $data = $class_name::create($data);

            $saved_migration = DataMigrated::create($data_to_migrate);

            $saved_migration->fill(['item_id' => $data->id]);
            $saved_migration->save();
        }


    }

    private function getClassName($module, $model)
    {
        $classname = 'Modules\\' . ucfirst($module) . '\Entities\\' . ucfirst(Str::camel($model));

        return (class_exists($classname)) ? new $classname() : false;
    }
}
