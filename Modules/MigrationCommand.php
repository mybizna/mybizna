<?php

namespace Legodion\Lucid\Commands;

use Doctrine\DBAL\Schema\Comparator;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class MigrateCommand extends Command
{
    protected $signature = 'lucid:migrate {--f|--fresh} {--s|--seed}';

    public function handle()
    {
        $this->call($this->option('fresh') ? 'migrate:fresh' : 'migrate', [
            '--force' => true,
        ]);

        $this->migrateModels();

        if ($this->option('seed')) {
            $this->call('db:seed', [
                '--force' => true,
            ]);
        }
    }

    public function migrateModels()
    {
        $path = is_dir(app_path('Models')) ? app_path('Models') : app_path();
        $namespace = app()->getNamespace();
        $models = collect();

        $paths = array();

        array_push($paths, ['namespace' => $namespace  . 'Models', 'file' => $path]);

        $modules_path = realpath(base_path()) . DIRECTORY_SEPARATOR . 'Modules';

        if (is_dir($modules_path)) {

            $dir = new \DirectoryIterator($modules_path);

            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                    $module_name = $fileinfo->getFilename();
                    $module_path = $modules_path . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . 'Entities';
                    array_push($paths, ['namespace' => 'Modules\\'  . $module_name . '\\Entities', 'file' => $module_path]);
                }
            }

        }



        foreach ($paths as $key => $path) {

            foreach ((new Finder)->in($path['file'])->files() as $model) {

                $real_path_arr = array_reverse(explode(DIRECTORY_SEPARATOR, $model->getRealPath()));

                $model = $path['namespace'] . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    '\\' . $real_path_arr[0]
                );

                if (is_subclass_of($model, Model::class) && method_exists($model, 'migration')) {
                    $models->push([
                        'object' => $object = app($model),
                        'order' => $object->migrationOrder ?? 0,
                    ]);
                }


            }
        }

        foreach ($models->sortBy('order') as $model) {
            $this->migrateModel($model['object']);
        }
    }

    public function migrateModel(Model $model)
    {
        $modelTable = $model->getTable();
        $tempTable = 'table_' . $modelTable;

        Schema::dropIfExists($tempTable);

        Schema::create($tempTable, function (Blueprint $table) use ($model) {
            $model->migration($table);
        });

        if (Schema::hasTable($modelTable)) {
            $schemaManager = $model->getConnection()->getDoctrineSchemaManager();

            $tableDiff = (new Comparator)->diffTable(
                $schemaManager->listTableDetails($modelTable),
                $schemaManager->listTableDetails($tempTable)
            );

            if ($tableDiff) {
                $schemaManager->alterTable($tableDiff);

                $this->line('<info>Table updated:</info> ' . $modelTable);
            }

            Schema::drop($tempTable);
        } else {
            Schema::rename($tempTable, $modelTable);

            $this->line('<info>Table created:</info> ' . $modelTable);
        }
    }
}
