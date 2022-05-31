<?php

namespace Modules\Account\Classes;

use Illuminate\Support\Facades\DB;

class Capabilities
{

    /**
     * The manager role for HR employees
     *
     * @return string
     */
    public function getManagerRole()
    {
        return apply_filters('ac_get_manager_role', 'manager');
    }

    /**
     * When a new administrator is created, make him HR Manager by default
     *
     * @param int $user_id User id
     *
     * @return void
     */
    public function newAdminAsManager($user_id)
    {
        $user = get_user_by('id', $user_id);

        if ($user && in_array('administrator', $user->roles, true)) {
            $user->add_role($this->getManagerRole());
        }
    }

    /**
     * Check is current user is accounting manager
     *
     * @return bool
     */
    public function isCurrentUserManager()
    {
        $current_user_role = $this->getUserRole(auth()->user()->id);

        if ($this->getManagerRole() != $current_user_role) {
            return false;
        }

        return true;
    }

    /**
     * Return a user's HR role
     *
     * @param int $user_id User Id
     *
     * @return string
     */
    public function getUserRole($user_id = 0)
    {

        // Validate user id
        $user = get_userdata($user_id);
        $role = false;

        // User has roles so look for a HR one
        if (!empty($user->roles)) {
            // Look for a ac role
            $roles = array_intersect(
                array_values($user->roles),
                array_keys($this->getRoles())
            );

            // If there's a role in the array, use the first one. This isn't very
            // smart, but since roles aren't exactly hierarchical, and HR
            // does not yet have a UI for multiple user roles, it's fine for now.
            if (!empty($roles)) {
                $role = array_shift($roles);
            }
        }

        return apply_filters('get_user_role', $role, $user_id, $user);
    }

    /**
     * Get dynamic roles for HR
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = [
            $this->getManagerRole() => [
                'name'         => __('Accounting Manager'),
                'public'       => false,
            ],
        ];

        return apply_filters('get_roles', $roles);
    }



    /**
     * Get Caps For Role.
     *
     * @param mixed $role Role
     *
     * @return void
     */
    public function getCapsForRole($role = '')
    {
        $caps = [];

        // Which role are we looking for?
        switch ($role) {
            case $this->getManagerRole():
                $caps = [
                    'read'                            => true,
                    'view_dashboard'           => true,
                    'view_customer'            => true,
                    'view_single_customer'     => true,
                    'view_other_customers'     => true,
                    'create_customer'          => true,
                    'edit_customer'            => true,
                    'edit_other_customers'     => true,
                    'delete_customer'          => true,
                    'delete_other_customers'   => true,
                    'view_vendor'              => true,
                    'view_other_vendors'       => true,
                    'create_vendor'            => true,
                    'edit_vendor'              => true,
                    'edit_other_vendors'       => true,
                    'delete_vendor'            => true,
                    'delete_other_vendors'     => true,
                    'view_sale'                => true,
                    'view_single_vendor'       => true,
                    'view_other_sales'         => true,
                    'view_sales_summary'       => true,
                    'create_sales_payment'     => true,
                    'publish_sales_payment'    => true,
                    'create_sales_invoice'     => true,
                    'publish_sales_invoice'    => true,
                    'view_expense'             => true,
                    'view_other_expenses'      => true,
                    'view_expenses_summary'    => true,
                    'create_expenses_voucher'  => true,
                    'publish_expenses_voucher' => true,
                    'create_expenses_credit'   => true,
                    'publish_expenses_credit'  => true,
                    'view_account_lists'       => true,
                    'view_single_account'      => true,
                    'create_account'           => true,
                    'edit_account'             => true,
                    'delete_account'           => true,
                    'view_bank_accounts'       => true,
                    'create_bank_transfer'     => true,
                    'view_journal'             => true,
                    'view_other_journals'      => true,
                    'create_journal'           => true,
                    'view_reports'             => true,
                ];

                break;
        }

        return apply_filters('get_caps_for_role', $caps, $role);
    }

    /**
     * Check if HR current user manager.
     *
     * @return void
     */
    public function isHrCurrentUserManager()
    {

        return true;
    }

    /**
     * Create Customer
     *
     * @return void
     */
    public function createCustomer()
    {
        return current_user_can('create_customer');
    }

    /**
     * User Can Edit Customer.
     *
     * @param mixed $created_by Created By
     *
     * @return void
     */
    public function userCanEditCustomer($created_by = false)
    {
        if (!current_user_can('edit_customer')) {
            return false;
        }

        if (!$created_by) {
            return false;
        }

        $user_id = auth()->user()->id;

        if ($created_by === $user_id) {
            return true;
        }

        if (current_user_can('edit_other_customers')) {
            return true;
        }

        return false;
    }

    /**
     * Current User Can View Single Customer
     *
     * @return void
     */
    public function currentUserCanViewSingleCustomer()
    {
        return current_user_can('view_single_customer');
    }

    /**
     * View Other Customers
     *
     * @return void
     */
    public function viewOtherCustomers()
    {
        return current_user_can('view_other_customers');
    }

    /**
     * Current User Can Delete Customer
     *
     * @param mixed $created_by Created By
     *
     * @return void
     */
    public function currentUserCanDeleteCustomer($created_by = false)
    {
        if (!current_user_can('delete_customer')) {
            return false;
        }

        if (!$created_by) {
            return false;
        }

        $user_id = auth()->user()->id;

        if ($created_by === $user_id) {
            return true;
        }

        if (current_user_can('delete_other_customers')) {
            return true;
        }

        return false;
    }

    /**
     * Create Vendor
     *
     * @return void
     */
    public function createVendor()
    {
        return current_user_can('create_vendor');
    }

    /**
     * Current User Can Edit Vendor
     *
     * @param mixed $created_by Created By
     *
     * @return void
     */
    public function currentUserCanEditVendor($created_by = false)
    {
        if (!current_user_can('edit_vendor')) {
            return false;
        }

        if (!$created_by) {
            return false;
        }

        $user_id = auth()->user()->id;

        if ($created_by === $user_id) {
            return true;
        }

        if (current_user_can('edit_other_vendors')) {
            return true;
        }

        return false;
    }

    /**
     * Current User Can View Single Vendor
     *
     * @return void
     */
    public function currentUserCanViewSingleVendor()
    {
        return current_user_can('view_single_vendor');
    }

    /**
     * View Other Vendors
     *
     * @return void
     */
    public function viewOtherVendors()
    {
        return current_user_can('view_other_vendors');
    }

    /**
     * Current User Can Delete Vender
     *
     * @param mixed $created_by Created By
     *
     * @return void
     */
    public function currentUserCanDeleteVendor($created_by = false)
    {
        if (!current_user_can('delete_vendor')) {
            return false;
        }

        if (!$created_by) {
            return false;
        }

        $user_id = auth()->user()->id;

        if ($created_by === $user_id) {
            return true;
        }

        if (current_user_can('delete_other_vendors')) {
            return true;
        }

        return false;
    }



    /**
     * Removes the non-public AC roles from the editable roles array
     *
     * @param array $all_roles All registered roles
     *
     * @return array
     */
    public function filterEditableRoles($all_roles = [])
    {
        $roles = $this->getRoles();

        foreach ($roles as $ac_role_key => $ac_role) {
            if (isset($ac_role['public']) && false === $ac_role['public']) {
                // Loop through WordPress roles
                foreach (array_keys($all_roles) as $wp_role) {
                    // If keys match, unset
                    if ($wp_role === $ac_role_key) {
                        unset($all_roles[$wp_role]);
                    }
                }
            }
        }

        return $all_roles;
    }
}
