<?php

namespace Modules\Base\Classes;

use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Base\Entities\DataMigrated;

class Migration
{


    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //Data Modules
    public static function checkKeyExist($table, $field, $type = 'foreign')
    {
        $keys = DB::select(DB::raw("SHOW KEYS from $table"));
        $key_name =  $table . $field . $type;

        foreach ($keys as $item) {
            if ($item->Key_name == $key_name) {
                return true;
            }
        }

        return false;
    }
}
