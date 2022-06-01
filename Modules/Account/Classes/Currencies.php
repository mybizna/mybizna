<?php

namespace Modules\Account\Classes;

use Modules\Account\Classes\CommonFunc;

use Illuminate\Support\Facades\DB;

class Currencies
{
    /**
     * Get all currencies
     *
     * @param boolean $count COunt
     *
     * @return mixed
     */
    public function getAllCurrencies($count = false)
    {


        if ($count) {
            return DB::scalar("SELECT count(*) FROM account_currency_info");
        }

        return DB::select("SELECT id, name, sign FROM account_currency_info");
    }

    /**
     * Get currencies dropdown
     *
     * @return array
     */
    public function getCurrenciesForDropdown()
    {
        $currencies = $this->getAllCurrencies();

        $currencies_dropdown = [];

        foreach ($currencies as $currency) {
            $currencies_dropdown[$currency['id']] = $currency['name'] . ' (' . $currency['sign'] . ')';
        }

        return $currencies_dropdown;
    }

    /**
     * Get active currency symbol
     *
     * @return string
     */
    public function getCurrencySymbol()
    {

        $common = new CommonFunc();

        $active_currency_id = $common->getCurrency(true);

        return DB::scalar(
            "SELECT sign FROM account_currency_info WHERE id = ?",
            [absint($active_currency_id)]
        );
    }

    /**
     * Get the price format depending on the currency position.
     *
     * Use it for JavaScript
     *
     * @return string
     */
    public function getPriceFormat()
    {
        $currency_pos = config('currency_position', false, 'left');
        $format       = '%s%v';

        switch ($currency_pos) {
            case 'left':
                $format = '%s%v';
                break;

            case 'right':
                $format = '%v%s';
                break;

            case 'left_space':
                $format = '%s&nbsp;%v';
                break;

            case 'right_space':
                $format = '%v&nbsp;%s';
                break;
        }

        return apply_filters('price_format', $format, $currency_pos);
    }

    /**
     * Get the price format depending on the currency position.
     *
     * Use it for PHP
     *
     * @return string
     */
    public function getPriceFormatPhp()
    {
        $currency_pos = config('currency_position', false, 'left');
        $format       = '%1$s%2$s';

        switch ($currency_pos) {
            case 'left':
                $format = '%1$s%2$s';
                break;

            case 'right':
                $format = '%2$s%1$s';
                break;

            case 'left_space':
                $format = '%1$s&nbsp;%2$s';
                break;

            case 'right_space':
                $format = '%2$s&nbsp;%1$s';
                break;
        }

        return apply_filters('price_format_php', $format, $currency_pos);
    }

    /**
     * Format the price with a currency symbol.
     *
     * @param float $main_price Prices
     * @param array $args       Data Filter (default: array())
     *
     * @return string
     */
    public function getPrice($main_price, $args = [])
    {
        $common = new CommonFunc();
        extract(
            apply_filters(
                'price_args',
                wp_parse_args(

                    [
                        'currency'           => $common->getCurrency(),
                        'decimal_separator'  => config('de_separator', false, '.'),
                        'thousand_separator' => config('th_separator', false, ','),
                        'decimals'           => absint(config('nm_decimal', false, 2)),
                        'price_format'       => $this->getPriceFormatPhp(),
                        'symbol'             => true,
                        'currency_symbol'    => $this->getCurrencySymbol(),
                    ],
                    $args,
                )
            )
        );

        $price           = number_format(abs($main_price), $decimals, $decimal_separator, $thousand_separator);
        $formatted_price = $symbol ? sprintf($price_format, $currency_symbol, $price) : $price;
        $formatted_price = ($main_price < 0) ? '(' . $formatted_price . ')' : $formatted_price;

        return apply_filters('price', $formatted_price, $price, $args);
    }
}
