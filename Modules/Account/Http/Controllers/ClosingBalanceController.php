<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Modules\Account\Classes\Reports\TrialBalance;

class ClosingBalanceController extends Controller
{

    /**
     * Close balancesheet
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function close_balancesheet($request)
    {
        if (empty($request['start_date'])) {
            return new WP_Error('rest_invalid_date', __('Start date missing.'), ['status' => 404]);
        }

        if (empty($request['end_date'])) {
            return new WP_Error('rest_invalid_date', __('End date missing.'), ['status' => 404]);
        }

        $args = [
            'f_year_id'  => (int) $request['f_year_id'],
            'start_date' => $request['start_date'],
            'end_date'   => $request['end_date'],
        ];

        $data     = $cbalance->closeBalanceSheetNow($args);
        $response = rest_ensure_response($data);

        $response->set_status(200);

        return $response;
    }

    /**
     * Get next financial year
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_next_fn_year($request)
    {
        if (empty($request['date'])) {
            return new WP_Error('rest_invalid_date', __('Invalid resource date.'), ['status' => 404]);
        }

        $data     = $cbalance->getClosestNextFnYear($request['date']);
        $response = rest_ensure_response($data);

        $response->set_status(200);

        return $response;
    }

    /**
     * Get current financial year
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_closest_fn_year($request)
    {
        $trialbal = new TrialBalance();

        $data     = $trialbal->getClosestFnYearDate(date('Y-m-d'));
        $response = rest_ensure_response($data);

        $response->set_status(200);

        return $response;
    }
}
