<?php

namespace Base\Classes;

use Modules\System\Entities\DataMigrated;

class DataMigration
{
    public function dataMigration()
    {
        $module_path = base_path() . '/Modules/';

        if (is_dir($module_path)) {
            $this->migrateModuleFolder($module_path);
        }
    }

    public function migrateModuleFolder($module_path)
    {
        $modules = scandir($module_path);

        foreach ($modules as $module) {
            if ($module != '.' && $module != '..') {
                $data_folder = $module_path . $module . '/data/';

                if (is_dir($data_folder)) {
                    $this->migrateDataFolder($module, $data_folder);
                }
            }
        }
    }

    public function migrateDataFolder($module, $data_folder)
    {

        $data_files = scandir($data_folder);
        foreach ($data_files as $data_file) {
            if ($data_file != '.' && $data_file != '..') {
                $data_file_path = $data_folder . $data_file;
                $this->migrateData($module, $data_file_path, $data_file);
            }
        }
    }

    public function migrateData($module, $data_file_path, $data_file)
    {

        $data_set = json_decode(file_get_contents($data_file_path), true);

        $data_file_arr = explode('.', $data_file);
        $table_name = $data_file_arr[0];

        $class_name = $this->getClassName($data_file);

        foreach ($data_set as $key => $single_data) {

            $data_to_migrate = array(
                'module' => $module,
                'table_name' => $table_name,
                'array_key' => $key,
            );

            $data_migrated = DataMigrated::where($data_to_migrate)->first();

            if (empty($data_migrated)) {

                $saved_migration = DataMigrated::create($data_to_migrate);

                $data = $class_name::create($single_data);

                $saved_migration->fill(['item_id' => $data->id]);
                $saved_migration->save();
            } else {
                if ($data_migrated->item_id) {

                    $saved_record = $class_name::find($data_migrated->item_id);

                    $saved_update = $saved_record->updated_at->toDateTimeString();
                    $saved_update_add = date('Y-m-d H:i:s', strtotime($saved_update . ' +1 second'));
                    $saved_update_minus = date('Y-m-d H:i:s', strtotime($saved_update . ' -1 second'));

                    $migrated_update = $data_migrated->updated_at->toDateTimeString();
                    $migrated_update_add = date('Y-m-d H:i:s', strtotime($migrated_update . ' +1 second'));
                    $migrated_update_minus = date('Y-m-d H:i:s', strtotime($migrated_update . ' -1 second'));

                    if (
                        $saved_update == $migrated_update ||
                        $saved_update == $migrated_update_add ||
                        $saved_update == $migrated_update_minus ||
                        $saved_update_add == $migrated_update ||
                        $saved_update_add == $migrated_update_add ||
                        $saved_update_add == $migrated_update_minus ||
                        $saved_update_minus == $migrated_update ||
                        $saved_update_minus == $migrated_update_add ||
                        $saved_update_minus == $migrated_update_minus
                    ) {
                        $saved_record->fill($single_data);
                        $saved_record->save();
                    }
                } else {
                    $saved_migration = DataMigrated::create($data_to_migrate);

                    $data = $class_name::create($single_data);

                    $saved_migration->fill(['item_id' => $data->id]);
                    $saved_migration->save();
                }

                $data_migrated->counter = $data_migrated->counter + 1;
                $data_migrated->save();
            }
        }
    }

    public function getClassName($data_file)
    {

        $data_file_arr = explode('_', str_replace('.json', '', $data_file));

        $data_file_arr = array_map('ucwords', $data_file_arr);

        $class_name = 'Modules\\' . $data_file_arr[0] . '\\Entities\\' . $data_file_arr[1];

        return $class_name;
    }
}
