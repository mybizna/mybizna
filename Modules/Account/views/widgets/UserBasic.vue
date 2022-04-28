<template>
    <div class="mybizna-panel mybizna-panel-default mt-20">
        <div class="mybizna-panel-body mybizna-customer-panel">
            <people-modal
                :people="userData"
                :title="title"
                v-if="showModal"
            ></people-modal>
            <!-- edit customers info trigger -->
            <span
                class="edit-badge"
                data-toggle="mybizna-modal"
                data-target="mybizna-edit-customer-modal"
            >
                <i class="flaticon-edit" @click="showModal = true"></i>
            </span>
            <div class="mybizna-row">
                <div
                    class="mybizna-col-lg-3 mybizna-col-md-4 mybizna-col-sm-4 mybizna-col-xs-12"
                >
                    <div class="customer-identity">
                        <img :src="user.photo" :alt="user.name" />
                        <div class="">
                            <h3>{{ user.first_name }} {{ user.last_name }}</h3>
                            <span>{{ user.email }}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="mybizna-col-lg-9 mybizna-col-md-8 mybizna-col-sm-8 mybizna-col-xs-12"
                >
                    <ul class="customer-meta">
                        <li>
                            <strong>{{ window.$func.__("Phone", "erp") }}:</strong>
                            <span>{{ user.phone }}</span>
                        </li>
                        <li>
                            <strong>{{ window.$func.__("Mobile", "erp") }}:</strong>
                            <span>{{ user.mobile }}</span>
                        </li>
                        <li>
                            <strong>{{ window.$func.__("Website", "erp") }}:</strong>
                            <span>{{ user.website }}</span>
                        </li>
                        <li>
                            <strong>{{ window.$func.__("Fax", "erp") }}:</strong>
                            <span>{{ user.fax }}</span>
                        </li>
                        <li>
                            <strong>{{ window.$func.__("Address", "erp") }}:</strong>
                            <span v-if="address">{{ address }}</span>
                        </li>

                        <component
                            v-for="(component, index) in userMeta"
                            :key="index"
                            :is="component"
                            :peopleId="$route.params.id"
                            :peopleType="title"
                        />
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PeopleModal from "assets/partner/widgets/PeopleModal.vue";

export default {
    components: {
        PeopleModal,
    },

    props: {
        userData: {
            type: Object,
            required: true,
            default: () => {
                return {
                    id: "",
                    name: "Full Name",
                    email: "email@mail.com",
                    photo:
                        erp_acct_var.acct_assets +
                        "/images/dummy-user.png" /* global erp_acct_var */,
                    meta: {
                        phone: "+ 88101230123",
                        mobile: "+ 999999999",
                        website: "www.website.com",
                        fax: "+99898989898",
                        address: "House#1005, Block#B, Avenue#9, Mirpur DOHS",
                    },
                };
            },
        },
    },

    data() {
        return {
            showModal: false,
            title: "",
            userMeta: window.acct.hooks.applyFilters("acctPeopleMeta", []),
        };
    },

    computed: {
        user() {
            return this.userData;
        },

        address() {
            let address = [];

            if (this.userData.billing) {
                let keys = [
                    "street_1",
                    "street_2",
                    "city",
                    "state_name",
                    "postal_code",
                    "country_name",
                ];

                keys.forEach((key) => {
                    if (this.userData.billing[key]) {
                        address.push(this.userData.billing[key]);
                    }
                });
            }

            return address.join(", ");
        },
    },

    methods: {
        camelCase(str) {
            return str
                .toLowerCase()
                .replace(/(?:(^.)|(\s+.))/g, function (match) {
                    return match.charAt(match.length - 1).toUpperCase();
                });
        },
    },

    created() {
        this.title =
            this.$route.name.toLowerCase() === "customerdetails"
                ? "customer"
                : "vendor";

        this.$on("modal-close", function () {
            this.showModal = false;
        });
        var self = this;
        this.$root.$on("peopleUpdate", function () {
            self.showModal = false;
            self.$parent.fetchItem(self.$route.params.id);
        });
    },
};
</script>

<style>
.customer-identity img {
    width: 100px;
    border-radius: 50%;
}

.edit-badge {
    position: absolute;
    right: 20px;
    bottom: 10px;
}
</style>
