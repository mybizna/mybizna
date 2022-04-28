<template>
    <form enctype="multipart/form-data" novalidate>
        <div class="attachment-placeholder">
            {{ this.$func.__("To attach", "erp") }}
            <input
                type="file"
                id="attachment"
                multiple
                accept="image/*,.jpg,.png,.doc,.pdf"
                :name="uploadFieldName"
                :disabled="isSaving"
                @change="filesChange($event)"
                class="display-none"
            />
            <label for="attachment">{{ this.$func.__("Select files", "erp") }}</label>
            {{ this.$func.__("from your computer", "erp") }}
            <span v-if="isSaving" class="upload-count">
                ({{ this.$func.__("uploading", "erp") }} {{ fileCount }}
                {{ this.$func.__("file(s)", "erp") }} ...)</span
            >
            <span v-if="isUploaded" class="upload-count">
                ({{ this.$func.__("uploaded", "erp") }} {{ fileCount }}
                {{ this.$func.__("file(s)", "erp") }} ...)</span
            >
        </div>
    </form>
</template>

<script>
const STATUS_INITIAL = 0;
const STATUS_SAVING = 1;
const STATUS_SUCCESS = 2;
const STATUS_FAILED = 3;

export default {
    data() {
        return {
            fileCount: 0,
            isUploaded: false,
            uploadedFiles: [],
            uploadError: null,
            currentStatus: null,
            uploadFieldName: "attachments[]",
        };
    },

    props: {
        value: {
            type: Array,
        },

        url: {
            type: String,
            required: true,
        },
    },

    watch: {
        value(newVal) {
            this.uploadedFiles = this.value;

            if (!newVal.length) {
                this.fileCount = 0;
                this.isUploaded = false;
            }
        },
    },

    computed: {
        isInitial() {
            return this.currentStatus === STATUS_INITIAL;
        },

        isSaving() {
            return this.currentStatus === STATUS_SAVING;
        },

        isSuccess() {
            return this.currentStatus === STATUS_SUCCESS;
        },

        isFailed() {
            return this.currentStatus === STATUS_FAILED;
        },
    },
    methods: {
        reset() {
            this.currentStatus = STATUS_INITIAL;
            this.uploadedFiles = [];
            this.uploadError = null;
        },

        filesChange(event) {
            const formData = new FormData();

            const fieldName = event.target.name;
            const fileList = event.target.files;

            if (!fileList.length) return;

            this.currentStatus = STATUS_SAVING;
            this.fileCount = fileList.length;

            // append the files to FormData
            Array.from(Array(fileList.length).keys()).map((x) => {
                formData.append(fieldName, fileList[x], fileList[x].name);
            });

            this.upload(formData);
        },

        upload(formData) {
            /* global erp_acct_var */
            const BASE_URL = erp_acct_var.site_url;

            const url = `${BASE_URL}/wp-json/erp/v1/accounting/v1${this.url}`;

            return HTTP.post(url, formData).then((res) => {
                res.data.map((img) => {
                    this.uploadedFiles.push(img.url);
                });

                this.$emit("input", this.uploadedFiles);

                this.currentStatus = STATUS_SUCCESS;
                this.isUploaded = true;
            });
        },
    },

    mounted() {
        this.reset();
    },
};
</script>

<style>
.upload-count {
    color: #f44336;
}

.attachment-container .attachment-placeholder {
    max-width: 396px;
}
</style>
