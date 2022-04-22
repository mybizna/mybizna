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
                <v-list>
                    <v-list-item
                        prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
                        title="John Leider"
                        subtitle="Founder of Vuetify"
                    >
                        <template v-slot:append>
                            <v-btn
                                variant="text"
                                :class="fav ? 'text-red' : ''"
                                icon="mdi-heart"
                                @click="fav = !fav"
                            ></v-btn>
                        </template>
                    </v-list-item>
                </v-list>

                <v-divider></v-divider>

                <v-list>
                    <v-list-item>
                        <v-switch
                            v-model="message"
                            color="purple"
                            label="Enable messages"
                            hide-details
                        ></v-switch>
                    </v-list-item>

                    <v-list-item>
                        <v-switch
                            v-model="hints"
                            color="purple"
                            label="Enable hints"
                            hide-details
                        ></v-switch>
                    </v-list-item>
                </v-list>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn text @click="menu = false"> Cancel </v-btn>
                    <v-btn color="primary" text @click="menu = false">
                        Save
                    </v-btn>
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

export default {
    setup() {
        return {
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
