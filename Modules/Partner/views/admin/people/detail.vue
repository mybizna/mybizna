<template>
    <div class="mybizna-container">
        <!-- Start .header-section -->
        <UserBasicInfo :userData="resData"></UserBasicInfo>
        <!-- End .header-section -->
        <div class="mybizna-stats mybizna-section">
            <div class="mybizna-panel mybizna-panel-default">
                <div class="mybizna-panel-body">
                    <div class="mybizna-row">
                        <div class="mybizna-col-sm-4">
                            <pie-chart v-if="paymentData.length"
                                id="payment"
                                :title="paymentChart.title"
                                :labels="paymentChart.labels"
                                :colors="paymentChart.colors"
                                :data="paymentData"/>
                        </div>
                        <div class="mybizna-col-sm-4">
                            <pie-chart v-if="statusData.length"
                                id="status"
                                :title="statusChart.title"
                                :labels="statusLabel"
                                :colors="statusChart.colors"
                                :data="statusData"/>
                        </div>
                        <div class="mybizna-col-sm-4">
                            <div class="mybizna-chart-block">
                                <h3>{{ this.$func.__('Outstanding', 'erp') }}</h3>
                                <div class="mybizna-total"><h2>{{ moneyFormat( outstanding ) }}</h2></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <people-transaction :rows.sync="transactions"></people-transaction>
    </div>
</template>

<script>

export default {
    components: {
        UserBasicInfo: window.$func.fetchComponent('components/userinfo/UserBasic.vue'),
        PieChart: window.$func.fetchComponent('components/chart/PieChart.vue'),
        PeopleTransaction: window.$func.fetchComponent('components/people/PeopleTransaction.vue')
    },

    data() {
        return {
            userId : '',
            resData: {},
            userData : {
                id: '',
                name: '-',
                email: '-',
                // 'img_url': erp_acct_var.acct_assets  + '/images/dummy-user.png',
                meta: {
                    company: '-',
                    website: '-',
                    phone: '-',
                    mobile: '-',
                    address: '-'
                }
            },
            url: '',
            paymentChart: {
                title: 'Payment',
                labels: ['Recieved', 'Outstanding'],
                colors: ['#55D8FE', '#FF8373']
            },
            statusChart: {
                title: 'Status',
                colors: ['#208DF8', '#E9485E']
            },

            paymentData: [],
            statusLabel: [],
            statusData: [],
            transactions: [],
            opening_balance: 0,
            people_balance: 0,
            outstanding: 0,
            temp: null,
            req_url: ''
        };
    },

    created() {
        this.url = this.$route.params.route;
        this.userId = this.$route.params.id;
        if (typeof this.url === 'undefined') {
            this.url = this.$route.path.split('/')[1];
        }
        this.fetchItem(this.userId);
        this.getTransactions();
        this.getChartData();
        this.$root.$on('people-transaction-filter', filter => {
            this.filterTransaction(filter);
        });
    },

    watch: {
        transactions(newVal) {
            this.transactions = newVal;
        }
    },

    methods: {
        fetchItem(id) {
            if (this.$route.name === 'VendorDetails') {
                this.req_url = 'vendors';
            } else if (this.$route.name === 'CustomerDetails') {
                this.req_url = 'customers';
            }

            window.axios.get(this.req_url + '/' + id, {
                params: {}
            }).then((response) => {
                this.resData = response.data;
            });
        },

        getTransactions() {

            window.axios.get(this.req_url + '/' + this.userId + '/transactions').then(res => {
                this.transactions = res.data;

                this.transactions.forEach(item => {
                    item.trn_date = this.formatDate(item.trn_date);
                    item.created_at = this.formatDate(item.created_at);
                });

            }).catch(error => {
                throw error;
            });
        },

        filterTransaction(filters = {}) {
            window.axios.get(this.url + '/' + this.userId + '/transactions/filter', {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(res => {
                this.transactions = res.data;
            }).catch(error => {
                throw error;
            });
        },

        formatLineItems() {
            this.transactions.forEach(line => {
                if (line.balance === null && typeof line.balance === 'object') {
                    line.balance = 0;
                }
                line.type = this.formatTrnStatus(line.type);
            });
        },

        getChartData(filters = {}) {
            window.axios.get(`/transactions/people-chart/trn-amount/${this.userId}`, {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(response => {
                this.outstanding = response.data.payable;
                this.paymentData.push(
                    response.data.paid,
                    response.data.payable
                );
            });

            window.axios.get(`/transactions/people-chart/trn-status/${this.userId}`, {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(response => {
                this.temp = response.data;
                response.data.forEach(element => {
                    this.statusLabel.push(element.type_name);
                    this.statusData.push(element.sub_total);
                });
            });
        }
    }
};
</script>

<style >

</style>
