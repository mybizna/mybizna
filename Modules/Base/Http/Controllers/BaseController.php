<?php

namespace App\Http\Controllers;

use Base\Classes\DataMigration;
use App\Repository\Autocomplete;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
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


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataMigration()
    {
        $data_migration = new DataMigration();
        $data_migration->dataMigration();
    }
}
