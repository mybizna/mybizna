<template>
    <div class="dropdown">
        <div class="relative flex" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" dot>
            <div class="h-8">
                <img class="w-8 h-8 rounded-full inline-block" :src="$assets_url + 'images/avatars/1.png'" alt="">
                <span
                    class="left-6 absolute w-2.5 h-2.5 bg-blue-400 border border-white dark:border-gray-800 rounded-full"></span>
            </div>
            <div class="h-8 hidden sm:inline-block px-2 text-gray-500 text-xs capitalize">
                <div class="font-semibold">
                    {{ $store.state.auth.user.name }} </div>
                {{ $store.state.auth.user.username }}
            </div>
            <div class="h-8">
                <i class="hidden sm:inline fas fa-chevron-down text-gray-500" style="font-size:10px;"></i>
            </div>

        </div>

        <ul class="dropdown-menu w-64 shadow-lg rounded-none border-gray-200" aria-labelledby="dropdownMenuLink">
            <li class="my-1">
                <router-link class="dropdown-item text-sm text-gray-500 font-semibold"
                    :to="{ name: 'core.admin.setting.manage' }">
                    <i class="fas fa-cogs pr-2"></i>
                    Manage Setting
                </router-link>
            </li>
            <li class="my-1">
                <router-link class="dropdown-item text-sm text-gray-500 font-semibold" :to="'/profile'">
                    <i class="fas fa-user-cog pr-2"></i>
                    Profile
                </router-link>
            </li>
            <li>
                <hr class="mx-1 border-dotted">
            </li>
            <li class="my-1">
                <a class="dropdown-item text-sm text-gray-500 font-semibold" href="#" @click="logout()">
                    <i class="fas fa-sign-out-alt pr-2"></i>
                    Logout</a>
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

