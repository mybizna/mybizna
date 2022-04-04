<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllRecords(Request $request, $module, $model)
    {
        // logic to get all students goes here
        $camel = camel_case('foo_bar');

        print_r($module);
        exit;
    }

    public function createRecord(Request $request, $module, $model)
    {
        // logic to create a student record goes here
        print_r('$module');
        exit;
    }

    public function getRecord($module, $model, $id)
    {
        // logic to get a student record goes here
    }

    public function updateRecord(Request $request, $module, $model, $id)
    {
        // logic to update a student record goes here
    }

    public function deleteRecord($module, $model, $id)
    {
        // logic to delete a student record goes here
    }


    public function functionCall(Request $request, $module, $model, $function)
    {
        // logic to update a student record goes here
    }
}
