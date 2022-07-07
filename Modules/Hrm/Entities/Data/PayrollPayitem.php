<?php

namespace Modules\Hrm\Entities\Data;

use Modules\Base\Classes\Datasetter;

class PayrollPayitem
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {


        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Travel Allowance",
            "slug" => "travel_allowance",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Accomodation Allowance",
            "slug" => "accomodation_allowance",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "City Compensatory Allowance",
            "slug" => "city_compensatory_allowance",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Pay Adjustment",
            "slug" => "pay_adjustment",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "OverTime",
            "slug" => "overtime",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Variable Pay",
            "slug" => "variable_pay",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Bonus",
            "slug" => "bonus",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Holiday Pay",
            "slug" => "holiday_pay",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Allowance",
            "payitem" => "Service Charge",
            "slug" => "service_charge",
            "pay_item_add_or_deduct" => "1"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Deduction",
            "payitem" => "Provident Fund",
            "slug" => "rovident_fund",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Deduction",
            "payitem" => "Loan",
            "slug" => "loan",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Deduction",
            "payitem" => "Advance Pay",
            "slug" => "advance_pay",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Deduction",
            "payitem" => "Advance",
            "slug" => "advance",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Deduction",
            "payitem" => "Miscelleneous Deduction",
            "slug" => "miscelleneous_deduction",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Deduction",
            "payitem" => "Give as you earn",
            "slug" => "give_as_you_earn",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Non-Taxable Payments",
            "payitem" => "Expenses",
            "slug" => "expenses",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Non-Taxable Payments",
            "payitem" => "Redundancy",
            "slug" => "redundancy",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Non-Taxable Payments",
            "payitem" => "Millage",
            "slug" => "millage",
            "pay_item_add_or_deduct" => "0"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Tax",
            "payitem" => "Income Tax",
            "slug" => "income_tax",
            "pay_item_add_or_deduct" => "2"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Tax",
            "payitem" => "Fedaral Tax",
            "slug" => "fedaral_tax",
            "pay_item_add_or_deduct" => "2"
        ]);
        $datasetter->add_data('hrm', 'payroll_payitem', 'payitem', [
            "type" => "Tax",
            "payitem" => "State Tax",
            "slug" => "state_tax",
            "pay_item_add_or_deduct" => "2"
        ]);
    }
}
