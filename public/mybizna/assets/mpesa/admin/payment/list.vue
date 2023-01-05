
<template>
    <table-list title="Mpesa Payment" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>


<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["mpesa", "payment"],
            model: {
                id: "",
                trans_type: "",
                trans_id: "",
                trans_time: "",
                trans_amount: "",
                business_short_code: "",
                bill_ref_number: "",
                invoice_number: "",
                org_account: "",
                third_party_id: "",
                msisdn: "",
                first_name: "",
                middle_name: "",
                last_name: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "first_name", label: "First Name", ope: "", },
                { type: "text", name: "middle_name", label: "Middle Name", ope: "", },
                { type: "text", name: "last_name", label: "Last Name", ope: "", },
                { type: "text", name: "trans_type", label: "Trans Type", ope: "", },
                { type: "text", name: "trans_id", label: "Trans Id", ope: "", },
                { type: "text", name: "bill_ref_number", label: "Bill Ref Number", ope: "", },
                { type: "text", name: "invoice_number", label: "Invoice Number", ope: "", },
                { type: "text", name: "published", label: "Published", ope: "", },
            ],
            table_fields: [
                { text: "First Name", prop: "first_name", name: "first_name", },
                { text: "Middle Name", prop: "middle_name", name: "middle_name", },
                { text: "Last Name", prop: "last_name", name: "last_name", },
                { text: "Trans Type", prop: "trans_type", name: "trans_type", },
                { text: "Trans Id", prop: "trans_id", name: "trans_id", },
                { text: "Bill Ref Number", prop: "bill_ref_number", name: "bill_ref_number", },
                { text: "Invoice Number", prop: "invoice_number", name: "invoice_number", },
                { text: "Published", prop: "published", name: "published", },
            ],
        };
    }
};
</script>
