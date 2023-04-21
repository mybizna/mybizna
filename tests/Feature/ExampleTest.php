<?php

namespace Tests\Feature;

use Modules\Account\Classes\Invoice;
use Modules\Account\Classes\Ledger;
use Modules\Account\Classes\Payment;
use Modules\Account\Entities\Invoice as DBInvoice;
use Modules\Account\Entities\Journal as DBJournal;
use Modules\Account\Entities\Payment as DBPayment;
use Modules\Partner\Classes\Partner;
use Modules\Partner\Entities\Partner as DBPartner;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_partner()
    {
        $partner = new Partner();

        $tmp_partner = $partner->createPartner(['phone' => '0799999999']);

        print_r($tmp_partner->id);

        return $this->assertTrue(true);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_100_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();
        $ledger = new Ledger();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 100, 'amount' => 100, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 100', $tmp_partner->id, $items, 'draft', 'Invoice 100');

        return $this->assertTrue(true);
    }

    public function test_assert_100_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(100, $account['receivable']);
    }

    public function test_assert_100_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(0, $account['wallet']);
    }

    public function test_assert_100_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(-100, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_make_100_payment()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $payment = new Payment();
        $ledger = new Ledger();

        $payment->makePayment($tmp_partner->id, 'Payment 100', 100, 1);

        return $this->assertTrue(true);
    }

    public function test_assert_100_payment_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_100_payment_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['wallet']);
    }

    public function test_assert_100_payment()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_make_50_payment()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $payment = new Payment();
        $ledger = new Ledger();

        $payment->makePayment($tmp_partner->id, 'Payment 50', 50, 1);

        return $this->assertTrue(true);
    }

    public function test_assert_50_payment_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_50_payment_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(50, $account['wallet']);
    }

    public function test_assert_50_payment()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(50, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_make_200_payment()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $payment = new Payment();

        $payment->makePayment($tmp_partner->id, 'Payment 100', 100, 1);
        $payment->makePayment($tmp_partner->id, 'Payment 100', 100, 1);

        return $this->assertTrue(true);
    }

    public function test_assert_250_payment_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_250_payment_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(250, $account['wallet']);
    }

    public function test_assert_250_payment()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(250, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_150_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 150, 'amount' => 150, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 150', $tmp_partner->id, $items, 'draft', 'Invoice 150');

        return $this->assertTrue(true);
    }

    public function test_assert_150_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_150_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(100, $account['wallet']);
    }

    public function test_assert_150_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(100, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_150_again_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 150, 'amount' => 150, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 150', $tmp_partner->id, $items, 'draft', 'Invoice 150');

        return $this->assertTrue(true);
    }

    public function test_assert_150_again_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(50, $account['receivable']);
    }

    public function test_assert_150_again_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(0, $account['wallet']);
    }

    public function test_assert_150_again_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(-50, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_100_again_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 100, 'amount' => 100, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 100', $tmp_partner->id, $items, 'draft', 'Invoice 100');

        return $this->assertTrue(true);
    }

    public function test_assert_100_again_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(150, $account['receivable']);
    }

    public function test_assert_100_again_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(0, $account['wallet']);
    }

    public function test_assert_100_again_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(-150, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_make_100_more_payment()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $payment = new Payment();

        $payment->makePayment($tmp_partner->id, 'Payment 100', 100, 1);

        return $this->assertTrue(true);
    }

    public function test_assert_100_more_payment_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(50, $account['receivable']);
    }

    public function test_assert_100_more_payment_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['wallet']);
    }

    public function test_assert_100_more_payment()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(-50, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_make_150_more_payment()
    {
        //exit;
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $payment = new Payment();

        $payment->makePayment($tmp_partner->id, 'Payment 150 QQQQQQ', 150, 1);

        return $this->assertTrue(true);
    }

    public function test_assert_150_more_payment_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_150_more_payment_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(100, $account['wallet']);
    }

    public function test_assert_150_more_payment()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(100, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_100_more_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 100, 'amount' => 100, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 100', $tmp_partner->id, $items, 'draft', 'Invoice 100');

        return $this->assertTrue(true);
    }

    public function test_assert_100_more_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_100_more_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['wallet']);
    }

    public function test_assert_100_more_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_make_1000_payment()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $payment = new Payment();

        $payment->makePayment($tmp_partner->id, 'Payment 1000', 1000, 1);

        return $this->assertTrue(true);
    }

    public function test_assert_1000_payment_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_1000_payment_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(1000, $account['wallet']);
    }

    public function test_assert_1000_payment()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);

        return $this->assertEquals(1000, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_100_more1_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 100, 'amount' => 100, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 100', $tmp_partner->id, $items, 'draft', 'Invoice 100');

        return $this->assertTrue(true);
    }

    public function test_assert_100_more1_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_100_more1_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(900, $account['wallet']);
    }

    public function test_assert_100_more1_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(900, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function test_generate_100_more2_invoice()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $invoice = new Invoice();

        $items = array(['title' => 'Invoice Item', 'ledger_id' => 65, 'price' => 100, 'amount' => 100, 'quantity' => 1]);

        $invoice->generateInvoice('Invoice 100', $tmp_partner->id, $items, 'draft', 'Invoice 100');

        return $this->assertTrue(true);
    }

    public function test_assert_100_more2_invoice_receivable()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(0, $account['receivable']);
    }

    public function test_assert_100_more2_invoice_wallet()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(800, $account['wallet']);
    }

    public function test_assert_100_more2_invoice()
    {
        $ledger = new Ledger();
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();
        $account = $ledger->getAccountBalance($tmp_partner->id);
        return $this->assertEquals(800, $account['balance']);
    }

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    public function test_log_output()
    {
        $tmp_partner = DBPartner::where('phone', '0799999999')->first();

        $journals = DBJournal::from('account_journal AS aj')
            ->select('aj.*', 'al.slug AS ledger_slug')
            ->where('partner_id', $tmp_partner->id)
            ->leftJoin('account_ledger AS al', 'al.id', '=', 'aj.ledger_id')
            ->get();

        foreach ($journals as $key => $journal) {
            print_r("\n");
            print_r("$journal->id \t $journal->debit \t $journal->credit \t $journal->ledger_slug \t $journal->title \n");
            print_r("\n");
        }

        return $this->assertTrue(true);
    }

    public function test_delete_partner()
    {
        $partner = new Partner();

        $tmp_partners = DBPartner::where('phone', '0799999999')->get();

        foreach ($tmp_partners as $key => $tmp_partner) {
            DBInvoice::where('partner_id', $tmp_partner->id)->delete();
            DBJournal::where('partner_id', $tmp_partner->id)->delete();
            DBPayment::where('partner_id', $tmp_partner->id)->delete();
            DBPartner::where('id', $tmp_partner->id)->delete();
        }

        return $this->assertTrue(true);

    }
}
