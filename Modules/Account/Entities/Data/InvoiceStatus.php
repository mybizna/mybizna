<?php

namespace Modules\Account\Entities\Data;

use Modules\Core\Classes\Datasetter;

class InvoiceStatus
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('account', 'invoice_status', 'slug', [
            "type_name" => "Draft",
            "slug" => "draft"
        ]);
        $datasetter->add_data('account', 'invoice_status', 'slug', [
            "type_name" => "Pending",
            "slug" => "pending"
        ]);
        $datasetter->add_data('account', 'invoice_status', 'slug', [
            "type_name" => "Paid",
            "slug" => "paid"
        ]);
        $datasetter->add_data('account', 'invoice_status', 'slug', [
            "type_name" => "Partial",
            "slug" => "partial"
        ]);
        $datasetter->add_data('account', 'invoice_status', 'slug', [
            "type_name" => "Closed",
            "slug" => "closed"
        ]);
        $datasetter->add_data('account', 'invoice_status', 'slug', [
            "type_name" => "Void",
            "slug" => "void"
        ]);
    }
}
