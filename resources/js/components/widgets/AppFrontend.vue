<template>
    <nav class="p-4 nav-section w-full">
        <div class="container mx-auto">
            <div class="flex justify-between flex- content-center items-center py-2 lg:py-0 px-0 lg:px-0">
                <!-- Start Logo -->
                <a href="index.html">
                    <img src="img/logo.png" class="w-32 self-start" alt="Logo">
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
                            <a class="px-4 py-2 text-gray-700 hover:text-gray-900 transition duration-500 ease-in-out hover:rounded hover:bg-gray-200 rounded text-gray-900"
                                href="login.html">Login</a>
                        </li>
                        <li class="nav-item px-2 signup">
                            <a class="text-gray-900 px-3 py-2 bg-yellow-500 hover:bg-yellow-600 rounded border border-yellow-600 shadow font-semibold transition duration-500 ease-in-out cursor-pointer"
                                href="signup.html">Signup for free</a>
                        </li>
                    </ul>
                </div>
                <!-- End Secondary Navbar -->

                <!-- Start Mobile Navbar-->
                <div class="hamburger-menu px-2 py-1 block md:hidden rounded border border-gray-500 uppercase">
                    Menu
                </div>
                <div
                    class="navbar mobile-nav px-0 mx-0 hidden md:hidden fixed top-0 left-0 w-full bg-white h-screen fixed z-50 p-3">
                    <div class="flex flex- justify-between px-3 py-2">
                        <img src="img/logo.png" class="w-32 self-start ml-1">
                        <div
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
                            <a class="w-full text-lg border-t border-gray-200 block py-3" href="login.html">Login</a>
                        </li>
                        <li class="signup py-4 border-t border-gray-200 p-4">
                            <a class=" px-3 py-2 bg-yellow-500 rounded border border-yellow-600 shadow font-semibold block"
                                href="signup.html">Signup for free</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="overflow-x-hidden">
        <main class="p-0">
            <router-view :key="$route.fullPath"></router-view>
        </main>
    </div>

    <!-- Footer Start -->
    <footer class="footer bg-dark-footer relative text-gray-200 dark:text-gray-200">
        <div class="container relative">
            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <div class="py-[60px] px-0">
                        <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">
                            <div class="lg:col-span-4 md:col-span-12">
                                <a href="#" class="text-[22px] focus:outline-none">
                                    <img src="assets/images/logo-light.png" alt="">
                                </a>
                                <p class="mt-6 text-gray-300">Start working with Tailwind CSS that can provide everything
                                    you need to generate awareness, drive traffic, connect.</p>
                                <ul class="list-none mt-6">
                                    <li class="inline"><a href="https://1.envato.market/techwind" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
                                    <li class="inline"><a href="https://dribbble.com/shreethemes" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
                                    <li class="inline"><a href="https://www.behance.net/shreethemes" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-behance" title="Behance"></i></a></li>
                                    <li class="inline"><a href="http://linkedin.com/company/shreethemes" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-linkedin" title="Linkedin"></i></a></li>
                                    <li class="inline"><a href="https://www.facebook.com/shreethemes" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                                    <li class="inline"><a href="https://www.instagram.com/shreethemes/" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                                    <li class="inline"><a href="https://twitter.com/shreethemes" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                                    <li class="inline"><a href="mailto:support@shreethemes.in"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-envelope align-middle" title="email"></i></a></li>
                                    <li class="inline"><a href="https://forms.gle/QkTueCikDGqJnbky9" target="_blank"
                                            class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-file align-middle" title="customization"></i></a></li>
                                </ul><!--end icon-->
                            </div><!--end col-->

                            <div class="lg:col-span-2 md:col-span-4">
                                <h5 class="tracking-[1px] text-gray-100 font-semibold">Company</h5>
                                <ul class="list-none footer-list mt-6">
                                    <li><a href="page-aboutus.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> About us</a></li>
                                    <li class="mt-[10px]"><a href="page-services.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Services</a></li>
                                    <li class="mt-[10px]"><a href="page-team.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Team</a></li>
                                    <li class="mt-[10px]"><a href="page-pricing.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Pricing</a></li>
                                    <li class="mt-[10px]"><a href="portfolio-creative-four.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Project</a></li>
                                    <li class="mt-[10px]"><a href="blog.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Blog</a></li>
                                    <li class="mt-[10px]"><a href="auth-login.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Login</a></li>
                                </ul>
                            </div><!--end col-->

                            <div class="lg:col-span-3 md:col-span-4">
                                <h5 class="tracking-[1px] text-gray-100 font-semibold">Usefull Links</h5>
                                <ul class="list-none footer-list mt-6">
                                    <li><a href="page-terms.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Terms of Services</a></li>
                                    <li class="mt-[10px]"><a href="page-privacy.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Privacy Policy</a></li>
                                    <li class="mt-[10px]"><a href="documentation.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Documentation</a></li>
                                    <li class="mt-[10px]"><a href="changelog.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Changelog</a></li>
                                    <li class="mt-[10px]"><a href="widget.html"
                                            class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                class="uil uil-angle-right-b"></i> Widget</a></li>
                                </ul>
                            </div><!--end col-->

                            <div class="lg:col-span-3 md:col-span-4">
                                <h5 class="tracking-[1px] text-gray-100 font-semibold">Newsletter</h5>
                                <p class="mt-6">Sign up and receive the latest tips via email.</p>
                                <form>
                                    <div class="grid grid-cols-1">
                                        <div class="my-3">
                                            <label class="form-label">Write your email <span
                                                    class="text-red-600">*</span></label>
                                            <div class="form-icon relative mt-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-mail w-4 h-4 absolute top-3 start-4">
                                                    <path
                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                    </path>
                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                </svg>
                                                <input type="email"
                                                    class="form-input ps-12 rounded w-full py-2 px-3 h-10 bg-gray-800 border-0 text-gray-100 focus:shadow-none focus:ring-0 placeholder:text-gray-200"
                                                    placeholder="Email" name="email" required="">
                                                <div data-lastpass-icon-root="true"
                                                    style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="submitsubscribe" name="send"
                                            class="py-2 px-5 inline-block font-semibold tracking-wide border align-middle duration-500 text-base text-center bg-indigo-600 hover:bg-indigo-700 border-indigo-600 hover:border-indigo-700 text-white rounded-md">Subscribe</button>
                                    </div>
                                </form>
                            </div><!--end col-->
                        </div><!--end grid-->
                    </div><!--end col-->
                </div>
            </div><!--end grid-->
        </div><!--end container-->

        <div class="py-[30px] px-0 border-t border-slate-800">
            <div class="container relative text-center">
                <div class="grid md:grid-cols-2 items-center">
                    <div class="md:text-start text-center">
                        <p class="mb-0">©

                            2023 Techwind. Design with <i class="mdi mdi-heart text-red-600"></i> by <a
                                href="https://shreethemes.in/" target="_blank" class="text-reset">Shreethemes</a>.</p>
                    </div>

                    <ul class="list-none md:text-end text-center mt-6 md:mt-0">
                        <li class="inline"><a href=""><img src="assets/images/payments/american-ex.png"
                                    class="max-h-6 inline" title="American Express" alt=""></a></li>
                        <li class="inline"><a href=""><img src="assets/images/payments/discover.png" class="max-h-6 inline"
                                    title="Discover" alt=""></a></li>
                        <li class="inline"><a href=""><img src="assets/images/payments/master-card.png"
                                    class="max-h-6 inline" title="Master Card" alt=""></a></li>
                        <li class="inline"><a href=""><img src="assets/images/payments/paypal.png" class="max-h-6 inline"
                                    title="Paypal" alt=""></a></li>
                        <li class="inline"><a href=""><img src="assets/images/payments/visa.png" class="max-h-6 inline"
                                    title="Visa" alt=""></a></li>
                    </ul>
                </div><!--end grid-->
            </div><!--end container-->
        </div>
    </footer>
    <!-- Footer End -->
</template>

<script>

export default {

    props: {
        windowWidth: { type: String, default: window.innerWidth },
        windowHeight: { type: String, default: window.innerHeight },
    },
};
</script>
