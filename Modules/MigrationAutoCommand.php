<?php

namespace Bastinald\LaravelAutomaticMigrations\Commands;

use Illuminate\Console\Command;
use Doctrine\DBAL\Schema\Comparator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class MigrateAutoCommand extends Command
{
    protected $signature = 'migrate:auto {--f|--fresh} {--s|--seed} {--force}';

    public function handle()
    {
        if (app()->environment('production') && !$this->option('force')) {
            $this->warn('Use the <info>--force</info> to migrate in production.');

            return;
        }

        $this->handleTraditionalMigrations();
        $this->handleAutomaticMigrations();
        $this->seed();

        $this->info('Automatic migration completed successfully.');
    }

    private function handleTraditionalMigrations()
    {
        $command = 'migrate';

        if ($this->option('fresh')) {
            $command .= ':fresh';
        }

        if ($this->option('force')) {
            $command .= ' --force';
        }

        Artisan::call($command, [], $this->getOutput());
    }

    private function handleAutomaticMigrations()
    {
        $path = app_path('Models');
        $namespace = app()->getNamespace();
        $models = collect();

        $paths = array();

        if (!is_dir($path)) {
            return;
        }

        $modules_path = realpath(base_path()) . DIRECTORY_SEPARATOR . 'Modules';

        array_push($paths, $modules_path);

        $dir = new \DirectoryIterator($modules_path);

        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $module_name = $fileinfo->getFilename();
                $module_path = $modules_path . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . 'Entities';
                var_dump($module_path);
                array_push($module_path);
            }
        }

        exit;

        foreach ($paths as $key => $path) {

            foreach ((new Finder)->in($path) as $model) {

                $model = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($model->getRealPath(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                );

                if (method_exists($model, 'migration')) {

                    $models->push([
                        'object' => $object = app($model),
                        'order' => $object->migrationOrder ?? 0,
                    ]);
                }
            }
        }



        foreach ($models->sortBy('order') as $model) {
            $this->migrate($model['object']);
        }
    }

    private function migrate($model)
    {
        $modelTable = $model->getTable();
        $tempTable = 'table_' . $modelTable;

        Schema::dropIfExists($tempTable);
        Schema::create($tempTable, function (Blueprint $table) use ($model) {
            $model->migration($table);
        });

        if (Schema::hasTable($modelTable)) {
            $schemaManager = $model->getConnection()->getDoctrineSchemaManager();
            $modelTableDetails = $schemaManager->listTableDetails($modelTable);
            $tempTableDetails = $schemaManager->listTableDetails($tempTable);
            $tableDiff = (new Comparator)->diffTable($modelTableDetails, $tempTableDetails);

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

    private function seed()
    {
        if (!$this->option('seed')) {
            return;
        }

        $command = 'db:seed';

        if ($this->option('force')) {
            $command .= ' --force';
        }

        Artisan::call($command, [], $this->getOutput());
    }
}
