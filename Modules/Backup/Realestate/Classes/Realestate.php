<?php

namespace Modules\Realestate\Classes;

use Illuminate\Support\Facades\DB;


use Modules\Account\Classes\Invoices;

class Realestate
{
    public function generateUnits($unit)
    {

        foreach (range(1, $unit['total']) as $item) {
            # code...

            $house_name = $unit['prefix'] . $item + 1;

            $unit = DB::table('realestate_unit')->where("title", $house_name)->first();

            $setups = DB::table('realestate_building_unit_setup')->where("building_id.id", "=", $unit['id'])->get();


            if ($unit) {
                $res_id = DB::table('mybizna.realestate.unit')->insertGetId(
                    [
                        'title' => $house_name,
                        'building_id' => $unit['id'],
                        'currency_id' => $unit['currency_id'],
                        'amount' => $unit['amount'],
                        'type' => $unit['type'],
                        'deposit' => $unit['deposit'],
                        'goodwill' => $unit['goodwill'],
                        'rooms' => $unit['rooms'],
                        'bathrooms' => $unit['bathrooms'],
                    ]
                );
                foreach ($setups as $setup) {
                    # code...
                    DB::table('mybizna.realestate.unit_setup')->insert([
                        'title' => $setup->title,
                        'unit_id' => $res_id,
                        'currency_id' => $setup->currency_id,
                        'amount' => $setup->amount
                    ]);
                }
            }
        }

        $unit->fill(['has_units' => true]);
        $unit->save();
    }

    public function autoFill($id)
    {


        $currency_id = config('mybizna_mpesa_currency_id');

        DB::table('mybizna.realestate.building_unit_setup')->create(
            [
                'title' => "Garbage Collection",
                'building_id' => $id,
                'currency_id' => $currency_id,
                'amount' => 100
            ]
        );
        DB::table('mybizna.realestate.building_unit_setup')->create(
            [
                'title' => "Internet",
                'building_id' => $id,
                'currency_id' => $currency_id,
                'amount' => 500
            ]
        );

        DB::table('mybizna.realestate.building_unit_setup')->create(
            [
                'title' => "Security",
                'building_id' => $id,
                'currency_id' => $currency_id,
                'amount' => 500
            ]
        );
    }
}
