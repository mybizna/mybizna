<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Modules\Core\Classes\Modularize;
use Modules\Core\Classes\Datasetter;
use Modules\Base\Classes\Autocomplete;

class BaseController extends Controller
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

    public function discoverModules(Request $request)
    {
        $modularize = new Modularize();

        $result = $modularize->discoverModules();

        return Response::json($result);
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

        return Response::json($user);
    }

    public function dashboardData(Request $request)
    {

        $result = [
            [
                'is_amount' => false,
                'title' => "Purchase",
                'icon' => "fas fa-chart-line",
                'color' => "primary",
                'total' => DB::table('purchase')->count(),
            ],
            [
                'is_amount' => false,
                'title' => "Partner",
                'icon' => "fas fa-users",
                'color' => "success",
                'total' => DB::table('partner')->count()
            ],
            [
                'is_amount' => false,
                'title' => "Product",
                'icon' => "fas fa-store",
                'color' => "warning",
                'total' => DB::table('product')->count()
            ],
            [
                'is_amount' => true,
                'title' => "Sales",
                'icon' => "fas fa-sack-dollar",
                'color' => "info",
                'total' => DB::table('sale')->count()
            ],
        ];

        return Response::json($result);
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('search');
        $table_name = $request->get('table_name');
        $display_fields = $request->get('display_fields');
        $search_fields = $request->get('search_fields');

        $autocomplete = new Autocomplete();

        $records = $autocomplete->dataResult($search, $table_name, $display_fields, $search_fields);

        return $records;
    }
}
