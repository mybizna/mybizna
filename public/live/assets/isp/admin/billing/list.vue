<template>
    <table-list
        title="Isp Billing"
        :path_param="path_param"
        :search_fields="search_fields"
        :model="model"
        :table_fields="table_fields"
    ></table-list>
</template>

<script>
export default {
    components: {
        TableList: window.$func.fetchComponent(
            "components/common/TableList.vue"
        ),
    },
    data() {
        return {
            path_param: ["isp", "billing"],
            model: {
                id: "",
                description: "",
                user_id: "",
                payment_id: "",
                amount: "",
                completed: "",
                successful: "",
            },
            search_fields: [
                {
                    type: "text",
                    name: "description",
                    label: "Description",
                    ope: "",
                },
                {
                    type: "text",
                    name: "user_id",
                    label: "User Id",
                    ope: "",
                },
                {
                    type: "text",
                    name: "completed",
                    label: "Completed",
                    ope: "",
                },
                {
                    type: "text",
                    name: "successful",
                    label: "Successful",
                    ope: "",
                },
                 {
                    type: "text",
                    name: "limit",
                    label: "limit",
                    ope: "",
                },
            ],
            table_fields: [
                {
                    text: "user_id",
                    prop: "[user.name] (user.username) <i>[user.email]</i>",
                },
                {
                    text: "description",
                    prop: "description",
                },
                {
                    text: "payment_id",
                    prop: "payment_id",
                },
                {
                    text: "amount",
                    prop: "amount",
                },
                {
                    text: "completed",
                    prop: "completed",
                    align: "center",
                    is_boolean: true,
                },
                {
                    text: "successful",
                    prop: "successful",
                    align: "center",
                    is_boolean: true,
                },
            ],
        };
    },
};
</script>
