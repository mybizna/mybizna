<template>
    <div class="app-money-transfer">
        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Transfer Money", "erp") }}
                    </h2>
                    <router-link
                        class="mybizna-btn btn--primary"
                        :to="{ name: 'NewTransfer' }"
                        >{{ this.$func.__("Add new", "erp") }}</router-link
                    >
                </div>
            </div>
        </div>
        <!-- End .header-section -->
        <list-table
            tableClass="mybizna-table table-striped widefat table2 money-transfer-list"
            action-column="actions"
            :columns="columns"
            :rows="transfer_list"
        >
            <template slot="voucher" slot-scope="data">
                <strong>
                    <router-link
                        :to="{
                            name: 'SingleTransfer',
                            params: { id: data.row.id },
                        }"
                    >
                        #{{ data.row.voucher }}
                    </router-link>
                </strong>
            </template>
        </list-table>
    </div>
</template>

<script>
export default {
    components: {
        ListTable: window.$func.fetchComponent("components/list-table/ListTable.vue"),
    },

    data() {
        return {
            transferFrom: { balance: 0 },
            transferTo: { balance: 0 },
            accounts: [],
            fa: [],
            ta: [],
            transferdate: erp_acct_var.current_date /* global erp_acct_var */,
            particulars: "",
            amount: "",
            money_transfer: false,
            transfer_list: [],
            columns: {
                voucher: {
                    label: this.$func.__("Voucher No", "erp"),
                    isColPrimary: true,
                },
                ac_from: { label: this.$func.__("Account From", "erp") },
                amount: { label: this.$func.__("Amount", "erp") },
                ac_to: { label: this.$func.__("Account To", "erp") },
            },
        };
    },

    created() {
        this.get_transfer_list();
    },

    methods: {
        get_transfer_list() {
            window.axios
                .get("/accounts/transfers/list")
                .then((res) => {
                    this.transfer_list = res.data;
                })
                .catch((error) => {
                    throw error;
                });
        },
    },
};
</script>

<style>
.app-money-transfer
    .table-container {
        width: 600px;
    }

    .app-money-transfer .check-column {
        padding: 20px !important;
    }

    @media (min-width: 783px) {
        .app-money-transfer .actions {
            text-align: right;
        }
        .app-money-transfer .col--actions {
            float: right !important;
        }
        .app-money-transfer .row-actions {
            text-align: right !important;
        }
        .app-money-transfer .ac_to {
            text-align: left !important;
        }
    }
}
</style>
