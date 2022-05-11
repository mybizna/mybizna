<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;

// Create a new MessageBag instance.
$messageBag = new MessageBag;


function messageBag()
{
    global $messageBag;

    return $messageBag;
    //function logic
}

function apply_filters($str, $object)
{
    return $object;
}

function do_action()
{
}

function wp_list_pluck()
{
}

function get_ledger_id_by_slug($slug)
{
    $result = DB::select("SELECT slug, id, chart_id, category_id, name, code FROM erp_acct_ledgers WHERE slug='{$slug}'");

    if ($result) {
        return $result[0];
    }

    return false;
}
