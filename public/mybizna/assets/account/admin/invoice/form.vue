<template>
    <table-edit :path_param="path_param" :model="model">

        <FormKit button_label="Select Customer" id="partner_id" type="recordpicker"
            comp_url="partner/admin/partner/list.vue" :setting="setting.partner_id" v-model="model.partner_id"
            validation="required" />

        <div class="row">
            <div class="col-md-4">
                <span class="underline">From</span>
                <address>
                    <strong>Mybizna, Inc.</strong><br>
                    P.O Box 767 - 00618<br>
                    Nairobi, Kenya<br>
                    Phone: +254 713 034 569<br>
                    Email: info@mybizna.com
                </address>
            </div>
            <div class="col-md-4">
                <span class="underline">To</span>
                <address>
                    <strong>John Doe</strong><br>
                    P.O Box 767 - 00618<br>
                    Nairobi, Kenya<br>
                    Phone: +254 713 034 569<br>
                    Email: info@mybizna.com
                </address>

            </div>
            <div class="col-md-4">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
                <b>Payment Due:</b> 2/22/2014<br>
            </div>
        </div>

        <table class="table m-0 p-0">
            <thead>
                <tr class="bg-slate-100 px-7">
                    <th class="uppercase" scope="col">Title</th>
                    <th class="uppercase" scope="col">Ledger</th>
                    <th class="uppercase" scope="col">Qtry</th>
                    <th class="uppercase" scope="col">Price</th>
                    <th class="uppercase" scope="col">Rates</th>
                    <th class="uppercase" scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="( item, index) in model.items" :key="index">
                    <td>
                        <FormKit id="title" type="text" v-model="item.title" validation="required" />
                    </td>
                    <td>
                        <FormKit id="lerger" type="select" v-model="item.lerger" validation="required" />
                    </td>
                    <td class="w-28">
                        <FormKit id="quantity" type="number" v-model="item.quantity" @blur="addCalculate(rate)"
                            validation="required" min="0" />
                    </td>
                    <td>
                        <FormKit id="price" type="number" v-model="item.price" @blur="addCalculate(rate)"
                            validation="required" min="0" step="0.01" />
                    </td>
                    <td>
                        <span v-for="( rate, rate_index) in item.rates" :key="rate_index"
                            class="badge bg-secondary mr-1">{{ rate.title }}</span>
                        <a class="badge bg-blue-700 text-white cursor-pointer"  @click="addRate(rate)">
                            <i class="fa-solid fa-plus"></i> Add Rate
                        </a>
                    </td>
                    <td class="font-semibold fs-16 text-right">{{ this.$func.money(item.total) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mt-2">
            <a class="btn btn-primary btn-sm cursor-pointer" @click="addRow()">
                <i class="fa-solid fa-plus"></i> Add Row
            </a>
        </div>

        <div class="row mt-3">

            <div class="col-6">
                <p class="lead">Payment Methods:</p>

                <FormKit label="Methods" id="methods" type="select" validation="required" />
                <div class="mb-1"></div>
                <FormKit label="Amount" id="methods" type="number" validation="required" />

                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Payment instructions goes here.
                </p>
            </div>

            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:60%">Subtotal:</th>
                                <td class="text-right font-semibold">{{ this.$func.money(model.total) }}</td>
                            </tr>
                            <tr v-for="( rate, index) in rates" :key="index">
                                <th>{{ rate.title }} ({{ rate.value }}<span v-if="rate.is_percent">%</span>)</th>
                                <td class="text-right font-semibold">{{ this.$func.money(rate.total) }}</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td class="text-right font-semibold">{{ this.$func.money(model.total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-7">
            <div class="col-md-12">
                <FormKit label="Notations" id="description" type="textarea" validation="required" />
            </div>
        </div>

    </table-edit>
</template>

<script>
export default {
    components: {
        TableEdit: window.$func.fetchComponent("components/common/TableEdit.vue")
    },
    data () {
        return {
            id: null,
            path_param: ["account", "invoice"],
            setting: {
                partner_id: {
                    path_param: ["partner", "partner"],
                    fields: ['first_name', 'last_name', 'email'],
                    template: '[first_name] [last_name] - [email]',
                },
            },
            rates: [],
            model: {
                total: 0.00,
                items: [{
                    id: "",
                    title: "",
                    lerger: "",
                    quantity: 1,
                    price: 0.00,
                    rates: [],
                    total: 0.00,
                }],
            },
        };
    },
    methods: {
        addRow () {

            this.model.items.push({
                id: "",
                title: "",
                lerger: "",
                quantity: 1,
                price: 0.00,
                rates: [],
                total: 0.00,
            });

            this.addCalculate();

        },
        addRate () {
            console.log('addRate');
            this.addCalculate();
        },
        addCalculate () {
            var total = 0;

            this.model.items.forEach(item => {

                item.total = item.quantity * item.price;
                total = total + parseFloat(item.total);
            });

            this.model.total = total;
        }
    }
};
</script>
