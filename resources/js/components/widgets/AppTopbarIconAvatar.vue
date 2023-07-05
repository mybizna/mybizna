<template>
    <div class="dropdown">
        <div class="relative" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" dot>
            <img class="w-8 h-8 rounded-full" :src="$assets_url + 'images/avatars/1.png'" alt="">
            <span
                class="top-0 left-7 absolute  w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
        </div>

        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
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

};
</script>

