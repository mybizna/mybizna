<?php

namespace Modules\Partner\Entities\Data;

use Modules\Core\Classes\Datasetter;
use Illuminate\Support\Facades\DB;

class Partner
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $partner = DB::table('partner')->first();

        if (!$partner) {
            $user = DB::table('users')->first();

            $name_arr = explode(' ', $user->name);

            $first_name = $name_arr[0] ?? 'John';
            $last_name = $name_arr[1] ?? 'Doe';

            $datasetter->add_data('partner', 'partner', 'user_id', [
                "user_id" => $user->id,
                "email" => $user->email,
                "first_name" => $first_name,
                "last_name" => $last_name,
            ]);
        }
    }
}
