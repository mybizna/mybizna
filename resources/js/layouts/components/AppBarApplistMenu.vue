<template>
    <div class="text-center">
        <v-menu
            v-model="menu"
            :close-on-content-click="false"
            anchor="bottom"
            right
        >
            <template v-slot:activator="{ props }">
                <v-badge color="success" content="3" v-bind="props">
                    <div class="text-white" v-bind="attrs" v-on="on">
                        <v-icon size="22" icon="fas fa-plus"
                            >mdiCogOutline
                        </v-icon>
                        Apps
                    </div>
                </v-badge>
            </template>

            <v-card min-width="300">
                <v-row>
                    <v-col
                        v-for="(item, index) in menus"
                        :key="index"
                        cols="6"
                        sm="3"
                        md="2"
                    >
                        <image-link
                            :title="item.title"
                            :url="item.url"
                            :icon="item.icon"
                            :class_str="item.class_str"
                        ></image-link>
                    </v-col>

                    <v-col
                        v-for="(item, index) in menuIcons"
                        :key="index"
                        cols="6"
                        sm="3"
                        md="2"
                    >
                        <image-link
                            :title="item.title"
                            :url="item.url"
                            :icon="item.icon"
                            :class_str="item.class_str"
                        ></image-link>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn text @click="menu = false"> Cancel </v-btn>
                </v-card-actions>
            </v-card>
        </v-menu>
    </div>
</template>

<script>
import {
    mdiAccountOutline,
    mdiEmailOutline,
    mdiCheckboxMarkedOutline,
    mdiChatOutline,
    mdiCogOutline,
    mdiCurrencyUsd,
    mdiHelpCircleOutline,
    mdiLogoutVariant,
} from "@mdi/js";

import { computed } from "vue";
import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();

        if (!store.state.system.has_menu) {
            store.dispatch("system/getMenu");
        }

        let menus = computed(function () {
            return store.state.system.menu;
        });

        console.log(menus);

        return {
            menus,
            icons: {
                mdiAccountOutline,
                mdiEmailOutline,
                mdiCheckboxMarkedOutline,
                mdiChatOutline,
                mdiCogOutline,
                mdiCurrencyUsd,
                mdiHelpCircleOutline,
                mdiLogoutVariant,
            },
        };
    },
    data: () => ({
        fav: true,
        menu: false,
        message: false,
        hints: true,
        menuIcons: [
            {
                title: "Account",
                icon: "fas fa-funnel-dollar",
                url: "/account",
                class_str: "text-primary border-primary",
            },
            {
                title: "Expenses",
                icon: "fas fa-money-bill",
                url: "/expense",
                class_str: "text-secondary border-secondary",
            },
            {
                title: "Sales",
                icon: "fas fa-receipt",
                url: "/Sales",
                class_str: "text-warning border-warning",
            },
            {
                title: "Products",
                icon: "fas fa-store",
                url: "/products",
                class_str: "text-danger border-danger",
            },
            {
                title: "Payment",
                icon: "fas fa-file-invoice-dollar",
                url: "/account",
                class_str: "text-black border-black",
            },
            {
                title: "Bill",
                icon: "fas fa-hand-holding-usd",
                url: "/expense",
                class_str: "text-success border-success",
            },
        ]
    }),
};
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
    }
}
</style>
