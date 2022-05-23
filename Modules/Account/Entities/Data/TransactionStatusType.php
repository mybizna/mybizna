<?php

namespace Modules\Account\Entities\Data;

use App\Classes\Datasetter;

class TransactionStatusType
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Asset",
            "slug" => "asset",
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Draft",
            "slug" => "draft"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Awaiting Payment",
            "slug" => "awaiting_payment"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Pending",
            "slug" => "pending"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Paid",
            "slug" => "paid"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Partially Paid",
            "slug" => "partially_paid"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Approved",
            "slug" => "approved"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Closed",
            "slug" => "closed"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Void",
            "slug" => "void"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Returned",
            "slug" => "returned"
        ]);
        $datasetter->add_data('account', 'transaction_status_type', 'slug', [
            "type_name" => "Partially Returned",
            "slug" => "partially_returned"
        ]);
    }
}
