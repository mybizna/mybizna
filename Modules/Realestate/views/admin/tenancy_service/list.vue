
<template>
  <table-list
    :path_param="path_param"
    :search_fields="search_fields"
    :model="model"
    :table_fields="table_fields"
  ></table-list>
</template>

<script>

export default {
  components: {
    TableList: window.$func.fetchComponent("components/common/TableList.vue")
  },
  data() {
    return {
      path_param: ["realestate", "tenancy_service"],
      model: {
        id: "",
        description: "",
        user_id: "",
        payment_id: "",
        amount: "",
        completed: "",
        successful: ""
      },
      search_fields: [
        {
          type: "text",
          name: "description",
          ope: '',
          styleClasses: "flex col-lg-3 col-sm-12"
        },
        {
          type: "text",
          name: "user_id",
          ope: '',
          styleClasses: "flex col-lg-3 col-sm-12"
        },
        {
          type: "text",
          name: "payment_id",
          ope: '',
          styleClasses: "flex col-lg-3 col-sm-12"
        },
        {
          type: "text",
          name: "amount",
          ope: '',
          styleClasses: "flex col-lg-3 col-sm-12"
        },
        {
          type: "text",
          name: "completed",
          ope: '',
          styleClasses: "flex col-lg-3 col-sm-12"
        },
        {
          type: "text",
          name: "successful",
          ope: '',
          styleClasses: "flex col-lg-3 col-sm-12"
        }
      ],
      table_fields: [
        {
          text: "user_id",
          prop: "[user.name] (user.username) <i>[user.email]</i>"
        },
        {
          text: "description",
          prop: "description"
        },
        {
          text: "payment_id",
          prop: "payment_id"
        },
        {
          text: "amount",
          prop: "amount"
        },
        {
          text: "completed",
          prop: "completed",
          align: "center",
          is_boolean: true
        },
        {
          text: "successful",
          prop: "successful",
          align: "center",
          is_boolean: true
        }
      ],
    };
  }
};
</script>
