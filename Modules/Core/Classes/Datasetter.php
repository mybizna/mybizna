<?php

namespace Modules\Core\Classes;

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
                                        'data_folder' => $data_folder,
                                        'object' => $object = app($model),
                                        'order' => $object->ordering ?? 0,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            foreach ($models->sortBy('order') as $model) {

                $this->output('Model: ' . $model['data_folder'],true);
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

        array_multisort($data);
        $json_data = json_encode($data);
        $hash = md5($json_data);

        $this->output($json_data);

        $data_migrated = DataMigrated::where($data_to_migrate)
            ->whereNotNull('item_id')->first();


        if ($data_migrated && $data_migrated->item_id) {
            if ($hash <> $data_migrated->hash) {
                $saved_record = $class_name::find($data_migrated->item_id);

                if (!$saved_record->is_modified) {
                    $saved_record->fill($data);
                    $saved_record->save();
                }

                $data_migrated->hash = $hash;
                $data_migrated->counter = $data_migrated->counter + 1;
                $data_migrated->save();
            }
        } else {
            $data = $class_name::create($data);

            $data_to_migrate['item_id'] = $data->id;
            $data_to_migrate['hash'] = $hash;

            DataMigrated::create($data_to_migrate);
        }
    }
    private function output($string, $with_space = false)
    {
        if ($with_space) {
            print('' . "\n");
            print('' . "\n");
            print('-----------------------------------' . "\n");
            print($string . "\n");
            print('' . "\n");
        } else {
            print($string . "\n");
        }
    }
    private function getClassName($module, $model)
    {
        $classname = 'Modules\\' . ucfirst($module) . '\Entities\\' . ucfirst(Str::camel($model));

        return (class_exists($classname)) ? new $classname() : false;
    }
}
