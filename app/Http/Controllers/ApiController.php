<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Classes\Modularize;
use Illuminate\Support\Facades\Auth;


use function Safe\file_get_contents;

class ApiController extends Controller
{
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

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

    public function fetchVue(Request $request, $module, $side, $model, $name)
    {

        $DS = DIRECTORY_SEPARATOR;

        $contents = '';

        $vue_path = realpath(base_path()) . $DS . 'Modules' . $DS  . ucfirst($module) . $DS . 'views' . $DS . $side . $DS . $model  . $DS . $name . '.vue';

        if (file_exists($vue_path)) {
            $contents = file_get_contents($vue_path);
        }

        $response = Response::make($contents, 200);

        $response->header('Content-Type', 'application/javascript');

        return $response;
    }


    public function fetchVueWidgets(Request $request, $module, $name)
    {

        $DS = DIRECTORY_SEPARATOR;

        $contents = '';

        $vue_path = realpath(base_path()) . $DS . 'Modules' . $DS  . ucfirst($module) . $DS . 'views' . $DS . 'widgets' . $DS . $name . '.vue';

        if (file_exists($vue_path)) {
            $contents = file_get_contents($vue_path);
        }

        $response = Response::make($contents, 200);

        $response->header('Content-Type', 'application/javascript');

        return $response;
    }


    public function fetchRoutes(Request $request)
    {
        $modularize = new Modularize();

        $result = $modularize->fetchRoutes();

        return Response::json($result);
    }

    public function fetchMenus(Request $request)
    {
        $modularize = new Modularize();

        $result = $modularize->fetchMenus();

        return Response::json($result);
    }

    public function currentUser(Request $request)
    {

        $this->user = Auth::user();

        $user = $request->user();

        print_r($request->user());
        print_r(Auth::user());
        print_r(auth()->user());

        exit;

        return Response::json($user);
    }
}
