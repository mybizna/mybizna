<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\DB;

use Modules\Account\Classes\Reports\TrialBalance;

class ClosingBalanceController extends Controller
{

    /**
     * Close balancesheet
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function closeBalancesheet(Request $request)
    {
        if (empty($request['start_date'])) {
            messageBag()->add('rest_invalid_date', __('Start date missing.'), ['status' => 404]);
            return;
        }

        if (empty($request['end_date'])) {
            messageBag()->add('rest_invalid_date', __('End date missing.'), ['status' => 404]);
            return;
        }

        $args = [
            'f_year_id'  => (int) $request['f_year_id'],
            'start_date' => $request['start_date'],
            'end_date'   => $request['end_date'],
        ];

        $data     = $cbalance->closeBalanceSheetNow($args);
        return response()->json($data);
    }

    /**
     * Get next financial year
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getNextFnYear(Request $request)
    {
        if (empty($request['date'])) {
            messageBag()->add('rest_invalid_date', __('Invalid resource date.'), ['status' => 404]);
            return;
        }

        $data     = $cbalance->getClosestNextFnYear($request['date']);
        return response()->json($data);
    }

    /**
     * Get current financial year
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function getClosestFnYear(Request $request)
    {
        $trialbal = new TrialBalance();

        $data     = $trialbal->getClosestFnYearDate(date('Y-m-d'));
        return response()->json($data);
    }
}
