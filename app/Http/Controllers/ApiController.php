<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Classes\Modularize;

class ApiController extends Controller
{
    // http://127.0.0.1:8000/api/account/journal/?s[name][str]=test&s[name][ope]==&s[keyword]=test
    public function getAllRecords(Request $request, $module, $model)
    {
        $modularize = new Modularize($module, $model);
        // logic to get all records goes here

        $args = $request->query();

        $result = $modularize->getAllRecords($args, $module, $model);

        return Response::json($result);
    }

    public function createRecord(Request $request, $module, $model)
    {
        // logic to create a record record goes here
        print_r('$module');
        exit;
    }

    public function getRecord($module, $model, $id)
    {
        // logic to get a record record goes here
    }

    public function updateRecord(Request $request, $module, $model, $id)
    {
        // logic to update a record record goes here
    }

    public function deleteRecord($module, $model, $id)
    {
        // logic to delete a record record goes here
    }


    public function functionCall(Request $request, $module, $model, $function)
    {
        // logic to update a record record goes here
    }
}
