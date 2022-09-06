<template>
    <table-edit :path_param="path_param" :model="model" passed_form_url="invoice/savedata">

        <div class="row mb-2">
            <div class="col-sm-6">
                <FormKit id="title" type="text" v-model="model.title" validation="required"
                    inner-class="$reset formkit-inner" wrapper-class="$reset formkit-wrapper" input-class="h-10" />
            </div>
            <div class="col-sm-6">
                <FormKit button_label="Select Customer" id="partner_id" type="recordpicker"
                    comp_url="partner/admin/partner/list.vue" :setting="setting.partner_id" v-model="model.partner_id"
                    validation="required" inner-class="$reset formkit-inner" wrapper-class="$reset formkit-wrapper" />
            </div>

        </div>

        <div v-if="has_partner" class="invoice-form p-1 border border-dotted border-dashed border-green-600 rounded">
            <div class="row">
                <div class="col-md-4">
                    <span class="underline">From</span>
                    <address>
                        <strong>{{ company.name }} </strong><br>
                        {{ company.address }} {{ company.postal_code }}<br>
                        {{ company.city }}, {{ company.country }}<br>
                        Phone: {{ company.phone }} &nbsp; {{ company.mobile }}<br>
                        Email: {{ company.email }}
                    </address>
                </div>
                <div class="col-md-4">
                    <span class="underline">To</span>
                    <address v-if="partner">
                        <strong>{{ partner.first_name }} {{ partner.last_name }}</strong><br>
                        <strong>{{ partner.company }} </strong><br>
                        {{ partner.address }} {{ partner.postal_code }}<br>
                        {{ partner.city }}, {{ partner.country }}<br>
                        Phone: {{ partner.phone }} &nbsp; {{ partner.mobile }}<br>
                        Email: {{ partner.email }}
                    </address>

                </div>
                <div class="col-md-4">
                    <div
                        :class="model.status == 'paid' ? 'bg-green' : (model.status == 'draft' ? 'bg-grey' : 'bg-red')">
                        <h3 class="text-center p-2 uppercase font-semibold text-white"> {{ model.status }} </h3>
                    </div>
                    <b v-if="invoice.date_created">Invoice #{{ invoice.date_created }}</b>
                    <b v-else>Invoice #{{ invoice.id }}</b>
                    <br>
                    <br>
                    <b>Payment Due:</b> {{ timestamp }}<br>
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
                            <FormKit id="ledger_id" type="select" v-model="item.ledger_id" :options="ledgers"
                                validation="required" />
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
                            <span v-for="( item_rate, rate_index) in item.rates" :key="rate_index"
                                class="badge bg-secondary mr-1">{{ item_rate.title }} ({{ item_rate.value }}<span
                                    v-if="item_rate.is_percent">%</span>)</span>
                            <a class="badge bg-blue-700 text-white cursor-pointer" data-bs-toggle="modal"
                                :data-bs-target="'#' + 'Modal' + index">
                                <i class="fa-solid fa-plus"></i> Add Rate
                            </a>

                            <div class="modal fade" :id="'Modal' + index" tabindex="-1"
                                :aria-labelledby="index + 'ModalLabel'" aria-hidden="true">
                                <div class="modal-dialog ">
                                    <div class="modal-content shadow-2xl shadow-indigo-500/50">
                                        <div class="modal-header p-2">
                                            <h5 class="modal-title font-semibold" :id="index + 'ModalLabel'">Select
                                                Rate</h5>
                                            <button type="button" class="" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa-solid fa-circle-xmark text-2xl	text-red"></i>
                                            </button>
                                        </div>

                                        <div class="modal-body p-0">
                                            <table class="table m-0 p-0">
                                                <thead>
                                                    <tr class="bg-slate-100 px-7">
                                                        <th class="uppercase" scope="col"></th>
                                                        <th class="uppercase" scope="col">Title</th>
                                                        <th class="uppercase" scope="col">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="( rate, r_index) in rates" :key="r_index">
                                                        <td>
                                                            <a v-if="item.rate_ids.includes(rate.id)"
                                                                class="btn btn-danger btn-sm">Remove</a>
                                                            <a v-else class="btn btn-primary btn-sm"
                                                                @click="addRate(index, item, rate)">Add</a>
                                                        </td>
                                                        <td>
                                                            {{ rate.title }}
                                                        </td>
                                                        <td>
                                                            {{ rate.value }} <span v-if="rate.is_percent">%</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                    <div>
                        <ul class="nav nav-tabs" id="myPayment" role="tablist">
                            <li v-for="(gateway, g_index) in model.gateways" v-bind:key="g_index" class="nav-item"
                                role="presentation">
                                <button :class="!g_index ? 'nav-link active' : 'nav-link'" :id="gateway.slug + '-tab'"
                                    data-bs-toggle="tab" :data-bs-target="'#' + gateway.slug" type="button" role="tab"
                                    :aria-controls="gateway.slug" :aria-selected="!g_index ? 'true' : 'false'">
                                    <i v-if="gateway.paid_amount > 0" class="fas fa-check-circle"></i>
                                    {{
                                            gateway.title
                                    }}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myPaymentContent">
                            <div v-for="(gateway, g_index) in model.gateways" v-bind:key="g_index"
                                :class="!g_index ? 'tab-pane fade show active' : 'tab-pane fade'" :id="gateway.slug"
                                role="tabpanel" :aria-labelledby="gateway.slug + '-tab'">
                                <div class="p-2">
                                    <FormKit label="Amount" id="amount" type="number" validation="required"
                                        v-model="gateway.paid_amount" @keyup="calculateTotal" />
                                    <template v-if="gateway.slug != 'cash'">
                                        <FormKit label="Reference" id="reference" type="text"
                                            v-model="gateway.reference" />
                                        <FormKit label="Others" id="others" type="text" v-model="gateway.others" />
                                    </template>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        {{ gateway.instruction }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:60%">Subtotal:</th>
                                    <td class="text-right font-semibold">{{ this.$func.money(model.subtotal) }}</td>
                                </tr>
                                <template v-for="( rate, index) in rates" :key="index">
                                    <tr v-if="rate.total > 0 || rate.total < 0">
                                        <th>{{ rate.title }} (<span
                                                v-if="rate.method == '-' || rate.method == '-%'">-</span>{{ rate.value
                                                }}<span v-if="rate.method == '-%' || rate.method == '+%'">%</span>)
                                        </th>
                                        <td class="text-right font-semibold">{{ this.$func.money(rate.total) }}</td>
                                    </tr>
                                </template>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right font-semibold">{{ this.$func.money(model.total) }}</td>
                                </tr>

                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th colspan="2">Paid:</th>
                                </tr>
                                <template v-for="(gateway, g_index) in model.gateways" v-bind:key="g_index">
                                    <tr v-if="gateway.paid_amount > 0">
                                        <th>{{ gateway.title }} on Now:</th>
                                        <td class="text-right font-semibold">{{ this.$func.money(gateway.paid_amount) }}
                                            {{ gateway.paid_amount }}
                                        </td>
                                    </tr>
                                </template>
                                <tr v-if="model.balance > 0" class="bg-red-200">
                                    <th>Balance:</th>
                                    <td class="text-right font-semibold">{{ model.balance }}
                                    </td>
                                </tr>
                                <tr v-else-if="model.balance < 0" class="bg-green-200">
                                    <th>OverPayment:</th>
                                    <td class="text-right font-semibold">{{ Math.abs(model.balance) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="row mt-7">
                <div class="col-md-12">
                    <FormKit label="Notations" id="description" type="textarea" validation="required"
                        v-model="model.notation" />
                </div>
            </div>

        </div>
        <div v-else class="no-partner">
            <div class=" text-center border-dashed p-5 rounded border border-red-600">
                <span class="fa-stack text-red-400 " style="vertical-align: top; font-size:36px;">
                    <i class="far fa-circle fa-stack-2x"></i>
                    <i class="fas fa-file-alt fa-stack-1x"></i>
                </span>
                <h2 class="text-red-600">No Partner Selected</h2>
                <p class=" text-red-400">All invoices should have partner selected first. Kindly select the parner.</p>
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
            timestamp: "",
            path_param: ["account", "invoice"],
            setting: {
                partner_id: {
                    path_param: ["partner", "partner"],
                    fields: ['first_name', 'last_name', 'email'],
                    template: '[first_name] [last_name] - [email]',
                },
            },
            invoice: {},
            rates: [],
            ledgers: [],
            partner: {},
            has_partner: false,
            company: {
                name: "Mybizna, Inc.",
                address: "P.O Box 767 - 00618",
                city: "Nairobi",
                country: "Kenya",
                phone: "+254 713 034 569",
                email: "info@mybizna.com",
            },
            model: {
                partner_id: '',
                total: 0.00,
                subtotal: 0.00,
                gateways: [],
                items: [{
                    id: "",
                    title: "",
                    ledger_id: "",
                    quantity: 1,
                    price: 0.00,
                    rates: [],
                    rate_ids: [],
                    total: 0.00,
                }],
                title: '',
                rates_used: [],
                paid_amount: 0.00,
                balance: 0.00,
                notation: '',
                status: 'draft',
            },
        };
    },
    updated () {
        var t = this;

        this.invoice = {
            id: 'New',
            date_created: '',
        };

        if (Object.prototype.hasOwnProperty.call(t.$router, "params") && Object.prototype.hasOwnProperty.call(t.$router.params, "id")) {
            alert(t.$router.params.id);
        }


        setInterval(function () {
            t.getNow();
        }, 1000);

        this.fetchData();
    },
    watch: {
        // whenever question changes, this function will run
        'model.partner_id' (newQuestion, oldQuestion) {

            console.log(this.model);

            this.has_partner = true;

            this.fetchData();
        },
    },
    methods: {
        getNow: function () {
            const today = new Date();
            const date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            const dateTime = date + ' ' + time;
            this.timestamp = dateTime;
        },
        calculateTotal () {
            var paid_amount = 0.00;

            this.model.gateways.forEach(gateway => {
                console.log(parseFloat(paid_amount));
                console.log(parseFloat(gateway.paid_amount));
                paid_amount = parseFloat(paid_amount) + parseFloat(gateway.paid_amount);
            });

            this.model.paid_amount = paid_amount;

            this.model.balance = this.model.total - this.model.paid_amount;

            if (paid_amount > 0) {
                this.model.status = 'pending';
            } else {
                this.model.status = 'draft';
            }

            if (this.model.balance <= 0) {
                this.model.status = 'paid';
            }

        },

        fetchData () {

            var comp_url = 'invoice/fetchdata/';

            const getdata = async (t) => {

                await window.axios.get(comp_url, { params: { partner_id: this.model.partner_id } })
                    .then(
                        response => {

                            t.model.gateways = response.data.gateways;
                            t.rates = response.data.rates;
                            t.ledgers = response.data.ledgers;
                            t.partner = response.data.partner;

                            t.model.gateways.forEach(gateway => {
                                gateway.reference = '';
                                gateway.others = '';
                                gateway.paid_amount = 0.00;
                            });

                            t.rates.sort(function (a, b) { return a.ordering - b.ordering; });
                        });
            };

            getdata(this);
        },

        addRow () {

            this.model.items.push({
                id: "",
                title: "",
                ledger_id: "",
                quantity: 1,
                price: 0.00,
                rates: [],
                rate_ids: [],
                total: 0.00,
            });

            this.addCalculate();

        },
        addRate (r_index, item, rate) {
            window.$Modal.getOrCreateInstance(document.getElementById('Modal' + r_index)).hide()

            item.rates.push(rate);
            item.rate_ids.push(rate.id);
            this.model.rates_used.push(rate.id);

            item.rates.sort(function (a, b) { return a.ordering - b.ordering; });
            this.model.rates_used = [...new Set(this.model.rates_used)];

            this.addCalculate();
        },
        addCalculate () {
            this.model.total = 0;
            this.model.subtotal = 0;

            this.rates.forEach(main_rate => {
                main_rate.total = 0.00;
            });

            this.model.items.forEach(item => {
                item.total = item.quantity * item.price;

                this.model.subtotal = this.model.subtotal + parseFloat(item.total);

                item.rates.forEach(rate => {
                    var new_val = rate.value;
                    var operation = rate.method;

                    if (new_val != 0) {
                        if (operation == '-') {
                            new_val = -1 * new_val;
                        } else if (operation == '-%') {
                            new_val = -1 * item.total * new_val / 100;
                        } else if (operation == '+%') {
                            new_val = item.total * new_val / 100;
                        }
                    }

                    this.rates.forEach(main_rate => {
                        //main_rate.total = 0.00;
                        if (main_rate.id === rate.id) {
                            console.log(main_rate.id + '' + rate.id);
                            main_rate.total = (Object.prototype.hasOwnProperty.call(main_rate, "total"))
                                ? main_rate.total + new_val
                                : new_val;
                        }
                    });

                    item.total = item.total + new_val;

                });

                this.model.total = this.model.total + parseFloat(item.total);
            });

        }
    }
};
</script>
