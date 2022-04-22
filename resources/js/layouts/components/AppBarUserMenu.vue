<template>
    <v-btn color="primary" open-on-hover>
        <v-badge
            bottom
            color="success"
            overlap
            offset-x="12"
            offset-y="12"
            class="ms-4"
            dot
        >
            <v-avatar size="40px">
                <v-img src="images/avatars/1.png"></v-img>
            </v-avatar>
        </v-badge>
        <v-menu activator="parent" start>
            <v-list>
                <div class="pb-3 pt-2">
                    <v-badge
                        bottom
                        color="success"
                        overlap
                        offset-x="12"
                        offset-y="12"
                        class="ms-4"
                        dot
                    >
                        <v-avatar size="40px">
                            <v-img src="images/avatars/1.png"></v-img>
                        </v-avatar>
                    </v-badge>
                    <div
                        class="d-inline-flex flex-column justify-center ms-3"
                        style="vertical-align: middle"
                    >
                        <span class="text--primary font-weight-semibold mb-n1">
                            John Doe
                        </span>
                        <small class="text--disabled text-capitalize"
                            >Admin</small
                        >
                    </div>
                    xxxxxxxxxxxxxxxxxxxxxxxxxxx
                </div>

                <v-divider></v-divider>

                <!-- Profile -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" role="img" icon="fas fa-plus">
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Profile</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- Email -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" role="img" icon="fas fa-plus">
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Inbox</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- Chat -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" icon="mdi:mdi-minus"> </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Chat</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-action>
                        <v-badge inline color="error" content="2"> </v-badge>
                    </v-list-item-action>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <!-- Settings -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" icon="fas fa-plus"> </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Settings</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- Pricing -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" icon="fas fa-plus"> </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Pricing</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- FAQ -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" role="img" icon="fas fa-plus">
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>FAQ</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <!-- Logout -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22" role="img" icon="fas fa-plus">
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-btn>
</template>

<script>
export default {
    setup() {
        return {};
    },
};
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
    }
}
</style>
