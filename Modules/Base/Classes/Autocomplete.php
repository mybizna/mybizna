<?php

namespace Module\Base\Classes;

use DB;

class Autocomplete
{

    public function dataResult($search, $table_name, $display_fields, $search_fields, $leftjoin_criteria = '')
    {

        $query = DB::table($table_name . ' as amm');
        $query->select($display_fields);
        $query->whereRaw($search_fields);

        if (!empty($leftjoin_criteria)) {
            foreach ($leftjoin_criteria as $key => $leftjoin) {
                $query->leftJoin($leftjoin->table_name, $leftjoin->condition1, $leftjoin->operator, $leftjoin->condition2);
            }
        }
        $records = $query->get();

        return $records;

    }

}
