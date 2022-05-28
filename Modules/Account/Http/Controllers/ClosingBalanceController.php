<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Account\Classes\ClosingBalance;

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
        $cbalance = new ClosingBalance();

        $input = $request->all();

        if (empty($input['start_date'])) {
            config('kernel.messageBag')->add('rest_invalid_date', __('Start date missing.'));
            return;
        }

        if (empty($input['end_date'])) {
            config('kernel.messageBag')->add('rest_invalid_date', __('End date missing.'));
            return;
        }

        $args = [
            'f_year_id'  => (int) $input['f_year_id'],
            'start_date' => $input['start_date'],
            'end_date'   => $input['end_date'],
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
        $cbalance = new ClosingBalance();

        $input = $request->all();

        if (empty($input['date'])) {
            config('kernel.messageBag')->add('rest_invalid_date', __('Invalid resource date.'));
            return;
        }

        $data     = $cbalance->getClosestNextFnYear($input['date']);
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
