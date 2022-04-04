<?php

namespace App\Classes;

use Illuminate\Support\Str;

class Modularize
{
    public $module;
    public $model;

    function __construct($module, $model)
    {
        $this->module = $module;
        $this->model = $model;
    }
    public function getAllRecords($args)
    {
        $result = [
            'module'  => $this->module,
            'model'   => $this->model,
            'status'  => 0,
            'total'   => 0,
            'error'   => 1,
            'data'    => [],
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

        $classname = $this->getClassName($this->module, $this->model);

        if ($classname) {
            if (method_exists($classname, 'getAllRecords')) {
                $classname->getAllRecords($params);
            } else {

                $query = $classname::select('*')
                    ->limit($params['limit']);

                ($params['order'] == 'DESC') ? $query->orderByDesc($params['order']) : $query->orderBy($params['order']);

                foreach ($params['s'] as $field => $s) {
                    if (is_array($s)) {
                        $query->where($field, $s['ope'], $s['str']);
                    } else {

                        $query->where($field, $s);
                    }
                }
                if ($params['count']) {
                    $request['total'] = $query->count();
                }

                $result['error'] = 0;
                $result['status'] = 1;
                $result['data'] = $query->get();
                $result['message'] = 'Records Found Successfully.';
            }
        } else {
            $result['message'] = 'No Model Found with name ' . $this->module . '-' . $this->model;
        }

        return $result;
    }
    private function getClassName()
    {
        $classname = 'Modules\\' . ucfirst($this->module) . '\Entities\\' . ucfirst(Str::camel($this->model));

        return (class_exists($classname)) ? new $classname() : false;
    }
}
