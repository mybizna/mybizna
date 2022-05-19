<template>
    <div id="people-modal">
        <div id="add-customer-modal">
            <div>
                <div>
                    <!-- modal body title -->
                    <ul class="errors" v-if="error_message.length">
                        <li
                            v-for="(error, index) in error_message"
                            :key="index"
                        >
                            * {{ error }}
                        </li>
                    </ul>
                    <!-- end modal body title -->
                    <form
                        action=""
                        method="post"
                        class="edit-customer-modal"
                        @submit.prevent="saveCustomer"
                    >
                        <div>
                            <div class="row">
                                <div class="form-group col-sm-3 mb-0">
                                    <!-- add new people form -->
                                    <upload-image
                                        :showButton="true"
                                        @uploadedImage="uploadPhoto"
                                        :src="peopleFields.photo"
                                    />

                                    <component
                                        v-for="(
                                            component, extIndx
                                        ) in extraFieldsTop"
                                        :key="`top-${extIndx}`"
                                        :is="component"
                                        :people="people"
                                    />
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="first_name"
                                                >{{
                                                    this.$func.__(
                                                        "First Name",
                                                        "erp"
                                                    )
                                                }}
                                                <span class="required-sign"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                v-model="
                                                    peopleFields.first_name
                                                "
                                                id="first_name"
                                                class="form-control form-control-sm form-field"
                                                :placeholder="
                                                    this.$func.__(
                                                        'First Name',
                                                        'erp'
                                                    )
                                                "
                                                required
                                            />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="last_name"
                                                >{{
                                                    this.$func.__(
                                                        "Last Name",
                                                        "erp"
                                                    )
                                                }}
                                                <span class="required-sign"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                v-model="peopleFields.last_name"
                                                id="last_name"
                                                class="form-control form-control-sm form-field"
                                                :placeholder="
                                                    this.$func.__(
                                                        'Last Name',
                                                        'erp'
                                                    )
                                                "
                                                required
                                            />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="email"
                                                >{{
                                                    this.$func.__(
                                                        "Email",
                                                        "erp"
                                                    )
                                                }}
                                                <span class="required-sign"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="email"
                                                @blur="checkEmailExistence"
                                                v-model="peopleFields.email"
                                                id="email"
                                                class="form-control form-control-sm form-field"
                                                placeholder="you@domain.com"
                                                required
                                            />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="phone">{{
                                                this.$func.__("Phone", "erp")
                                            }}</label>
                                            <input
                                                type="tel"
                                                v-model="peopleFields.phone"
                                                id="phone"
                                                class="form-control form-control-sm form-field"
                                                placeholder="(123) 456-789"
                                            />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="company">{{
                                                this.$func.__("Company", "erp")
                                            }}</label>
                                            <input
                                                type="text"
                                                v-model="peopleFields.company"
                                                id="company"
                                                class="form-control form-control-sm form-field"
                                                :placeholder="
                                                    this.$func.__(
                                                        'ABC Corporation',
                                                        'erp'
                                                    )
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <component
                                v-for="(
                                    component, extIndx
                                ) in extraFieldsMiddle"
                                :key="`middle-${extIndx}`"
                                :is="component"
                                :people="people"
                            />

                            <!-- extra fields -->
                            <div class="more-fields" v-if="showMore">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="mobile">{{
                                            this.$func.__("Mobile", "erp")
                                        }}</label>
                                        <input
                                            type="tel"
                                            v-model="peopleFields.mobile"
                                            id="mobile"
                                            class="form-control form-control-sm form-field"
                                        />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="website">{{
                                            this.$func.__("Website", "erp")
                                        }}</label>
                                        <input
                                            type="text"
                                            v-model="peopleFields.website"
                                            id="website"
                                            class="form-control form-control-sm form-field"
                                            placeholder="www.domain.com"
                                        />
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="fax">{{
                                            this.$func.__("Fax", "erp")
                                        }}</label>
                                        <input
                                            type="text"
                                            v-model="peopleFields.fax"
                                            id="fax"
                                            class="form-control form-control-sm form-field"
                                            :placeholder="
                                                this.$func.__(
                                                    'Type here',
                                                    'erp'
                                                )
                                            "
                                        />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="street1">{{
                                            this.$func.__("Street 1", "erp")
                                        }}</label>
                                        <input
                                            type="text"
                                            v-model="peopleFields.street_1"
                                            id="street1"
                                            class="form-control form-control-sm form-field"
                                            :placeholder="
                                                this.$func.__('Street 1', 'erp')
                                            "
                                        />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="street2">{{
                                            this.$func.__("Street 2", "erp")
                                        }}</label>
                                        <input
                                            type="text"
                                            v-model="peopleFields.street_2"
                                            id="street2"
                                            class="form-control form-control-sm form-field"
                                            :placeholder="
                                                this.$func.__('Street 2', 'erp')
                                            "
                                        />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="city">{{
                                            this.$func.__("City", "erp")
                                        }}</label>
                                        <input
                                            type="text"
                                            v-model="peopleFields.city"
                                            id="city"
                                            class="form-control form-control-sm form-field"
                                            :placeholder="
                                                this.$func.__(
                                                    'City/Town',
                                                    'erp'
                                                )
                                            "
                                        />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>{{
                                            this.$func.__("Country", "erp")
                                        }}</label>
                                        <div class="with-multiselect">
                                            <multi-select
                                                v-model="peopleFields.country"
                                                :options="countries"
                                                :multiple="false"
                                                @input="
                                                    getState(
                                                        peopleFields.country
                                                    )
                                                "
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>{{
                                            this.$func.__(
                                                "Province/State",
                                                "erp"
                                            )
                                        }}</label>
                                        <div class="with-multiselect">
                                            <multi-select
                                                v-model="peopleFields.state"
                                                :options="states"
                                                :multiple="false"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="post_code">{{
                                            this.$func.__("Post Code", "erp")
                                        }}</label>
                                        <input
                                            type="text"
                                            v-model="peopleFields.postal_code"
                                            id="post_code"
                                            class="form-control form-control-sm form-field"
                                            :placeholder="
                                                this.$func.__(
                                                    'Post Code',
                                                    'erp'
                                                )
                                            "
                                        />
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="note">{{
                                            this.$func.__("Note", "erp")
                                        }}</label>
                                        <textarea
                                            v-model="peopleFields.notes"
                                            id="note"
                                            cols="30"
                                            rows="4"
                                            class="form-control form-control-sm form-field"
                                            :placeholder="
                                                this.$func.__(
                                                    'Type here',
                                                    'erp'
                                                )
                                            "
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                            <component
                                v-for="(
                                    component, extIndx
                                ) in extraFieldsBottom"
                                :key="`bottom-${extIndx}`"
                                :is="component"
                                :people="people"
                            />
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <label
                                            class="form-check-label mb-0"
                                            for="show_more"
                                        >
                                            <input
                                                class="form-check-input"
                                                name="show_more"
                                                id="show_more"
                                                type="checkbox"
                                                @click="showDetails"
                                            />
                                            <span
                                                class="form-check-sign"
                                            ></span>
                                            <span class="field-label">{{
                                                this.$func.__(
                                                    "Show More",
                                                    "erp"
                                                )
                                            }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-0">
                            <!-- buttons -->
                            <div class="buttons-wrapper text-right">
                                <button
                                    class="btn btn-default modal-close"
                                    @click="$parent.$emit('modal-close')"
                                    type="reset"
                                >
                                    {{ this.$func.__("Cancel", "erp") }}
                                </button>
                                <button
                                    v-if="!people"
                                    class="btn btn-primary"
                                    type="submit"
                                >
                                    {{ this.$func.__("Add New", "erp") }}
                                </button>
                                <button
                                    v-else
                                    class="btn btn-primary"
                                    type="submit"
                                >
                                    {{ this.$func.__("Update", "erp") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/* global this.$mybizna_var */
export default {
    components: {
        UploadImage: window.$func.fetchComponent("components/base/Media.vue"),
        MultiSelect: window.$func.fetchComponent(
            "components/select/MultiSelect.vue"
        ),
    },

    props: {
        people: {
            type: Object,
        },
        title: {
            required: true,
        },
        type: [String],
    },

    data() {
        return {
            peopleFields: {
                id: null,
                first_name: "",
                last_name: "",
                email: "",
                mobile: "",
                company: "",
                phone: "",
                website: "",
                notes: "",
                fax: "",
                street_1: "",
                street_2: "",
                city: "",
                country: "",
                state: "",
                postal_code: "",
                photo_id: null,
                photo:
                    this.$mybizna_var.assets +
                    "/images/mystery-person.png",
            },
            states: [],
            emailExists: false,
            showMore: false,
            customers: [],
            url: "",
            error_message: [],
            countries: [],
            get_states: [],
            extraFieldsTop: [],
            extraFieldsMiddle: [],
            extraFieldsBottom: [],
        };
    },

    created() {
        this.url = this.generateUrl();
        this.getCustomers();
        this.getCountries(() => this.setInputField());
    },

    mounted() {},

    methods: {
        saveCustomer() {
            const peopleFields = [];

            if (!this.checkForm()) {
                return false;
            }

            var self = this;

            if (this.peopleFields.email) {
                if (!this.people) {
                    window.axios
                        .get("/people/check-email", {
                            params: {
                                email: this.peopleFields.email,
                            },
                        })
                        .then((res) => {
                            self.emailExists = res.data;

                            if (res.data) {
                                if (
                                    res.data == "contact" ||
                                    res.data == "company"
                                ) {
                                    swal(
                                        {
                                            title: "",
                                            text: this.$func.__(
                                                "This email already exists in CRM! Do you want to import and update the contact?",
                                                "erp"
                                            ),
                                            type: "info",
                                            showCancelButton: true,
                                            cancelButtonText: this.$func.__(
                                                "Cancel",
                                                "erp"
                                            ),
                                            cancelButtonColor: "#bababa",
                                            confirmButtonText: this.$func.__(
                                                "Import & Update",
                                                "erp"
                                            ),
                                            confirmButtonColor: "#58badb",
                                        },
                                        function (input) {
                                            self.emailExists = false;

                                            if (false !== input) {
                                                self.addPeople(peopleFields);
                                            }
                                        }
                                    );
                                } else {
                                    self.error_message.push(
                                        this.$func.__(
                                            "Email already exists as customer/vendor",
                                            "erp"
                                        )
                                    );
                                    self.emailExists = false;

                                    return false;
                                }
                            } else {
                                self.addPeople(peopleFields);
                            }
                        });
                } else {
                    self.addPeople(peopleFields);
                }
            }
        },

        addPeople(peopleFields) {
            var type = "";
            var url = "";

            if (!this.people) {
                url = this.url;
                type = "post";
            } else {
                url = this.url + "/" + peopleFields.id;
                type = "put";
            }

            var message = type === "post" ? "Created" : "Updated";

            window.axios[type](url, peopleFields).then((response) => {
                this.$root.$emit("peopleUpdate");
                this.resetForm();
                this.showAlert("success", message);
            });
        },

        checkForm() {
            this.error_message = [];

            if (this.error_message.length) {
                return false;
            }

            if (
                this.peopleFields.first_name &&
                this.peopleFields.last_name &&
                this.peopleFields.email
            ) {
                return true;
            }

            if (!this.peopleFields.first_name) {
                this.error_message.push(
                    this.$func.__("First name is required", "erp")
                );
            }

            if (!this.peopleFields.last_name) {
                this.error_message.push(
                    this.$func.__("Last name is required", "erp")
                );
            }

            if (!this.peopleFields.email) {
                this.error_message.push(
                    this.$func.__("Email is required", "erp")
                );
            }

            return false;
        },

        showDetails() {
            this.showMore = !this.showMore;
        },

        getCountries(callBack) {
            window.axios.get("customers/country").then((response) => {
                const country = response.data.country;
                const states = response.data.state;
                for (const x in country) {
                    if (states[x] === undefined) {
                        states[x] = [];
                    }

                    this.countries.push({
                        id: x,
                        name: this.decodeHtml(country[x]),
                        state: states[x],
                    });
                }

                for (const state in states) {
                    for (const x in states[state]) {
                        this.get_states.push({ id: x, name: states[state][x] });
                    }
                }
                if (typeof callBack !== "undefined") {
                    callBack();
                }
            });
        },

        uploadPhoto(image) {
            this.peopleFields.photo_id = image.id;
        },

        getState(country) {
            this.states = [];
            this.peopleFields.state = "";
            for (const state in country.state) {
                this.states.push({ id: state, name: country.state[state] });
            }
        },

        checkEmailExistence() {
            if (this.peopleFields.email) {
                if (!this.people) {
                    window.axios
                        .get("/people/check-email", {
                            params: {
                                email: this.peopleFields.email,
                            },
                        })
                        .then((res) => {
                            this.emailExists = res.data;
                        });
                }
            }
        },

        getCustomers() {
            window.axios.get("/customers").then((response) => {
                this.customers = response.data;
            });
        },

        setInputField() {
            if (this.people) {
                const people = this.people;
                this.peopleFields.id = people.id;
                this.peopleFields.first_name = people.first_name;
                this.peopleFields.last_name = people.last_name;
                this.peopleFields.email = people.email;
                this.peopleFields.mobile = people.mobile;
                this.peopleFields.company = people.company;
                this.peopleFields.phone = people.phone;
                this.peopleFields.website = people.website;
                this.peopleFields.notes = people.notes;
                this.peopleFields.fax = people.fax;
                this.peopleFields.street_1 = people.billing.street_1;
                this.peopleFields.street_2 = people.billing.street_2;
                this.peopleFields.city = people.billing.city;
                this.peopleFields.country = people.billing.country
                    ? this.selectedCountry(people.billing.country)
                    : "";
                this.peopleFields.postal_code = people.billing.postal_code;

                if (people.photo) {
                    this.peopleFields.photo_id = people.photo_id;
                    this.peopleFields.photo = people.photo;
                }

                if (
                    Object.prototype.hasOwnProperty.call(
                        this.peopleFields.country,
                        "id"
                    )
                ) {
                    this.getState(this.peopleFields.country);

                    this.peopleFields.state = this.selectedState(
                        people.billing.state
                    );
                }
            }
        },

        selectedCountry(id) {
            return this.countries.find((country) => country.id === id);
        },

        selectedState(id) {
            return this.get_states.find((item) => item.id === id);
        },

        generateUrl() {
            var url;
            if (this.type) {
                if (this.type === "customer") {
                    url = "customers";
                } else {
                    url = "vendors";
                }
            } else if (this.$route.name.toLowerCase() === "customerdetails") {
                url = "customers";
            } else if (this.$route.name.toLowerCase() === "vendordetails") {
                url = "vendors";
            } else {
                url = this.$route.name.toLowerCase();
            }

            return url;
        },

        resetForm() {
            this.peopleFields.first_name = "";
            this.peopleFields.last_name = "";
            this.peopleFields.email = "";
            this.peopleFields.mobile = "";
            this.peopleFields.company = "";
            this.peopleFields.phone = "";
            this.peopleFields.website = "";
            this.peopleFields.note = "";
            this.peopleFields.fax = "";
            this.peopleFields.street1 = "";
            this.peopleFields.street2 = "";
            this.peopleFields.city = "";
            this.peopleFields.country = "";
            this.peopleFields.state = "";
            this.peopleFields.post_code = "";
        },
    },
};
</script>

<style>
#people-modal .erp-upload-image {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: auto;
    float: left;
    margin-right: 10px;
}
@media (max-width: 767px) {
    #people-modal .erp-upload-image {
        float: none;
        margin-bottom: 10px;
    }
}
#people-modal .erp-upload-image img {
    width: 150px;
}

#people-modal .erp-upload-image button {
    margin-top: 10px;
    width: 150px;
}

#people-modal .more-fields {
    margin-top: 0px;
}

#people-modal .form-check {
    display: inline-block;
    margin-top: 15px;
}
#people-modal .form-check .form-check-label .field-label {
    width: 100px;
    display: block;
}

#people-modal .modal-close .flaticon-close {
    font-size: inherit;
}

#people-modal .errors {
    margin: 0 20px;
    color: #f44336;
}
#people-modal .errors li {
    background: #f3f3f3;
    padding: 2px 10px;
}
</style>
