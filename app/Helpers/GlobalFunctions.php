<?php

use Illuminate\Support\Facades\DB;

use App\Jobs\AppMailerJob;

if (!function_exists('sendmail')) {

    function sendmail(array $data)
    {
        try {
            dispatch(new AppMailerJob($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('getRealQuery')) {
    function getRealQuery($query, $dumpIt = false)
    {
        $params = array_map(function ($item) {
            return "'{$item}'";
        }, $query->getBindings());
        $result = str_replace_array('\?', $params, $query->toSql());
        if ($dumpIt) {
            dd($result);
        }
        return $result;
    }
}

function messageBag($key, $message)
{
    $messageBag = [];

    if (config()->has('core.messageBag')) {
        $messageBag = config('core.messageBag');
    }

    config(['kernel.messageBag' => $messageBag]);
}


function apply_filters($str, $object)
{
    return $object;
}

function do_action()
{
}

function current_user_can()
{
    return true;
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

function esc_attr_raw($str)
{
    return $str;
}

function esc_attr__($str)
{
    return $str;
}

function esc_attr($str)
{
    return $str;
}

function maybe_unserialize($str)
{
    return $str;
}

function maybe_serialize($str)
{
    return $str;
}

function get_user_meta($field, $user_id)
{
}

function sanitize_text_field($str)
{
    return $str;
}

function esc_html__($str)
{
    return $str;
}

function site_url()
{
    $url = 'url';
    return $url;
}

function absint($int)
{
    return abs($int);
}

function rest_url()
{
    $url = 'rest_url';
    return $url;
}

function admin_url()
{
    $url = 'admin_url';
    return $url;
}

function esc_url($url)
{
    return $url;
}

function esc_url_raw($url)
{
    return $url;
}


function wp_parse_args($args, $defaults)
{
    return array_merge($args, $defaults);
}


function esc_like($str)
{
    return $str;
}

function get_userdata($user_id)
{
    $result = DB::select("SELECT * FROM users WHERE id='{$user_id}'");

    return $result;
}

function get_user_by($field, $value)
{
    $result = DB::table('users')->where($field, $value)->first();

    $result;
}

function get_the_title($id)
{
    $title = "Default Title";
    return $title;
}

function wp_get_attachment_image_src($logo_id, $size = 'thumb')
{

    $url = 'url';

    return $url;
}

function erp_is_valid_name()
{
    return true;
}

function erp_is_valid_contact_no()
{
    return true;
}


function erp_is_valid_date()
{
    return true;
}


function erp_is_valid_age()
{
    return true;
}

function is_email()
{
    return true;
}

function erp_is_valid_url()
{
    return true;
}

function erp_is_valid_zip_code()
{
    return true;
}


function update_user_meta()
{
    return true;
}

function add_user_meta()
{
    return true;
}


function delete_user_meta()
{
    return true;
}

function update_metadata()
{
    return true;
}

function add_metadata()
{
    return true;
}


function delete_metadata()
{
    return true;
}

function update_option($key, $value)
{
    return true;
}

function wp_cache_delete($str)
{
    return true;
}

function mailer()
{
}
function get_email()
{
    return 'email';
}


function acct_send_email($receiver, $pdf_file, $email_type, $voucher_no)
{
}

function wp_upload_dir()
{
    return 'wp_upload_dir';
}

function wp_update_user()
{
}

function get_metadata()
{
}


function current_time()
{
}

function erp_contains_disallowed_chars()
{
    return true;
}

function wp_check_filetype_and_ext($tmp_name, $name)
{
}

function current_datetime()
{
    return true;
}


function wp_handle_upload($attachments)
{
    return true;
}

function mybizna_get_var($str, $array)
{
    return true;
}
function get_post($event)
{
}

function get_post_meta($event)
{
}


function mybizna_format_date($event)
{
}

function mybizna_set_var($name, $value)
{
}


function mybizna_get_datetime_format($event)
{
}

function mybizna_get_date_format($event)
{
}

function mybizna_event_end_of_day($event)
{
}
function mybizna_event_beginning_of_day($event)
{
}

function mybizna_get_time_format($event)
{
}
