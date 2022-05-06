<template>
    <div class="stats section">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <pie-chart v-if="chartExpense.values.length"
                                   id="payment"
                                   :title= "this.$func.__('Payment', 'erp')"
                                   :labels="chartExpense.labels"
                                   :colors="chartExpense.colors"
                                   :data="chartExpense.values" />
                    </div>
                    <div class="col-sm-4">
                        <pie-chart v-if="chartStatus.values.length"
                                   id="status"
                                   :title="this.$func.__('Status', 'erp')"
                                   sign=""
                                   :labels="chartStatus.labels"
                                   :colors="chartStatus.colors"
                                   :data="chartStatus.values" />
                    </div>
                    <div class="col-sm-4">
                        <div class="chart-block">
                            <h3>{{ this.$func.__('Outstanding', 'erp') }}</h3>
                            <div class="total"><h2>{{ formatAmount(chartExpense.outstanding) }}</h2></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    components: {
        PieChart: window.$func.fetchComponent('components/chart/PieChart.vue')
    },

    data() {
        return {
            chartStatus: {
                colors: ['#208DF8', '#E9485E', '#FF9900', '#2DCB67', '#9c27b0'],
                labels: [],
                values: []
            },
            chartExpense: {
                colors: ['#40c4ff', '#e91e63'],
                labels: [ this.$func.__('Paid', 'erp'), this.$func.__('Payable', 'erp') ],
                values: [],
                outstanding: 0
            }
        };
    },
    emits: {
        // Validate submit event
        'transactions-filter': () => {
            //this.getExpenseChartData(filters);
            return true;
        },
    },


    created() {

        const filters = {};

        if (this.$route.query.start && this.$route.query.end) {
            filters.start_date = this.$route.query.start;
            filters.end_date = this.$route.query.end;
        }

        this.getExpenseChartData(filters);
    },

    watch: {
        $route: 'getExpenseChartData'
    },

    methods: {
        getExpenseChartData(filters = {}) {
            window.axios.get('/transactions/expense/chart-expense', {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(response => {
                this.chartExpense.outstanding = response.data.payable;

                this.chartExpense.values.push(
                    response.data.paid,
                    response.data.payable
                );
            });

            window.axios.get('/transactions/expense/chart-status', {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(response => {
                response.data.forEach(element => {
                    if (typeof element === 'object' && element !== null) {
                        this.chartStatus.labels.push(element.type_name);
                        this.chartStatus.values.push(parseInt(element.sub_total));
                    }
                });
            });
        }
    }

};
</script>

<style scoped>

</style>
