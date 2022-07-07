<?php

namespace Modules\Base\Entities\Data;

use Illuminate\Support\Facades\DB;
use Modules\Core\Classes\Datasetter;

class Timezone
{

    public $ordering = 5;

    public function data(Datasetter $datasetter)
    {
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Andorra",
            "country_id" => DB::table('base_country')
                ->where('code', 'AD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Dubai",
            "country_id" => DB::table('base_country')
                ->where('code', 'AE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kabul",
            "country_id" => DB::table('base_country')
                ->where('code', 'AF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Antigua",
            "country_id" => DB::table('base_country')
                ->where('code', 'AG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Anguilla",
            "country_id" => DB::table('base_country')
                ->where('code', 'AI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Tirane",
            "country_id" => DB::table('base_country')
                ->where('code', 'AL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Yerevan",
            "country_id" => DB::table('base_country')
                ->where('code', 'AM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Luanda",
            "country_id" => DB::table('base_country')
                ->where('code', 'AO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Casey",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Davis",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/DumontDUrville",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Mawson",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/McMurdo",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Palmer",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Rothera",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Syowa",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Vostok",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Buenos_Aires",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Catamarca",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Cordoba",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Jujuy",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/La_Rioja",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Mendoza",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Rio_Gallegos",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Salta",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/San_Juan",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/San_Luis",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Tucuman",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Argentina/Ushuaia",
            "country_id" => DB::table('base_country')
                ->where('code', 'AR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Pago_Pago",
            "country_id" => DB::table('base_country')
                ->where('code', 'AS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Vienna",
            "country_id" => DB::table('base_country')
                ->where('code', 'AT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/Macquarie",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Adelaide",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Brisbane",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Broken_Hill",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Currie",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Darwin",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Eucla",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Hobart",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Lindeman",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Lord_Howe",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Melbourne",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Perth",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Australia/Sydney",
            "country_id" => DB::table('base_country')
                ->where('code', 'AU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Aruba",
            "country_id" => DB::table('base_country')
                ->where('code', 'AW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Mariehamn",
            "country_id" => DB::table('base_country')
                ->where('code', 'AX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Baku",
            "country_id" => DB::table('base_country')
                ->where('code', 'AZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Sarajevo",
            "country_id" => DB::table('base_country')
                ->where('code', 'BA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Barbados",
            "country_id" => DB::table('base_country')
                ->where('code', 'BB')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Dhaka",
            "country_id" => DB::table('base_country')
                ->where('code', 'BD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Brussels",
            "country_id" => DB::table('base_country')
                ->where('code', 'BE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Ouagadougou",
            "country_id" => DB::table('base_country')
                ->where('code', 'BF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Sofia",
            "country_id" => DB::table('base_country')
                ->where('code', 'BG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Bahrain",
            "country_id" => DB::table('base_country')
                ->where('code', 'BH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Bujumbura",
            "country_id" => DB::table('base_country')
                ->where('code', 'BI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Porto-Novo",
            "country_id" => DB::table('base_country')
                ->where('code', 'BJ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/St_Barthelemy",
            "country_id" => DB::table('base_country')
                ->where('code', 'BL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Bermuda",
            "country_id" => DB::table('base_country')
                ->where('code', 'BM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Brunei",
            "country_id" => DB::table('base_country')
                ->where('code', 'BN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/La_Paz",
            "country_id" => DB::table('base_country')
                ->where('code', 'BO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Kralendijk",
            "country_id" => DB::table('base_country')
                ->where('code', 'BQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Araguaina",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Bahia",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Belem",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Boa_Vista",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Campo_Grande",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Cuiaba",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Eirunepe",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Fortaleza",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Maceio",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Manaus",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Noronha",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Porto_Velho",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Recife",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Rio_Branco",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Santarem",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Sao_Paulo",
            "country_id" => DB::table('base_country')
                ->where('code', 'BR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Nassau",
            "country_id" => DB::table('base_country')
                ->where('code', 'BS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Thimphu",
            "country_id" => DB::table('base_country')
                ->where('code', 'BV')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Gaborone",
            "country_id" => DB::table('base_country')
                ->where('code', 'BW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Minsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'BY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Belize",
            "country_id" => DB::table('base_country')
                ->where('code', 'BZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Atikokan",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Blanc-Sablon",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Cambridge_Bay",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Creston",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Dawson",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Dawson_Creek",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Edmonton",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Glace_Bay",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Goose_Bay",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Halifax",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Inuvik",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Iqaluit",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Moncton",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Nipigon",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Pangnirtung",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Rainy_River",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Rankin_Inlet",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Regina",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Resolute",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/St_Johns",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Swift_Current",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Thunder_Bay",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Toronto",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Vancouver",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Whitehorse",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Winnipeg",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Yellowknife",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Cocos",
            "country_id" => DB::table('base_country')
                ->where('code', 'CC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Kinshasa",
            "country_id" => DB::table('base_country')
                ->where('code', 'CD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Lubumbashi",
            "country_id" => DB::table('base_country')
                ->where('code', 'CD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Bangui",
            "country_id" => DB::table('base_country')
                ->where('code', 'CF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Brazzaville",
            "country_id" => DB::table('base_country')
                ->where('code', 'CG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Zurich",
            "country_id" => DB::table('base_country')
                ->where('code', 'CH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Abidjan",
            "country_id" => DB::table('base_country')
                ->where('code', 'CI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Rarotonga",
            "country_id" => DB::table('base_country')
                ->where('code', 'CK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Santiago",
            "country_id" => DB::table('base_country')
                ->where('code', 'CL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Easter",
            "country_id" => DB::table('base_country')
                ->where('code', 'CL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Douala",
            "country_id" => DB::table('base_country')
                ->where('code', 'CM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Chongqing",
            "country_id" => DB::table('base_country')
                ->where('code', 'CN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Harbin",
            "country_id" => DB::table('base_country')
                ->where('code', 'CN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kashgar",
            "country_id" => DB::table('base_country')
                ->where('code', 'CN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Shanghai",
            "country_id" => DB::table('base_country')
                ->where('code', 'CN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Urumqi",
            "country_id" => DB::table('base_country')
                ->where('code', 'CN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Bogota",
            "country_id" => DB::table('base_country')
                ->where('code', 'CO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Costa_Rica",
            "country_id" => DB::table('base_country')
                ->where('code', 'CR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Havana",
            "country_id" => DB::table('base_country')
                ->where('code', 'CU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Cape_Verde",
            "country_id" => DB::table('base_country')
                ->where('code', 'CV')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Curacao",
            "country_id" => DB::table('base_country')
                ->where('code', 'CW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Christmas",
            "country_id" => DB::table('base_country')
                ->where('code', 'CX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Nicosia",
            "country_id" => DB::table('base_country')
                ->where('code', 'CY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Prague",
            "country_id" => DB::table('base_country')
                ->where('code', 'CZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Berlin",
            "country_id" => DB::table('base_country')
                ->where('code', 'DE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Busingen",
            "country_id" => DB::table('base_country')
                ->where('code', 'DE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Djibouti",
            "country_id" => DB::table('base_country')
                ->where('code', 'DJ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Copenhagen",
            "country_id" => DB::table('base_country')
                ->where('code', 'DK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Dominica",
            "country_id" => DB::table('base_country')
                ->where('code', 'DM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Santo_Domingo",
            "country_id" => DB::table('base_country')
                ->where('code', 'DO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Algiers",
            "country_id" => DB::table('base_country')
                ->where('code', 'DZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Guayaquil",
            "country_id" => DB::table('base_country')
                ->where('code', 'EC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Galapagos",
            "country_id" => DB::table('base_country')
                ->where('code', 'EC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Tallinn",
            "country_id" => DB::table('base_country')
                ->where('code', 'EE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Cairo",
            "country_id" => DB::table('base_country')
                ->where('code', 'EG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/El_Aaiun",
            "country_id" => DB::table('base_country')
                ->where('code', 'EH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Asmara",
            "country_id" => DB::table('base_country')
                ->where('code', 'ER')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Ceuta",
            "country_id" => DB::table('base_country')
                ->where('code', 'ES')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Canary",
            "country_id" => DB::table('base_country')
                ->where('code', 'ES')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Madrid",
            "country_id" => DB::table('base_country')
                ->where('code', 'ES')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Addis_Ababa",
            "country_id" => DB::table('base_country')
                ->where('code', 'ET')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Brussels",
            "country_id" => DB::table('base_country')
                ->where('code', 'EU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Helsinki",
            "country_id" => DB::table('base_country')
                ->where('code', 'FI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Fiji",
            "country_id" => DB::table('base_country')
                ->where('code', 'FJ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Stanley",
            "country_id" => DB::table('base_country')
                ->where('code', 'FK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Chuuk",
            "country_id" => DB::table('base_country')
                ->where('code', 'FM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Kosrae",
            "country_id" => DB::table('base_country')
                ->where('code', 'FM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Pohnpei",
            "country_id" => DB::table('base_country')
                ->where('code', 'FM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Faroe",
            "country_id" => DB::table('base_country')
                ->where('code', 'FO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Paris",
            "country_id" => DB::table('base_country')
                ->where('code', 'FR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Libreville",
            "country_id" => DB::table('base_country')
                ->where('code', 'GA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/London",
            "country_id" => DB::table('base_country')
                ->where('code', 'GB')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Grenada",
            "country_id" => DB::table('base_country')
                ->where('code', 'GD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Tbilisi",
            "country_id" => DB::table('base_country')
                ->where('code', 'GE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Cayenne",
            "country_id" => DB::table('base_country')
                ->where('code', 'GF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Guernsey",
            "country_id" => DB::table('base_country')
                ->where('code', 'GG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Accra",
            "country_id" => DB::table('base_country')
                ->where('code', 'GH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Gibraltar",
            "country_id" => DB::table('base_country')
                ->where('code', 'GI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Danmarkshavn",
            "country_id" => DB::table('base_country')
                ->where('code', 'GL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Godthab",
            "country_id" => DB::table('base_country')
                ->where('code', 'GL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Scoresbysund",
            "country_id" => DB::table('base_country')
                ->where('code', 'GL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Thule",
            "country_id" => DB::table('base_country')
                ->where('code', 'GL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Banjul",
            "country_id" => DB::table('base_country')
                ->where('code', 'GM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Conakry",
            "country_id" => DB::table('base_country')
                ->where('code', 'GN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Guadeloupe",
            "country_id" => DB::table('base_country')
                ->where('code', 'GP')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Malabo",
            "country_id" => DB::table('base_country')
                ->where('code', 'GQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Athens",
            "country_id" => DB::table('base_country')
                ->where('code', 'GR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/South_Georgia",
            "country_id" => DB::table('base_country')
                ->where('code', 'GS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Guatemala",
            "country_id" => DB::table('base_country')
                ->where('code', 'GT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Guam",
            "country_id" => DB::table('base_country')
                ->where('code', 'GU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Bissau",
            "country_id" => DB::table('base_country')
                ->where('code', 'GW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Guyana",
            "country_id" => DB::table('base_country')
                ->where('code', 'GY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Hong_Kong",
            "country_id" => DB::table('base_country')
                ->where('code', 'HK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Kerguelen",
            "country_id" => DB::table('base_country')
                ->where('code', 'HM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Tegucigalpa",
            "country_id" => DB::table('base_country')
                ->where('code', 'HN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Zagreb",
            "country_id" => DB::table('base_country')
                ->where('code', 'HR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Port-au-Prince",
            "country_id" => DB::table('base_country')
                ->where('code', 'HT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Budapest",
            "country_id" => DB::table('base_country')
                ->where('code', 'HU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Jakarta",
            "country_id" => DB::table('base_country')
                ->where('code', 'ID')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Jayapura",
            "country_id" => DB::table('base_country')
                ->where('code', 'ID')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Makassar",
            "country_id" => DB::table('base_country')
                ->where('code', 'ID')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Pontianak",
            "country_id" => DB::table('base_country')
                ->where('code', 'ID')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Dublin",
            "country_id" => DB::table('base_country')
                ->where('code', 'IE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Jerusalem",
            "country_id" => DB::table('base_country')
                ->where('code', 'IL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Isle_of_Man",
            "country_id" => DB::table('base_country')
                ->where('code', 'IM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kolkata",
            "country_id" => DB::table('base_country')
                ->where('code', 'IN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Chagos",
            "country_id" => DB::table('base_country')
                ->where('code', 'IO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Baghdad",
            "country_id" => DB::table('base_country')
                ->where('code', 'IQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Tehran",
            "country_id" => DB::table('base_country')
                ->where('code', 'IR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Reykjavik",
            "country_id" => DB::table('base_country')
                ->where('code', 'IS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Rome",
            "country_id" => DB::table('base_country')
                ->where('code', 'IT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Jersey",
            "country_id" => DB::table('base_country')
                ->where('code', 'JE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Jamaica",
            "country_id" => DB::table('base_country')
                ->where('code', 'JM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Amman",
            "country_id" => DB::table('base_country')
                ->where('code', 'JO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Tokyo",
            "country_id" => DB::table('base_country')
                ->where('code', 'JP')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Nairobi",
            "country_id" => DB::table('base_country')
                ->where('code', 'KE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Bishkek",
            "country_id" => DB::table('base_country')
                ->where('code', 'KG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Phnom_Penh",
            "country_id" => DB::table('base_country')
                ->where('code', 'KH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Enderbury",
            "country_id" => DB::table('base_country')
                ->where('code', 'KI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Kiritimati",
            "country_id" => DB::table('base_country')
                ->where('code', 'KI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Tarawa",
            "country_id" => DB::table('base_country')
                ->where('code', 'KI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Comoro",
            "country_id" => DB::table('base_country')
                ->where('code', 'KM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/St_Kitts",
            "country_id" => DB::table('base_country')
                ->where('code', 'KN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Pyongyang",
            "country_id" => DB::table('base_country')
                ->where('code', 'KP')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Seoul",
            "country_id" => DB::table('base_country')
                ->where('code', 'KR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kuwait",
            "country_id" => DB::table('base_country')
                ->where('code', 'KW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Cayman",
            "country_id" => DB::table('base_country')
                ->where('code', 'KY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Almaty",
            "country_id" => DB::table('base_country')
                ->where('code', 'KZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Aqtau",
            "country_id" => DB::table('base_country')
                ->where('code', 'KZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Aqtobe",
            "country_id" => DB::table('base_country')
                ->where('code', 'KZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Oral",
            "country_id" => DB::table('base_country')
                ->where('code', 'KZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Qyzylorda",
            "country_id" => DB::table('base_country')
                ->where('code', 'KZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Vientiane",
            "country_id" => DB::table('base_country')
                ->where('code', 'LA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Beirut",
            "country_id" => DB::table('base_country')
                ->where('code', 'LB')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/St_Lucia",
            "country_id" => DB::table('base_country')
                ->where('code', 'LC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Vaduz",
            "country_id" => DB::table('base_country')
                ->where('code', 'LI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Colombo",
            "country_id" => DB::table('base_country')
                ->where('code', 'LK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Monrovia",
            "country_id" => DB::table('base_country')
                ->where('code', 'LR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Maseru",
            "country_id" => DB::table('base_country')
                ->where('code', 'LS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Vilnius",
            "country_id" => DB::table('base_country')
                ->where('code', 'LT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Luxembourg",
            "country_id" => DB::table('base_country')
                ->where('code', 'LU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Riga",
            "country_id" => DB::table('base_country')
                ->where('code', 'LV')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Tripoli",
            "country_id" => DB::table('base_country')
                ->where('code', 'LY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Casablanca",
            "country_id" => DB::table('base_country')
                ->where('code', 'MA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Monaco",
            "country_id" => DB::table('base_country')
                ->where('code', 'MC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Chisinau",
            "country_id" => DB::table('base_country')
                ->where('code', 'MD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Podgorica",
            "country_id" => DB::table('base_country')
                ->where('code', 'ME')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Marigot",
            "country_id" => DB::table('base_country')
                ->where('code', 'MF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Antananarivo",
            "country_id" => DB::table('base_country')
                ->where('code', 'MG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Kwajalein",
            "country_id" => DB::table('base_country')
                ->where('code', 'MH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Majuro",
            "country_id" => DB::table('base_country')
                ->where('code', 'MH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Skopje",
            "country_id" => DB::table('base_country')
                ->where('code', 'MK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Bamako",
            "country_id" => DB::table('base_country')
                ->where('code', 'ML')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Rangoon",
            "country_id" => DB::table('base_country')
                ->where('code', 'MM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Choibalsan",
            "country_id" => DB::table('base_country')
                ->where('code', 'MN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Hovd",
            "country_id" => DB::table('base_country')
                ->where('code', 'MN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Ulaanbaatar",
            "country_id" => DB::table('base_country')
                ->where('code', 'MN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Macau",
            "country_id" => DB::table('base_country')
                ->where('code', 'MO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Saipan",
            "country_id" => DB::table('base_country')
                ->where('code', 'MP')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Martinique",
            "country_id" => DB::table('base_country')
                ->where('code', 'MQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Nouakchott",
            "country_id" => DB::table('base_country')
                ->where('code', 'MR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Montserrat",
            "country_id" => DB::table('base_country')
                ->where('code', 'MS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Malta",
            "country_id" => DB::table('base_country')
                ->where('code', 'MT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Mauritius",
            "country_id" => DB::table('base_country')
                ->where('code', 'MU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Maldives",
            "country_id" => DB::table('base_country')
                ->where('code', 'MV')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Blantyre",
            "country_id" => DB::table('base_country')
                ->where('code', 'MW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Bahia_Banderas",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Cancun",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Chihuahua",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Hermosillo",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Matamoros",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Mazatlan",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Merida",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Mexico_City",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Monterrey",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Ojinaga",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Santa_Isabel",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Tijuana",
            "country_id" => DB::table('base_country')
                ->where('code', 'MX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kuala_Lumpur",
            "country_id" => DB::table('base_country')
                ->where('code', 'MY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kuching",
            "country_id" => DB::table('base_country')
                ->where('code', 'MY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Maputo",
            "country_id" => DB::table('base_country')
                ->where('code', 'MZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Windhoek",
            "country_id" => DB::table('base_country')
                ->where('code', 'NA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Noumea",
            "country_id" => DB::table('base_country')
                ->where('code', 'NC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Niamey",
            "country_id" => DB::table('base_country')
                ->where('code', 'NE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Norfolk",
            "country_id" => DB::table('base_country')
                ->where('code', 'NF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Lagos",
            "country_id" => DB::table('base_country')
                ->where('code', 'NG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Managua",
            "country_id" => DB::table('base_country')
                ->where('code', 'NI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Amsterdam",
            "country_id" => DB::table('base_country')
                ->where('code', 'NL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Oslo",
            "country_id" => DB::table('base_country')
                ->where('code', 'NO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kathmandu",
            "country_id" => DB::table('base_country')
                ->where('code', 'NP')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Nauru",
            "country_id" => DB::table('base_country')
                ->where('code', 'NR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Niue",
            "country_id" => DB::table('base_country')
                ->where('code', 'NU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Auckland",
            "country_id" => DB::table('base_country')
                ->where('code', 'NZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Chatham",
            "country_id" => DB::table('base_country')
                ->where('code', 'NZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Muscat",
            "country_id" => DB::table('base_country')
                ->where('code', 'OM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Panama",
            "country_id" => DB::table('base_country')
                ->where('code', 'PA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Lima",
            "country_id" => DB::table('base_country')
                ->where('code', 175)->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Gambier",
            "country_id" => DB::table('base_country')
                ->where('code', 'PF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Marquesas",
            "country_id" => DB::table('base_country')
                ->where('code', 'PF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Tahiti",
            "country_id" => DB::table('base_country')
                ->where('code', 'PF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Port_Moresby",
            "country_id" => DB::table('base_country')
                ->where('code', 'PG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Manila",
            "country_id" => DB::table('base_country')
                ->where('code', 'PH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Karachi",
            "country_id" => DB::table('base_country')
                ->where('code', 'PK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Warsaw",
            "country_id" => DB::table('base_country')
                ->where('code', 'PL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Miquelon",
            "country_id" => DB::table('base_country')
                ->where('code', 'PM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Pitcairn",
            "country_id" => DB::table('base_country')
                ->where('code', 'PN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Puerto_Rico",
            "country_id" => DB::table('base_country')
                ->where('code', 'PR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Gaza",
            "country_id" => DB::table('base_country')
                ->where('code', 'PS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Hebron",
            "country_id" => DB::table('base_country')
                ->where('code', 'PS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Azores",
            "country_id" => DB::table('base_country')
                ->where('code', 'PT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/Madeira",
            "country_id" => DB::table('base_country')
                ->where('code', 'PT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Lisbon",
            "country_id" => DB::table('base_country')
                ->where('code', 'PT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Palau",
            "country_id" => DB::table('base_country')
                ->where('code', 186)->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Asuncion",
            "country_id" => DB::table('base_country')
                ->where('code', 'PY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Qatar",
            "country_id" => DB::table('base_country')
                ->where('code', 'QA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Reunion",
            "country_id" => DB::table('base_country')
                ->where('code', 'RE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Bucharest",
            "country_id" => DB::table('base_country')
                ->where('code', 'RO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Belgrade",
            "country_id" => DB::table('base_country')
                ->where('code', 'RS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Anadyr",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Irkutsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Kamchatka",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Khandyga",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Krasnoyarsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Magadan",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Novokuznetsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Novosibirsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Omsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Sakhalin",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Ust-Nera",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Vladivostok",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Yakutsk",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Yekaterinburg",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Kaliningrad",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Moscow",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Samara",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Volgograd",
            "country_id" => DB::table('base_country')
                ->where('code', 'RU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Kigali",
            "country_id" => DB::table('base_country')
                ->where('code', 'RW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Riyadh",
            "country_id" => DB::table('base_country')
                ->where('code', 'SA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Guadalcanal",
            "country_id" => DB::table('base_country')
                ->where('code', 'SB')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Mahe",
            "country_id" => DB::table('base_country')
                ->where('code', 'SC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Khartoum",
            "country_id" => DB::table('base_country')
                ->where('code', 'SD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Stockholm",
            "country_id" => DB::table('base_country')
                ->where('code', 'SE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Singapore",
            "country_id" => DB::table('base_country')
                ->where('code', 'SG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Atlantic/St_Helena",
            "country_id" => DB::table('base_country')
                ->where('code', 'SH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Ljubljana",
            "country_id" => DB::table('base_country')
                ->where('code', 'SI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Arctic/Longyearbyen",
            "country_id" => DB::table('base_country')
                ->where('code', 'SJ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Bratislava",
            "country_id" => DB::table('base_country')
                ->where('code', 'SK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Freetown",
            "country_id" => DB::table('base_country')
                ->where('code', 'SL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/San_Marino",
            "country_id" => DB::table('base_country')
                ->where('code', 'SM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Dakar",
            "country_id" => DB::table('base_country')
                ->where('code', 'SN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Mogadishu",
            "country_id" => DB::table('base_country')
                ->where('code', 'SO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Paramaribo",
            "country_id" => DB::table('base_country')
                ->where('code', 'SR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Juba",
            "country_id" => DB::table('base_country')
                ->where('code', 'SS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Sao_Tome",
            "country_id" => DB::table('base_country')
                ->where('code', 'ST')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/El_Salvador",
            "country_id" => DB::table('base_country')
                ->where('code', 'SV')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Lower_Princes",
            "country_id" => DB::table('base_country')
                ->where('code', 'SX')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Damascus",
            "country_id" => DB::table('base_country')
                ->where('code', 'SY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Mbabane",
            "country_id" => DB::table('base_country')
                ->where('code', 'SZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Grand_Turk",
            "country_id" => DB::table('base_country')
                ->where('code', 'TC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Ndjamena",
            "country_id" => DB::table('base_country')
                ->where('code', 'TD')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Kerguelen",
            "country_id" => DB::table('base_country')
                ->where('code', 'TF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Lome",
            "country_id" => DB::table('base_country')
                ->where('code', 'TG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Bangkok",
            "country_id" => DB::table('base_country')
                ->where('code', 'TH')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Dushanbe",
            "country_id" => DB::table('base_country')
                ->where('code', 'TJ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Fakaofo",
            "country_id" => DB::table('base_country')
                ->where('code', 'TK')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Dili",
            "country_id" => DB::table('base_country')
                ->where('code', 'TL')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Ashgabat",
            "country_id" => DB::table('base_country')
                ->where('code', 'TM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Tunis",
            "country_id" => DB::table('base_country')
                ->where('code', 'TN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Tongatapu",
            "country_id" => DB::table('base_country')
                ->where('code', 'TO')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Istanbul",
            "country_id" => DB::table('base_country')
                ->where('code', 'TR')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Port_of_Spain",
            "country_id" => DB::table('base_country')
                ->where('code', 'TT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Funafuti",
            "country_id" => DB::table('base_country')
                ->where('code', 'TV')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Taipei",
            "country_id" => DB::table('base_country')
                ->where('code', 'TW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Dar_es_Salaam",
            "country_id" => DB::table('base_country')
                ->where('code', 'TZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Kiev",
            "country_id" => DB::table('base_country')
                ->where('code', 'UA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Simferopol",
            "country_id" => DB::table('base_country')
                ->where('code', 'UA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Uzhgorod",
            "country_id" => DB::table('base_country')
                ->where('code', 'UA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Zaporozhye",
            "country_id" => DB::table('base_country')
                ->where('code', 'UA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Kampala",
            "country_id" => DB::table('base_country')
                ->where('code', 'UG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Johnston",
            "country_id" => DB::table('base_country')
                ->where('code', 'UM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Midway",
            "country_id" => DB::table('base_country')
                ->where('code', 'UM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Wake",
            "country_id" => DB::table('base_country')
                ->where('code', 'UM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Adak",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Anchorage",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Boise",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Chicago",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Denver",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Detroit",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Indianapolis",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Knox",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Marengo",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Petersburg",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Tell_City",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Vevay",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Vincennes",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Indiana/Winamac",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Juneau",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Kentucky/Louisville",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Kentucky/Monticello",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Los_Angeles",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Menominee",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Metlakatla",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/New_York",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Nome",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/North_Dakota/Beulah",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/North_Dakota/Center",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/North_Dakota/New_Salem",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Phoenix",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Sitka",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Yakutat",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Honolulu",
            "country_id" => DB::table('base_country')
                ->where('code', 'US')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Montevideo",
            "country_id" => DB::table('base_country')
                ->where('code', 'UY')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Samarkand",
            "country_id" => DB::table('base_country')
                ->where('code', 'UZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Tashkent",
            "country_id" => DB::table('base_country')
                ->where('code', 'UZ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Europe/Vatican",
            "country_id" => DB::table('base_country')
                ->where('code', 'VA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/St_Vincent",
            "country_id" => DB::table('base_country')
                ->where('code', 'VC')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Caracas",
            "country_id" => DB::table('base_country')
                ->where('code', 'VE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Tortola",
            "country_id" => DB::table('base_country')
                ->where('code', 'VG')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/St_Thomas",
            "country_id" => DB::table('base_country')
                ->where('code', 'VI')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Ho_Chi_Minh",
            "country_id" => DB::table('base_country')
                ->where('code', 'VN')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Efate",
            "country_id" => DB::table('base_country')
                ->where('code', 'VU')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Wallis",
            "country_id" => DB::table('base_country')
                ->where('code', 'WF')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Pacific/Apia",
            "country_id" => DB::table('base_country')
                ->where('code', 'WS')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Asia/Aden",
            "country_id" => DB::table('base_country')
                ->where('code', 'YE')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Indian/Mayotte",
            "country_id" => DB::table('base_country')
                ->where('code', 'YT')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Johannesburg",
            "country_id" => DB::table('base_country')
                ->where('code', 'ZA')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Lusaka",
            "country_id" => DB::table('base_country')
                ->where('code', 'ZM')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Africa/Harare",
            "country_id" => DB::table('base_country')
                ->where('code', 'ZW')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "Antarctica/South_Pole",
            "country_id" => DB::table('base_country')
                ->where('code', 'AQ')->value('id')
        ]);
        $datasetter->add_data('base', 'timezone', 'name',  [
            "name" => "America/Montreal",
            "country_id" => DB::table('base_country')
                ->where('code', 'CA')->value('id')
        ]);
    }
}
