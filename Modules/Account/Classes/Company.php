<?php

namespace Modules\Account\Classes;

use WeDevs\ERP\Admin\Models\Company_Locations;
use Illuminate\Support\Facades\DB;

/**
 * Company class
 */
class Company
{

    /**
     * Holds the company data array
     *
     * @var array
     */
    private $data;

    /**
     * Option name in wp_options table
     */
    const key = '_company';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = config(self::key, $this->defaults());
    }

    /**
     * Get some defaults if no data found
     *
     * @return array
     */
    public function defaults()
    {
        $defaults = [
            'logo'    => 0,
            'name'    => __('Untitled Company'),
            'address' => [
                'address_1' => __('Street Address 1'),
                'address_2' => __('Address Line 2'),
                'city'      => __('City'),
                'state'     => __('State'),
                'postcode'  => '',
                'country'   => 'US',
            ],
            'phone'    => '',
            'fax'      => '',
            'mobile'   => '',
            'website'  => '',
            'currency' => 'USD',
        ];

        return apply_filters('company_defaults', $defaults);
    }

    /**
     * Magic method to get item data values
     *
     * @param  string
     *
     * @return string
     */
    public function __get($key)
    {
        if (isset($this->data[$key])) {
            if (is_array($this->data[$key])) {
                return $this->data[$key];
            }

            return stripslashes($this->data[$key]);
        }
    }

    /**
     * Update company data
     *
     * @param array $args
     *
     * @return void
     */
    public function update($args = [])
    {
        $value = wp_parse_args($args, $this->defaults());

        update_option(self::key, $value);
    }

    /**
     * Check if a company has logo
     *
     * @return bool
     */
    public function has_logo()
    {
        return (int) $this->logo;
    }

    /**
     * Get the company logo
     *
     * @return string the HTML image attribute
     */
    public function get_logo()
    {
        $logo_id = (int) $this->logo;

        if (!$logo_id) {
            $url   = $this->placeholder_logo();
        } else {
            $image = wp_get_attachment_image_src($logo_id, 'medium');
            $url   = $image[0];
        }

        $image = sprintf('<img src="%s" alt="%s" />', esc_url($url), esc_attr($this->name));

        return $image;
    }

    /**
     * [placeholder_logo description]
     *
     * @return string placeholder image url
     */
    public function placeholder_logo()
    {
        $url = base_path() . '/images/placeholder.png';

        return apply_filters('placeholder_image', $url);
    }

    /**
     * Get formatted address of the company
     *
     * @return string address
     */
    public function get_formatted_address()
    {
        $country = Countries::instance();

        return $country->get_formatted_address([
            'address_1' => isset($this->address['address_1']) ? $this->address['address_1'] : '',
            'address_2' => isset($this->address['address_2']) ? $this->address['address_2'] : '',
            'city'      => isset($this->address['city']) ? $this->address['city'] : '',
            'state'     => isset($this->address['state']) ? $this->address['state'] : '',
            'postcode'  => isset($this->address['zip']) ? $this->address['zip'] : '',
            'country'   => isset($this->address['country']) ? $this->address['country'] : '',
        ]);
    }

    /**
     * [get_edit_url description]
     *
     * @return string the url
     */
    public function get_edit_url()
    {
        $url = admin_url('admin.php?page=erp-company').'/'.http_build_query(['action' => 'edit']);

        return $url;
    }

    /**
     * Check if the employee belongs to the company
     *
     * @param  int   employee id
     *
     * @return bool
     */
    public function has_employee($employee_id)
    {
        return true;
    }

    public function get_locations()
    {
        $locations = DB::select("SELECT * FROM base_company_location");

        return $locations;
    }

    /**
     * @param array $args
     *
     * @return void
     */
    public function create_location($args = [])
    {
        $defaults = [
            'id'         => 0,
            'name'       => '',
            'address_1'  => '',
            'address_2'  => '',
            'city'       => '',
            'state'      => '',
            'zip'        => '',
            'country'    => '',
        ];
        $fields      = wp_parse_args($args, $defaults);
        $location_id = intval($fields['id']);
        unset($fields['id']);

        // validation
        if (empty($fields['name'])) {
            config('kernel.messageBag')->add('no-name', __('No location name provided.'));
        }

        if (empty($fields['address_1'])) {
            config('kernel.messageBag')->add('no-address_1', __('No address provided.'));
        }

        if (empty($fields['country'])) {
            config('kernel.messageBag')->add('no-country', __('No country provided.'));
        }

        return DB::table("base_company_location")->insertGetId($fields);
    }
}
