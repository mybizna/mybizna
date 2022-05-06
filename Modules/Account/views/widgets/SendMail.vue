<template>
    <modal
        @close="closeModal"
        :title="'Send Mail'"
        :footer="true"
        :hasForm="true"
        :header="true"
    >
        <template slot="body">
            <div class="form-group row">
                <div class="col-sm-3 col-xs-12 send-mail-to">
                    <label
                        >{{ this.$func.__("To", "erp") }}
                        <span class="required-sign">*</span></label
                    >
                </div>
                <input-tag
                    :placeholder="this.$func.__('Add Emails', 'erp')"
                    v-model="emails"
                    validate="email"
                />
            </div>
            <div class="form-group row">
                <div class="col-sm-3 col-xs-12">
                    <label>{{ this.$func.__("Subject", "erp") }}</label>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <input
                        type="text"
                        v-model="subject"
                        class="form-control form-contro-sm form-field"
                        :placeholder="this.$func.__('Enter Subject Here', 'erp')"
                    />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3 col-xs-12">
                    <label>{{ this.$func.__("Message", "erp") }}</label>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <textarea
                        v-model="message"
                        class="form-control form-contro-sm form-field"
                        :placeholder="this.$func.__('Enter Your Message Here', 'erp')"
                        rows="4"
                    ></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <label
                        >{{ this.$func.__("Attachment", "erp") }}
                        <span class="required-sign">*</span></label
                    >
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="form-check">
                        <label class="form-check-label mb-0">
                            <input
                                class="form-check-input"
                                v-model="attachment"
                                type="checkbox"
                            />
                            <span class="form-check-sign"></span>
                            <span class="field-label">{{
                                this.$func.__("Attach as PDF", "erp")
                            }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template slot="footer">
            <div class="buttons-wrapper text-right">
                <button class="btn btn-default" @click="closeModal">
                    {{ this.$func.__("Cancel", "erp") }}
                </button>
                <button
                    class="btn btn-primary"
                    type="submit"
                    @click.prevent="sendAsMail"
                >
                    {{ this.$func.__("Send", "erp") }}
                </button>
            </div>
        </template>
    </modal>
</template>

<script>

export default {
    components: {
        Modal: window.$func.fetchComponent('components/modal/Modal.vue'),
    },

    props: {
        data: Object,
        type: String,
        userid: [Number, String],
    },

    data() {
        return {
            options: [],
            emails: [],
            subject: "",
            message: "",
            attachment: "",
        };
    },

    created() {
        window.axios.get(`people/${this.userid}`).then((response) => {
            this.emails.push(response.data.email);
        });
    },

    methods: {
        closeModal() {
            this.$root.$emit("close");
        },

        addEmail(newEmail) {
            const email = {
                name: newEmail,
                code:
                    newEmail.substring(0, 2) +
                    Math.floor(Math.random() * 10000000),
            };
            this.emails.push(email);
        },

        sendAsMail() {
            window.axios
                .post(`/transactions/send-pdf/${this.$route.params.id}`, {
                    trn_data: this.data,
                    type: this.type,
                    receiver: this.emails,
                    subject: this.subject,
                    message: this.message,
                    attachment: this.attachment,
                })
                .then(() => {
                    this.showAlert("success", this.$func.__("Mail Sent!", "erp"));
                })
                .catch((error) => {
                    throw error;
                });
        },
    },
};
</script>

<style>
.row .vue-input-tag-wrapper .input-tag {
    background-color: rgba(67, 160, 71, 0.8);
    border: 1px solid #689f38;
    color: #fff;
    display: inline-block;
    font-size: 13px;
    font-weight: 400;
    margin-bottom: 4px;
    margin-right: 4px;
    padding: 3px;
    height: 28px;
    border-radius: 3px;
}

.row .vue-input-tag-wrapper .new-tag {
    height: 34px;
    padding-top: 0 !important;
    box-shadow: none;
}

.row .vue-input-tag-wrapper .input-tag span {
    padding: 0 6px;
}

.row .vue-input-tag-wrapper .input-tag .remove {
    color: rgba(105, 240, 174, 1);
}
.send-mail-to {
    margin-right: 8px;
}
</style>
