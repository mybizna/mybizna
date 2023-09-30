<template>
    <nav class="p-4 bg-white mx-auto w-11/12 nav-section w-full">
        <div class="container mx-auto">
            <div class="flex justify-between flex- content-center items-center py-2 lg:py-0 px-0 lg:px-0">
                <!-- Start Logo -->
                <a :href="$base_url">
                    <img :src="$assets_url + '/images/logos/logo.png'" class="w-32 self-start" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Start Main Nav Bar -->
                <div class="hidden md:block">
                    <ul class="flex flex-row">
                        <li class="active">
                            <a class="px-4 py-2 text-gray-900 font-semibold" href="#">Home</a>
                        </li>

                        <li>
                            <a class="px-4 py-2 text-gray-700 hover:text-gray-900 transition duration-500 ease-in-out hover:rounded hover:bg-gray-200 rounded"
                                href="features.html">Features</a>
                        </li>
                        <li>
                            <a class="px-4 py-2 text-gray-700 hover:text-gray-900 transition duration-500 ease-in-out hover:rounded hover:bg-gray-200 rounded"
                                href="pricing.html">Pricing</a>
                        </li>
                        <li>
                            <a class="px-4 py-2 text-gray-700 hover:text-gray-900 transition duration-500 ease-in-out hover:rounded hover:bg-gray-200 rounded"
                                href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>
                <!-- End Main Navbar -->

                <!-- End Secondary Navbar -->
                <div class="hidden md:block">
                    <ul class="flex flex-">
                        <li>
                            <a class=" px-3 py-1 bg-blue-600 rounded border border-blue-600 shadow block text-white"
                                :href="$base_url">Login</a>

                        </li>
                    </ul>
                </div>
                <!-- End Secondary Navbar -->

                <!-- Start Mobile Navbar-->
                <div @click="showMenu = !showMenu"
                    class="hamburger-menu px-2 py-1 block md:hidden rounded border border-gray-500 uppercase">
                    Menu
                </div>
                <div :class="!showMenu ? 'hidden md:hidden' : ''"
                    class="navbar mobile-nav px-0 mx-0  fixed top-0 left-0 w-full bg-white h-screen fixed z-50 p-3">
                    <div class="flex flex- justify-between px-3 py-2">
                        <img :src="$assets_url + '/images/logos/logo.png'" class="w-32 self-start ml-1">
                        <div @click="showMenu = !showMenu"
                            class="close-menu flex items-center content-center justify-center px-2 py-1 bg-black rounded px-x py-1 text-white uppercase">
                            Close
                        </div>
                    </div>
                    <ul class="flex flex-col text-center mt-2 pt-2 w-full">
                        <li class="active w-full">
                            <a class="w-full font-bold text-lg border-t border-gray-200 block py-3" href="/">Home</a>
                        </li>
                        <li class="w-full">
                            <a class="w-full text-lg border-t border-gray-200 block py-3" href="features.html">Features</a>
                        </li>
                        <li class="w-full">
                            <a class="w-full text-lg border-t border-gray-200 block py-3" href="pricing.html">Pricing</a>
                        </li>
                        <li class="w-full">
                            <a class="w-full text-lg border-t border-gray-200 block py-3" href="contact.html">Contact</a>
                        </li>
                        <li class="w-full">
                            <a class="mx-2 px-3 py-2 bg-blue-500 rounded border border-blue-600 shadow font-semibold block text-lg text-white"
                                :href="$base_url">Login</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="">
        <main class="p-0">
            <router-view :key="$route.fullPath"></router-view>
        </main>
    </div>




    <!-- Footer Start -->
    <footer class="footer relative text-white bg-gray-600">
        <div class="py-[30px] px-0 border-t border-slate-800">
            <div class="container relative text-center">
                <div class="items-center">

                    <div class="text-center">
                        <a class="inline-block px-4 py-2 transition duration-500 ease-in-out hover:rounded hover:bg-gray-200 rounded text-gray-300 hover:text-gray-600 "
                            :href="$base_url + '/manage'">
                            Admin Area
                        </a>
                    </div>

                    <div class="text-center">
                        <span>
                            &copy; 2022 - {{ currentYear }}
                            <a href="https://mybizna.com" class="text-decoration-none" target="_blank">Mybizna</a>
                        </span>

                    </div>



                </div><!--end grid-->
            </div><!--end container-->
        </div>
    </footer>
    <!-- Footer End -->
</template>

<script>

import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();

        if (!store.state.system.menu.length) {
            store.dispatch("system/getMenu");
        }

        if (!store.state.system.positions.length) {
            store.dispatch("system/getPositions");
        }
    },
    props: {
        windowWidth: { type: String, default: window.innerWidth },
        windowHeight: { type: String, default: window.innerHeight },
    },
    data() {
        return {
            showMenu: false,
            currentYear: new Date().getFullYear(),
        };
    },
};
</script>
