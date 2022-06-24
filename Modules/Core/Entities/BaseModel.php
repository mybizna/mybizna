<?php

namespace Modules\Core\Entities;

use Illuminate\Support\Str;

class BaseModel extends \Illuminate\Database\Eloquent\Model
{

    /**
     * The table associated with the model. Copies $table in Model
     *
     * @var string
     */
    protected static string $tableName;

    /**
     * Get the table associated with the model. Copies getTable() in Model
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return static::$tableName ?? Str::snake(Str::pluralStudly(class_basename(static::class)));
    }

    /**
     * Get the table associated with the model. Overrides getTable() in Model
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this::getTableName();
    }

    public function getAllRecords($args)
    {
        $result = [
            'module'  => $this->module,
            'model'   => $this->model,
            'status'  => 0,
            'total'   => 0,
            'error'   => 1,
            'records'    => [],
            'message' => 'No Records'
        ];

        $defaults = [
            'limit'   => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
            'count'   => false,
            's'       => [],

        ];

        $params = array_merge($defaults, $args);

        $query = $this->generateQuery($params);

        if ($params['count']) {
            $result['total'] = $query->count();
        }

        $result['error'] = 0;
        $result['status'] = 1;
        $result['records'] = $query->get();
        $result['message'] = 'Records Found Successfully.';

        return $result;
    }


    private function getAlias($table_name, $alias)
    {
        $alias_exist = false;
        $alpha = range('a', 'z');
        $key = $alias->search($table_name);

        if (!$key) {
            $alias->push($table_name);
            $key = $alias->search($table_name);
        } else {
            $alias_exist = true;
        }

        return [$alpha[$key], $alias_exist, $alias];
    }

    public function generateQuery($params)
    {

        $alias = collect(['']);
        $query = $this::query();

        $table_name = $this->table;
        list($main_table_alias, $alias_exist, $alias) = $this->getAlias($table_name, $alias);
        $select = collect([$main_table_alias . '*']);

        if (is_array($params['f'])) {
            $select = collect([]);
            $main_field = '';

            $query->from($table_name . ' as ' . $main_table_alias);

            foreach ($params['f'] as $field => $f) {
                list($table_alias, $alias_exist, $alias) = $this->getAlias($table_name, $alias);

                if (strpos($f, '.')) {
                    $tables_concat = '';
                    $sub_main_field =  $main_field;
                    $pre_leftjoin_alias = $table_alias;

                    $table_levels = explode('.', $f);
                    foreach ($table_levels as $key => $table_level) {
                        $table_parts = explode('__', $table_level);
                        $tables_concat = ($tables_concat == '') ? $sub_main_field . '_' . $table_parts[0] : $tables_concat . '_' .  $sub_main_field . '_' .  $table_parts[0];

                        list($leftjoin_alias, $alias_exist, $alias) = $this->getAlias($tables_concat, $alias);
                        $leftjoin_table = $table_parts[0] . ' as ' . $leftjoin_alias;

                        if (!$alias_exist) {
                            $query->leftJoin($leftjoin_table, $leftjoin_alias . '.id', '=', $pre_leftjoin_alias . '.' . $sub_main_field);
                        }

                        $sub_main_field = $table_parts[1];
                        $pre_leftjoin_alias = $leftjoin_alias;
                    }

                    $select->push($pre_leftjoin_alias . '.' . $sub_main_field . ' as ' . $f);
                } elseif (strpos($f, '__')) {
                    $table_parts = explode('__', $f);

                    list($leftjoin_alias, $alias_exist, $alias) = $this->getAlias($main_field . '_' . $table_parts[0], $alias);
                    $leftjoin_table = $table_parts[0] . ' as ' . $leftjoin_alias;

                    if (!$alias_exist) {
                        $query->leftJoin($leftjoin_table, $leftjoin_alias . '.id', '=', $main_table_alias . '.' . $main_field);
                    }

                    $select->push($leftjoin_alias . '.' . $table_parts[1] . ' as ' . $f);
                } else {
                    $main_field = $f;
                    $select->push($main_table_alias . '.' . $f);
                }
            }
        }

        $query = $query->select($select->all())
            ->limit($params['limit']);

        ($params['order'] == 'DESC') ? $query->orderByDesc($main_table_alias.'.'.$params['orderby']) : $query->orderBy($main_table_alias.'.'.$params['orderby']);

        if (is_array($params['s'])) {
            foreach ($params['s'] as $field => $s) {
                if (is_array($s)) {
                    $query->where($field, $s['ope'], $s['str']);
                } else {
                    $query->where($field, $s);
                }
            }
        }

        return $query;
    }
}
