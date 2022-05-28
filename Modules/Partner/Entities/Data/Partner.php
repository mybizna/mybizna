<?php

namespace Modules\Partner\Entities\Data;

use App\Classes\Datasetter;
use Illuminate\Support\Facades\DB;

class Partner
{

    public $ordering = 1;

    public function data(Datasetter $datasetter)
    {
        $partner = DB::table('partner')->first();

        if (!$partner) {
            $user = DB::table('users')->first();

            $datasetter->add_data('partner', 'partner', 'user_id', [
                "user_id" => $user->id,
                "email" => $user->email,
            ]);
        }
    }
}
