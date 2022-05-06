<template>
    <div class="panel panel-default mt-20">
        <div class="panel-body customer-panel">
            <people-modal
                :people="userData"
                :title="title"
                v-if="showModal"
            ></people-modal>
            <!-- edit customers info trigger -->
            <span
                class="edit-badge"
                data-toggle="modal"
                data-target="edit-customer-modal"
            >
                <i class="flaticon-edit" @click="showModal = true"></i>
            </span>
            <div class="row">
                <div
                    class="col-lg-3 col-md-4 col-sm-4 "
                >
                    <div class="customer-identity">
                        <img :src="user.photo" :alt="user.name" />
                        <div >
                            <h3>{{ user.first_name }} {{ user.last_name }}</h3>
                            <span>{{ user.email }}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="col-lg-9 col-md-8 col-sm-8 "
                >
                    <ul class="customer-meta">
                        <li>
                            <strong
                                >{{ this.$func.__("Phone", "erp") }}:</strong
                            >
                            <span>{{ user.phone }}</span>
                        </li>
                        <li>
                            <strong
                                >{{ this.$func.__("Mobile", "erp") }}:</strong
                            >
                            <span>{{ user.mobile }}</span>
                        </li>
                        <li>
                            <strong
                                >{{ this.$func.__("Website", "erp") }}:</strong
                            >
                            <span>{{ user.website }}</span>
                        </li>
                        <li>
                            <strong>{{ this.$func.__("Fax", "erp") }}:</strong>
                            <span>{{ user.fax }}</span>
                        </li>
                        <li>
                            <strong
                                >{{ this.$func.__("Address", "erp") }}:</strong
                            >
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
export default {
    components: {
        PeopleModal: window.$func.fetchComponent(
            "partner/widgets/PeopleModal.vue"
        ),
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
                        this.$erp_acct_var.acct_assets +
                        "/images/dummy-user.png" /* global this.$erp_acct_var */,
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
            userMeta: [],
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
    emits: {
        // Validate submit event
        "modal-close": () => {
            this.showModal = false;
            return true;
        },
        peopleUpdate: () => {
            this.showModal = false;
            this.$parent.fetchItem(self.$route.params.id);
            return true;
        },
    },
    created() {
        this.title =
            this.$route.name.toLowerCase() === "customerdetails"
                ? "customer"
                : "vendor";

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
