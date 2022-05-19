<?php

namespace Base\Classes;

use Base\Classes\DataMigration;

class Mybizna
{
    public function dataMigration()
    {
        $data_migration = new DataMigration();
        $data_migration->dataMigration();
    }
}
