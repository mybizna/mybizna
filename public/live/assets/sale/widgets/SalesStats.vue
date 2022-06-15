<template>
    <div class="stats section">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <pie-chart v-if="chartPayment.values.length"
                            id="payment"
                            :title="this.$func.__('Payment')"
                            :labels="chartPayment.labels"
                            :colors="chartPayment.colors"
                            :data="chartPayment.values" />
                    </div>
                    <div class="col-sm-4">
                        <pie-chart v-if="chartStatus.values.length"
                            id="status"
                            :title="this.$func.__('Status')"
                            :labels="chartStatus.labels"
                            :colors="chartStatus.colors"
                            :data="chartStatus.values" />
                    </div>
                    <div class="col-sm-4">
                        <div class="chart-block">
                            <h3>{{ this.$func.__('Outstanding') }}</h3>
                            <div class="total"><h2>{{ formatAmount(chartPayment.outstanding) }}</h2></div>
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
        PieChart : window.$func.fetchComponent('components/chart/PieChart.vue')
    },

    data() {
        return {
            chartStatus: {
                colors: ['#208DF8', '#E9485E', '#FF9900', '#2DCB67', '#9c27b0', '#e3ff66' ],
                labels: [],
                values: []
            },
            chartPayment: {
                colors: ['#40c4ff', '#e91e63'],
                labels: [ this.$func.__('Received'), this.$func.__('Outstanding') ],
                values: [],
                outstanding: 0
            }
        };
    },
    emits: {
        // Validate submit event
        "transactions-filter": ({ filter }) => {
           //  this.getSalesChartData(filters);
            return true;
        },
    },

    created() {

        const filters = {};

        if (this.$route.query.start && this.$route.query.end) {
            filters.start_date = this.$route.query.start;
            filters.end_date = this.$route.query.end;
        }

        this.getSalesChartData(filters);
    },

    watch: {
        $route: 'getSalesChartData'
    },

    methods: {
        getSalesChartData(filters = {}) {
            window.axios.get('/transactions/sales/chart-payment', {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(response => {
                this.chartPayment.outstanding = response.data.outstanding;

                this.chartPayment.values.push(
                    response.data.received,
                    response.data.outstanding
                );
            });

            window.axios.get('/transactions/sales/chart-status', {
                params: {
                    start_date: filters.start_date,
                    end_date: filters.end_date
                }
            }).then(response => {
                response.data.forEach(element => {
                    this.chartStatus.labels.push(element.type_name);
                    this.chartStatus.values.push(parseInt(element.sub_total));
                });
            });
        }
    }

};
</script>
