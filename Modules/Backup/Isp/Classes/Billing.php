<?php

use Illuminate\Support\Facades\DB;


use Modules\Account\Classes\Invoices;

class Billing
{
    public function generateInvoice($billing)
    {
        $invoices = new Invoices();

        $partner_id = 1;
        $user_id = 1;
        $invoice_line_ids = collect([]);

        $items = DB::table('mybizna.isp.billing_items')->where("billing_id", $billing->id)->get();

        foreach ($items as $item) {
            $invoice_line_ids->push([
                'name' => $item->title,
                'quantity' => 1,
                'price_unit' => $item->amount,
                'price_subtotal' => $item->amount,
                'account_id' => 21
            ]);
        }

        $invoice = $invoices->insertInvoice([
            'move_type' => 'out_invoice',
            'partner_id' => $partner_id,
            'user_id' => $user_id,
            'invoice_line_ids' => $invoice_line_ids
        ]);


        //$invoice.action_post();

        //self.reconcile_invoice(invoice);
    }


    public function processPackages()
    {

        $packages = DB::table('mybizna.isp.packages')->where("published", true)->get();

        foreach ($packages as $package) {
            $db_ext = DB::connection('mysql_ext');

            try {
                $speed = $package->speed . $package->speed_type;
                $double_speed = ($package->speed * 2) . $package->speed_type;

                $microtik_limit = '' . $speed . '/' . $speed . ' ' . $double_speed .  '/' . $double_speed . ' ' . $speed . '/' . $speed . ' 40/40';

                $db_ext->delete("DELETE FROM radgroupcheck WHERE groupname='" .
                    $speed . "' and attribute='Framed-Protocol'");

                $db_ext->delete('insert into radgroupcheck (groupname,attribute,op,value) values ("' .
                    $speed . '","Framed-Protocol","==","PPP");');

                $db_ext->delete("DELETE FROM radgroupreply WHERE groupname='" .
                    $speed . "' and attribute='Framed-Pool'");

                $db_ext->delete('insert into radgroupreply (groupname,attribute,op,value) values ("' .
                    $speed . '","Framed-Pool","=","' . $speed . '_pool");');

                $db_ext->delete("DELETE FROM radgroupreply WHERE groupname='" .
                    $speed . "' and attribute='Mikrotik-Rate-Limit'");

                $db_ext->delete('insert into radgroupreply (groupname,attribute,op,value) values ("' .
                    $speed . '","Mikrotik-Rate-Limit","=","' . $microtik_limit . '");');

                $db_ext->delete("DELETE FROM radusergroup WHERE username='" .
                    $speed . "_Profile' and groupname='" . $speed . "'");

                $db_ext->delete('insert into radusergroup (username,groupname,priority) values ("' .
                    $speed . '_Profile","' . $speed . '",10);');
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
