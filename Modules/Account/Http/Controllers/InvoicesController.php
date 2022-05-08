<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Classes\CommonFunc;
use Modules\Account\Classes\Transactions;
use Modules\Account\Classes\Invoices;


class InvoicesController extends Controller
{

    /**
     * Get a collection of invoices
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_invoices($request)
    {
        $invoices = new Invoices();

        $args = [
            'number'     => $request['per_page'],
            'offset'     => ($request['per_page'] * ($request['page'] - 1)),
            'start_date' => empty($request['start_date']) ? '' : $request['start_date'],
            'end_date'   => empty($request['end_date']) ? date('Y-m-d') : $request['end_date'],
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $invoice_data = $invoices->getAllInvoices($args);
        $total_items  = $invoices->getAllInvoices(
            [
                'count'  => true,
                'number' => -1,
            ]
        );

        foreach ($invoice_data as $item) {
            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $data              = $this->prepare_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, $total_items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Get an invoice
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_invoice($request)
    {
        $trans = new Transactions();
        $invoices = new Invoices();
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_invoice_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $item = $invoices->getInvoice($id);

        $link_hash    = $trans->getInvoiceLinkHash($id, 'invoice');
        $readonly_url = add_query_arg(
            [
                'query'    => 'readonly_invoice',
                'trans_id' => $id,
                'auth'     => $link_hash,
            ],
            site_url()
        );

        $item['readonly_url'] = $readonly_url;

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $item                           = $this->prepare_item_for_response($item, $request, $additional_fields);
        $response                       = rest_ensure_response($item);

        $response->set_status(200);

        return $response;
    }

    /**
     * Create an invoice
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function create_invoice($request)
    {
        $invoices = new Invoices();
        $invoice_data = $this->prepare_item_for_database($request);

        $item_total          = 0;
        $item_discount_total = 0;
        $item_tax_total      = 0;
        $additional_fields   = [];

        $items = $request['line_items'];

        foreach ($items as $value) {
            $sub_total = $value['qty'] * $value['unit_price'];

            $item_total += $sub_total;
            $item_tax_total += $value['tax'];
            $item_discount_total += $value['discount'];
        }

        $invoice_data['billing_address'] = maybe_serialize($request['billing_address']);
        $invoice_data['discount']        = $item_discount_total;
        $invoice_data['discount_type']   = $request['discount_type'];
        $invoice_data['tax_rate_id']     = $request['tax_rate_id'];
        $invoice_data['tax']             = $item_tax_total;
        $invoice_data['amount']          = $item_total;
        $invoice_data['attachments']     = maybe_serialize($request['attachments']);
        $additional_fields['namespace']  = $this->namespace;
        $additional_fields['rest_base']  = $this->rest_base;

        $invoice_id = $invoices->insertInvoice($invoice_data);

        $invoice_data['id'] = $invoice_id;

        $this->add_log($invoice_data, 'add');

        $invoice_data = $this->prepare_item_for_response($invoice_data, $request, $additional_fields);

        $response = rest_ensure_response($invoice_data);
        $response->set_status(201);

        return $response;
    }

    /**
     * Update an invoice
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_invoice($request)
    {
        $common = new CommonFunc();
        $invoices = new Invoices();
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_invoice_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $can_edit = $common->checkVoucherEditState($id);

        if (!$can_edit) {
            return new WP_Error('rest_invoice_invalid_edit', __('Invalid edit permission for update.'), ['status' => 403]);
        }

        $invoice_data = $this->prepare_item_for_database($request);

        $item_total          = 0;
        $item_discount_total = 0;
        $item_tax_total      = 0;
        $additional_fields   = [];

        $items = $request['line_items'];

        foreach ($items as $value) {
            $sub_total = $value['qty'] * $value['unit_price'];

            $item_total += $sub_total;
            $item_tax_total += $value['tax'];
            $item_discount_total += $value['discount'];
        }

        $invoice_data['billing_address'] = maybe_serialize($request['billing_address']);
        $invoice_data['discount']        = $item_discount_total;
        $invoice_data['discount_type']   = $request['discount_type'];
        $invoice_data['tax_rate_id']     = $request['tax_rate_id'];
        $invoice_data['tax']             = $item_tax_total;
        $invoice_data['amount']          = $item_total;
        $invoice_data['attachments']     = maybe_serialize($request['attachments']);
        $additional_fields['namespace']  = $this->namespace;
        $additional_fields['rest_base']  = $this->rest_base;

        $old_data = $invoices->getInvoice($id);

        $invoice_id = $invoices->updateInvoice($invoice_data, $id);

        $this->add_log($id, 'edit', $old_data);

        $invoice_data['id'] = $invoice_id;

        $invoice_data = $this->prepare_item_for_response($invoice_data, $request, $additional_fields);

        $response = rest_ensure_response($invoice_data);
        $response->set_status(201);

        return $response;
    }

    /**
     * Void an invoice
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function void_invoice($request)
    {
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_invoice_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $this->voidInvoice($id);

        return new WP_REST_Response(true, 204);
    }

    /**
     * Get a collection of invoices with due of a customer
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function due_invoices($request)
    {
        $invoices = new Invoices();
        $id = (int) $request['id'];

        if (empty($id)) {
            return new WP_Error('rest_invoice_invalid_id', __('Invalid resource id.'), ['status' => 404]);
        }

        $args = [
            'number' => isset($request['per_page']) ? $request['per_page'] : 20,
            'offset' => ($request['per_page'] * ($request['page'] - 1)),
        ];

        $formatted_items   = [];
        $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $invoice_data = $invoices->receivePaymentsFromCustomer(['people_id' => $id]);
        $total_items  = count($invoice_data);

        foreach ($invoice_data as $item) {
            if (isset($request['include'])) {
                $include_params = explode(',', str_replace(' ', '', $request['include']));

                if (in_array('created_by', $include_params, true)) {
                    $item['created_by'] = $this->get_user($item['created_by']);
                }
            }

            $data              = $this->prepare_item_for_response($item, $request, $additional_fields);
            $formatted_items[] = $this->prepare_response_for_collection($data);
        }

        $response = rest_ensure_response($formatted_items);
        $response = $this->format_collection_response($response, $request, $total_items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Get Dashboard Recievables segments
     *
     * @param $request
     *
     * @return mixed|WP_REST_Response
     */
    public function get_overview_receivables($request)
    {
        $invoices = new Invoices();
        $items    = $invoices->getRecievablesOverview();
        $response = rest_ensure_response($items);

        $response->set_status(200);

        return $response;
    }

