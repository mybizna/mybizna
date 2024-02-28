<template>
    <div class="dropdown">
        <div class="relative" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" dot>
            <img class="w-8 h-8 rounded-full inline-block" :src="$assets_url + 'images/avatars/1.png'" alt="">
            <span
                class="top-0 left-6 absolute w-2.5 h-2.5 bg-green-400 border border-white dark:border-gray-800 rounded-full"></span>
            <span class="hidden sm:inline px-1 text-white text-sm capitalize font-bold">
                {{ $store.state.auth.user.username }}
            </span>
            <i class="hidden sm:inline fas fa-chevron-down text-white" style="font-size:10px;"></i>

        </div>

        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
            <li> 
                <router-link class="dropdown-item" :to="{ name: 'core.admin.setting.manage'}">
                    Manage Setting
                </router-link>
            </li>
            <li>
                <a class="dropdown-item" href="https://mybizna.com">Help</a>
            </li>
            <li>
                <router-link class="dropdown-item" :to="'/profile'">Profile</router-link>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click="logout()">Logout</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    setup() {
        return {};
    },
    methods: {
        logout() {
            this.$store.commit("auth/logout");
        },
    }
};
</script>

