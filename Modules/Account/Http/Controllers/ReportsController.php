<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\Transactions;
use Modules\Account\Classes\Taxes;
use Modules\Account\Classes\Reports;
use Modules\Account\Classes\TaxAgencies;

use Illuminate\Support\Facades\DB;
use Modules\Account\Classes\Reports\TrialBalance;

class ReportsController extends Controller
{

    /**
     * Get trial balance
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrialBalance(Request $request)
    {
        $trial_bal = new TrialBalance();

        $args = [
            'start_date' => !empty($request['start_date']) ? $request['start_date'] : null,
            'end_date'   => !empty($request['end_date']) ? $request['end_date'] : null,
        ];

        $data =  $trial_bal->getTrialBalance($args);

        return response()->json($data);
    }

    /**
     * Chart status
     */
    public function getSalesChartStatus(Request $request)
    {

        $trans = new Transactions();

        $args = [
            'start_date' => empty($request['start_date']) ? '' : $request['start_date'],
            'end_date'   => empty($request['end_date']) ? date('Y-m-d') : $request['end_date'],
        ];

        $chart_status = $trans->getSalesChartStatus($args);

        return response()->json($chart_status);
    }

    /**
     * Chart payment
     */
    public function getSalesChartPayment(Request $request)
    {
        $trans = new Transactions();

        $args = [
            'start_date' => empty($request['start_date']) ? '' : $request['start_date'],
            'end_date'   => empty($request['end_date']) ? date('Y-m-d') : $request['end_date'],
        ];

        $chart_payment = $trans->getSalesChartPayment($args);

        return response()->json($chart_payment);
    }

    /**
     * Get ledger report
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getLedgerReport(Request $request)
    {
        $report = new Reports();

        $ledger_id  = (int) $request['ledger_id'];
        $start_date = empty($request['start_date']) ? date('Y-m-d') : $request['start_date'];
        $end_date   = empty($request['end_date']) ? date('Y-m-d') : $request['end_date'];

        $data = $report->getLedgerReport($ledger_id, $start_date, $end_date);

        return response()->json($data);
    }

    /**
     * Retrieves sales tax reports
     *
     * @since 1.10.0
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesTaxReport(Request $request)
    {
        $report = new Reports();

        $args = [
            'start_date'  => !empty($request['start_date'])  ? $request['start_date']  : null,
            'end_date'    => !empty($request['end_date'])    ? $request['end_date']    : null,
            'customer_id' => !empty($request['customer_id']) ? $request['customer_id'] : null,
            'category_id' => !empty($request['category_id']) ? $request['category_id'] : null,
            'agency_id'   => !empty($request['agency_id'])   ? $request['agency_id']   : null,
        ];

        if (!empty($args['agency_id'])) {
            $data = $report->getSalesTaxReport($args['agency_id'], $args['start_date'], $args['end_date']);
        } else {
            $data = $report->getFilteredSalesTaxReport($args);
        }

        return response()->json($data);
    }

    /**
     * Get income statement report
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomeStatement(Request $request)
    {
        $report = new Reports();

        $start_date = $request['start_date'];
        $end_date   = $request['end_date'];
        $args       = [
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ];

        $data = $report->getIncomeStatement($args);

        return response()->json($data);
    }

    /**
     * Get balance sheet report
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getBalanceSheet(Request $request)
    {
        $report = new Reports();

        $start_date = $request['start_date'];
        $end_date   = $request['end_date'];
        $args       = [
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ];

        $data = $report->getBalanceSheet($args);

        return response()->json($data);
    }

    /**
     * Get closest financial year
     *
     * @param \Illuminate\Http\Request $request request object
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function getClosestFnYear(Request $request)
    {
        $trialbal = new TrialBalance();

        $data = $trialbal->getClosestFnYearDate(date('Y-m-d'));

        return response()->json($data);
    }

    /**
     * Prepare a single user output for response
     *
     * @param object|array    $item
     * @param \Illuminate\Http\Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return \Illuminate\Http\Response $response response data
     */
    public function prepareItemForResponse($item, $request, $additional_fields = [])
    {
        $data = array_merge($item, $additional_fields);

        return response()->json($data);
    }
}