    /**
     * Upload attachment for invoice
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function upload_attachments($request)
    {
        $file = $_FILES['attachments'];

        $movefiles = $account->uploadAttachments($file);

        $response = rest_ensure_response($movefiles);
        $response->set_status(200);

        return $response;
    }

    /**
     * Log for invoice related actions
     *
     * @param int $id
     * @param string $action
     * @param array $old_data
     *
     * @return void
     */
    public function add_log($id, $action, $old_data = [])
    {
        $common = new CommonFunc();
        $invoices = new Invoices();
        switch ($action) {
            case 'edit':
                $operation = 'updated';
                $data      = $invoices->getInvoice($id);
                $changes   = !empty($old_data) ? $common->getArrayDiff((array) $data, (array) $old_data) : [];
                unset($changes['pdf_link'], $changes['attachments'], $changes['line_items']);
                break;
            case 'delete':
                $operation = 'deleted';
                break;
            default:
                $operation = 'created';
        }
    }

    /**
     * Prepare a single item for create or update
     *
     * @param WP_REST_Request $request request object
     *
     * @return array $prepared_item
     */
    protected function prepare_item_for_database($request)
    {
        $prepared_item = [];

        if (isset($request['customer_id'])) {
            $prepared_item['customer_id'] = $request['customer_id'];
        }

        if (isset($request['date'])) {
            $prepared_item['date'] = $request['date'];
        }

        if (isset($request['due_date'])) {
            $prepared_item['due_date'] = $request['due_date'];
        }

        if (isset($request['billing_address'])) {
            $prepared_item['billing_address'] = maybe_serialize($request['billing_address']);
        }

        if (isset($request['line_items'])) {
            $prepared_item['line_items'] = $request['line_items'];
        }

        if (isset($request['discount_type'])) {
            $prepared_item['discount_type'] = $request['discount_type'];
        }

        if (isset($request['tax_rate_id'])) {
            $prepared_item['tax_rate_id'] = $request['tax_rate_id'];
        }

        if (isset($request['status'])) {
            $prepared_item['status'] = $request['status'];
        }

        if (isset($request['estimate'])) {
            $prepared_item['estimate'] = $request['estimate'];
        }

        if (isset($request['attachments'])) {
            $prepared_item['attachments'] = maybe_serialize($request['attachments']);
        }

        if (isset($request['particulars'])) {
            $prepared_item['particulars'] = $request['particulars'];
        }

        if (isset($request['transaction_by'])) {
            $prepared_item['transaction_by'] = $request['transaction_by'];
        }

        if (isset($request['convert'])) {
            $prepared_item['convert'] = $request['convert'];
        }

        $prepared_item['request'] = $request;

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param object|array    $item
     * @param WP_REST_Request $request           request object
     * @param array           $additional_fields (optional)
     *
     * @return WP_REST_Response $response response data
     */
    public function prepare_item_for_response($item, $request, $additional_fields = [])
    {
        $data = array_merge($item, $additional_fields);

        // Wrap the data in a response object
        $response = rest_ensure_response($data);

        $response = $this->add_links($response, $item, $additional_fields);

        return $response;
    }

    /**
     * Get the User's schema, conforming to JSON Schema
     *
     * @return array
     */
    public function get_item_schema()
    {
        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'invoice',
            'type'       => 'object',
            'properties' => [
                'customer_id'     => [
                    'description' => __('Customer id for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
                'date'            => [
                    'description' => __('Date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'due_date'        => [
                    'description' => __('Due date for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'billing_address' => [
                    'description' => __('List of billing address data.', 'erp'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'discount_type' => [
                    'description' => __('Discount type data.', 'erp'),
                    'type'        => 'string',
                    'context'     => ['view', 'edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'tax_rate_id' => [
                    'description' => __('Tax rate id.', 'erp'),
                    'type'        => 'integer',
                    'context'     => ['view', 'edit'],
                ],
                'line_items'      => [
                    'description' => __('List of line items data.', 'erp'),
                    'type'        => 'array',
                    'context'     => ['view', 'edit'],
                    'properties'  => [
                        'product_id'   => [
                            'description' => __('Product id.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'product_type_name' => [
                            'description' => __('Product type.', 'erp'),
                            'type'        => 'string',
                            'context'     => ['view', 'edit'],
                            'arg_options' => [
                                'sanitize_callback' => 'sanitize_text_field',
                            ],
                        ],
                        'tax_cat_id' => [
                            'description' => __('Product type.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'qty'          => [
                            'description' => __('Product quantity.', 'erp'),
                            'type'        => 'integer',
                            'context'     => ['view', 'edit'],
                        ],
                        'unit_price'   => [
                            'description' => __('Unit price.', 'erp'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                        'discount'     => [
                            'description' => __('Discount.', 'erp'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                        'tax'          => [
                            'description' => __('Tax.'),
                            'type'        => 'number',
                            'context'     => ['edit'],
                        ],
                        'tax_rate'  => [
                            'description' => __('Tax percent.', 'erp'),
                            'type'        => 'number',
                            'context'     => ['view', 'edit'],
                        ],
                        'item_total'   => [
                            'description' => __('Item total.'),
                            'type'        => 'number',
                            'context'     => ['edit'],
                        ],
                    ],
                ],
                'type'            => [
                    'description' => __('Type for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'status'          => [
                    'description' => __('Status for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                ],
                'particulars'          => [
                    'description' => __('Status for the resource.'),
                    'type'        => 'string',
                    'context'     => ['edit'],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'estimate'        => [
                    'description' => __('Status for the resource.'),
                    'type'        => 'integer',
                    'context'     => ['edit'],
                    'required'    => true,
                ],
            ],
        ];

        return $schema;
    }
}
