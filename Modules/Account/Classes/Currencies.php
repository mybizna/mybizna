<?php
namespace Modules\Account\Classes;

class Bank
{
    /**
     * Get all currencies
     *
     * @return mixed
     */
    function getAllCurrencies($count = false)
    {
        global $wpdb;

        if ($count) {
            return $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}erp_acct_currency_info");
        }

        return $wpdb->get_results("SELECT id, name, sign FROM {$wpdb->prefix}erp_acct_currency_info", ARRAY_A);
    }

    /**
     * Get currencies dropdown
     *
     * @return array
     */
    function getCurrenciesForDropdown()
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
    function getCurrencySymbol()
    {
        global $wpdb;

        $active_currency_id = erp_get_currency(true);

        return $wpdb->get_var(
            $wpdb->prepare(
                "SELECT sign FROM {$wpdb->prefix}erp_acct_currency_info WHERE id = %d",
                absint($active_currency_id)
            )
        );
    }

    /**
     * Get the price format depending on the currency position.
     *
     * Use it for JavaScript
     *
     * @return string
     */
    function getPriceFormat()
    {
        $currency_pos = erp_get_option('erp_ac_currency_position', false, 'left');
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

        return apply_filters('erp_acct_price_format', $format, $currency_pos);
    }

    /**
     * Get the price format depending on the currency position.
     *
     * Use it for PHP
     *
     * @return string
     */
    function getPriceFormatPhp()
    {
        $currency_pos = erp_get_option('erp_ac_currency_position', false, 'left');
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

        return apply_filters('erp_acct_price_format_php', $format, $currency_pos);
    }

    /**
     * Format the price with a currency symbol.
     *
     * @param float $price
     * @param array $args  (default: array())
     *
     * @return string
     */
    function getPrice($main_price, $args = [])
    {
        extract(
            apply_filters(
                'erp_acct_price_args',
                wp_parse_args(
                    $args,
                    [
                        'currency'           => erp_get_currency(),
                        'decimal_separator'  => erp_get_option('erp_ac_de_separator', false, '.'),
                        'thousand_separator' => erp_get_option('erp_ac_th_separator', false, ','),
                        'decimals'           => absint(erp_get_option('erp_ac_nm_decimal', false, 2)),
                        'price_format'       => $this->getPriceFormatPhp(),
                        'symbol'             => true,
                        'currency_symbol'    => $this->getCurrencySymbol(),
                    ]
                )
            )
        );

        $price           = number_format(abs($main_price), $decimals, $decimal_separator, $thousand_separator);
        $formatted_price = $symbol ? sprintf($price_format, $currency_symbol, $price) : $price;
        $formatted_price = ($main_price < 0) ? '(' . $formatted_price . ')' : $formatted_price;

        return apply_filters('erp_acct_price', $formatted_price, $price, $args);
    }
}
