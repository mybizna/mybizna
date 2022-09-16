<template>

    <div class="dropdown">
        <a id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
            class="inline-block p-1 h-7 w-7 text-center rounded-full hover:border hover:bg-blue-100">
            <i class="fas fa-ellipsis-v text-primary"></i>
        </a>
        <ul class="dropdown-menu m-0 p-0 -mt-9" aria-labelledby="dropdownMenuButton1">
            <template :key="index" v-for="(dropdown_menu, index) in dropdown_menu_list">

                <li v-if="dropdown_menu.title == 'separator'">
                    <hr class="dropdown-divider">
                </li>
                <li v-else>
                    <a class="dropdown-item" :href="dropdown_menu.link" :alt="dropdown_menu.title">
                        {{ dropdown_menu.title }}
                    </a>
                </li>

            </template>
        </ul>
    </div>

</template>

<script>
export default {
    props: {
        pitem: Object,
        dropdown_menu_list: Array,
        field_list: Array,
    },
    created () {
        this.prepareMenuLinks();
    },
    data () {
        return {
            generated_url: "",
            dropdown_menu: [],
        };
    },
    methods: {
        prepareMenuLinks () {
            var t = this;

            t.dropdown_menu_list.forEach(function (dropdown_menu_single) {
                var generated_url = "";
                var url_obj = "";

                if (dropdown_menu_single.param && dropdown_menu_single.param.length) {
                    var param_list = dropdown_menu_single.param;
                    var param = {};

                    param_list.forEach(function (param_single) {
                        param[param_single] = t.pitem[param_single];
                    });

                    url_obj = t.$router.resolve({
                        name: dropdown_menu_single.name,
                        params: param,
                    });

                    console.log('url_obj');
                    console.log(url_obj);

                    console.log('param');
                    console.log(param);

                    dropdown_menu_single["link"] = url_obj.href;
                } else {
                    url_obj = t.$router.resolve({
                        name: dropdown_menu_single.name,
                    });

                    dropdown_menu_single["link"] = url_obj.href;
                }

                t.dropdown_menu = dropdown_menu_single;
            });

            console.log('t.dropdown_menu_list');
            console.log(t.dropdown_menu_list);
        },
    },
};
</script>
