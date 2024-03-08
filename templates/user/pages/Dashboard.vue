<template>
    <div class="p-3">

        <!-- Page Header -->
        <div class="md:flex block items-center justify-between my-1 page-header-breadcrumb">
            <div>
                <p class="font-semibold text-md text-defaulttextcolor dark:text-defaulttextcolor/70 !mb-0 ">Welcome
                    back, {{ $store.state.auth.user.name }} !</p>
                <p class="font-normal text-[#8c9097] dark:text-white/50 text-sm">
                    <i class="text-gray-500 text-xs fas fa-user"></i>:
                    {{ $store.state.auth.user.username }}

                    <i class="text-gray-500 text-xs fas fa-phone pl-2"></i>:
                    {{ $store.state.auth.user.phone }}

                    <i class="text-gray-500 text-xs fas fa-envelope pl-2"></i>:
                    {{ $store.state.auth.user.email }}
                </p>
            </div>
            <div class="btn-list md:mt-0 mt-2">
                <button type="button"
                    class="ti-btn bg-primary text-white btn-wave !font-medium !me-[0.375rem] !ms-0 !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none">
                    <i class="ri-filter-3-fill  inline-block"></i>
                    Filters
                </button>
                <button type="button"
                    class="ti-btn ti-btn-outline-secondary btn-wave !font-medium  !me-[0.375rem]  !ms-0 !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none">
                    <i class="ri-upload-cloud-line  inline-block"></i>Export </button>
            </div>
        </div>


        <!-- Activates Summary -->
        <div>
            <div class="flex">
                <div class="flex-none w-1/3 p-3">
                    <div class="shadow rounded-md w-full"
                        style="background-image: url('images/misc/mountains.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="rounded-md p-3 flex items-center justify-between"
                            :style="(last_month.percent >= 100) ? 'background: rgb(81 155 73 / 60%);' : 'background: rgb(249 43 10/ 60%);'">
                            <div class="flex-none w-1/2">
                                <div class="font-semibold text-[1.125rem] text-white mb-2">Last Month Target
                                </div>
                                <span class="block text-[0.75rem] text-white">
                                    <span class="opacity-[0.7]">You completed </span>
                                    <span class="font-semibold text-warning"> {{ last_month.percent }}% </span>
                                    <span class="opacity-[0.7]">of the your target last month. </span>
                                </span>

                            </div>
                            <div class="flex-none w-1/2">
                                <h2 v-if="last_month.is_new" class="text-lg text-white text-center font-semibold">Grace
                                    <br> Period
                                </h2>
                                <apexchart v-else type="radialBar" :options="options" :series="[last_month.percent]">
                                </apexchart>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-none w-1/3 p-3">
                    <div class="shadow rounded-md w-full"
                        style="background-image: url('images/misc/mountains.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="rounded-md p-3 flex items-center justify-between"
                            :style="(this_month.percent >= 100) ? 'background: rgb(81 155 73 / 60%);' : 'background: rgb(249 43 10/ 60%);'">
                            <div class="flex-none w-1/2">
                                <div class="font-semibold text-[1.125rem] text-white mb-2">This Month Target
                                </div>
                                <span class="block text-[0.75rem] text-white">
                                    <span class="opacity-[0.7]">You have completed </span>
                                    <span class="font-semibold text-warning"> {{ this_month.percent }}% </span>
                                    <span class="opacity-[0.7]">of the your target this month. </span>
                                </span>

                            </div>
                            <div class="flex-none w-1/2">
                                <apexchart type="radialBar" :options="options" :series="[this_month.percent]">
                                </apexchart>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-none w-1/3 p-3">
                    <div class="shadow rounded-md w-full bg-white p-2">
                        <div class="flex">

                            <div class="flex-auto font-semibold text-md mt-2 text-gray-600">Your Balance: </div>
                            <h4 class="flex-auto font-semibold  text-[2rem] text-right">{{
                        $func.toCurrency(earning.balance)
                    }}</h4>
                        </div>

                        <div class=" flex">
                            <div class="flex-auto"></div>
                            <div class="flex-none w-22">
                                <div class="flex">
                                    <div class="flex-none w-6 pt-2 text-right">
                                        <i class="text-gray-300 text-md fas fa-long-arrow-alt-up"></i>
                                    </div>
                                    <div class="flex-auto">
                                        <p class="text-[#8c9097] dark:text-white/50 text-[0.813rem] mb-0">Total In
                                        </p>
                                        <h4 class="font-semibold  text-sm ">{{ $func.toCurrency(earning.in)
                                            }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-none w-22">
                                <div class="flex">
                                    <div class="flex-none w-6 pt-2 text-right">
                                        <i class="text-gray-300 text-md fas fa-long-arrow-alt-down"></i>
                                    </div>
                                    <div class="flex-auto">
                                        <p class="text-[#8c9097] dark:text-white/50 text-[0.813rem] mb-0">Total Out
                                        </p>
                                        <h4 class="font-semibold  text-sm">{{ $func.toCurrency(earning.out)
                                            }}</h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between !mt-1">
                                <a class="block bg-primary text-white btn-wave !font-medium !me-[0.375rem] !ms-0 !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none"
                                    href="javascript:void(0);">
                                    <i class="fas fa-wallet font-semibold "></i>
                                    Withdraw
                                </a>

                                <a class="block bg-danger text-white btn-wave !font-medium !me-[0.375rem] !ms-0 !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none"
                                    href="javascript:void(0);">
                                    <i class="fas fa-plus-circle font-semibold  inline-block"></i>
                                    Add Fund
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-6 d:gap-y-0 gap-y-4 my-3">

            <div class="bg-red-50 rounded text-center py-2 m-2 border border-red-100">
                <a aria-label="anchor" href="javascript:void(0);">
                    <span
                        class="text-red-400 font-semibold rounded-full border border-red-400 w-14 h-14 inline-block p-2">
                        <i class="fas fa-wallet fa-2x"></i>
                    </span>
                    <div class="text-gray-600 font-semibold text-sm mt-2">Wallet</div>
                </a>
            </div>

            <div class="bg-indigo-50 rounded text-center py-2 m-2 border border-indigo-100">
                <a aria-label="anchor" href="javascript:void(0);">
                    <span
                        class="text-indigo-400 font-semibold rounded-full border border-indigo-400 w-14 h-14 inline-block p-2">
                        <i class="fas fa-users fa-2x"></i>
                    </span>
                    <div class="text-gray-600 font-semibold text-sm mt-2">My Team</div>
                </a>
            </div>

            <div class="bg-green-50 rounded text-center py-2 m-2 border border-green-200">
                <a aria-label="anchor" href="javascript:void(0);">
                    <span
                        class="text-green-600 font-semibold rounded-full border border-green-400 w-14 h-14 inline-block p-2">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </span>
                    <div class="text-gray-600 font-semibold text-sm mt-2">GIF Shop</div>
                </a>
            </div>

            <div class="bg-orange-50 rounded text-center py-2 m-2 border border-orange-100">
                <a aria-label="anchor" href="javascript:void(0);">
                    <span
                        class="text-orange-400 font-semibold rounded-full border border-orange-400 w-14 h-14 inline-block p-2">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </span>
                    <div class="text-gray-600 font-semibold text-sm mt-2">E-Learning</div>
                </a>
            </div>

            <div class="bg-yellow-50 rounded text-center py-2 m-2 border border-yellow-200">
                <a aria-label="anchor" href="javascript:void(0);">
                    <span
                        class="text-yellow-400 font-semibold rounded-full border border-yellow-400 w-14 h-14 inline-block p-2">
                        <i class="fas fa-server fa-2x"></i>
                    </span>
                    <div class="text-gray-600 font-semibold text-sm mt-2">Web Hosting</div>
                </a>
            </div>

            <div class="bg-blue-50 rounded text-center py-2 m-2 border border-blue-100">
                <a aria-label="anchor" href="javascript:void(0);">
                    <span
                        class="text-blue-400 font-semibold rounded-full border border-blue-400 w-14 h-14 inline-block p-2">
                        <i class="fas fa-mobile fa-2x"></i>
                    </span>
                    <div class="text-gray-600 font-semibold text-sm mt-2">Airtime</div>
                </a>
            </div>

        </div>


        <!-- Invitation link -->

        <div class="bg-indigo-100 rounded p-3">
            <div class="flex">
                <div class="flex-none w-36 hidden md:block"><img src="images/misc/custom-14.svg" alt=""></div>
                <div class="flex-auto">
                    <h2 class="text-2xl font-semibold text-indigo-500 mb-2">Invitation Link!</h2>
                    <p class="text-gray-800 mb-2 fs-16">
                        You can invite your friends and earn. Your invitation link is: <br>
                    </p>
                    <p class="font-semibold text-indigo-500 mb-2 fs-16">
                        {{ $root_url }}/register/{{ $store.state.auth.user.username }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="flex-none w-1/4">
                <div class="flex bg-green-50 rounded py-2 m-2 border border-green-200">
                    <div class="flex-none w-14 font-semibold text-md mt-2 text-center text-green-600">
                        <i class="fas fa-circle-check fa-2x"></i>
                    </div>
                    <div class="flex-auto font-semibold text-xs text-gray-600">
                        <p>Subscription is Active</p>
                        <a class="inline-block bg-primary text-white btn-wave mt-1 !font-medium !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none"
                            href="javascript:void(0);">
                            <i class="fas fa-wallet font-semibold "></i>
                            Renew
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex-none w-3/4">

                <div class="bg-white rounded py-2 m-2">

                    <div class="grid grid-cols-4 d:gap-y-0 gap-y-4 my-1">

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L1</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l1.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l1.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber(level.l1.total) }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L2</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l2.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l2.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber(level.l2.total) }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L3</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l3.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l3.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber(level.l3.total) }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L4</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l4.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l4.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber(level.l4.total) }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L5</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l5.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l5.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber(level.l5.total) }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L6</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l6.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l6.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber(level.l6.total) }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-light rounded p-1 mx-1">
                            <div class="flex">
                                <div class="flex-none w-10 pl-1">
                                    <div class="bg-gray-300 rounded text-center">
                                        <p class="mb-0 text-2xl font-semibold">L7</p>
                                    </div>
                                </div>
                                <div class="flex-auto">
                                    <p class="mb-0 text-sm text-green-600 pl-1">
                                        <b><i class="fas fa-circle-check"></i> Active:</b>
                                        {{ $func.formatNumber(level.l7.active) }}
                                    </p>
                                    <p class="mb-0 text-sm text-gray-600 pl-1">
                                        <b><i class="fas fa-circle-xmark"></i> Free:</b>
                                        {{ $func.formatNumber(level.l7.inactive) }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <p class="pl-1 mb-0 text-sm text-gray-700 text-center">
                                    <b>Total:</b>
                                    {{ $func.formatNumber( level.l7.total ) }}
                                </p>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            earning: {
                balance: 30,
                in: 90,
                out: 60,
            },
            last_month: {
                percent: 1000,
                is_new: false,
            },
            this_month: {
                percent: 90,
            },
            level: {
                l1: {
                    active: 1,
                    inactive: 15365,
                    total: 15366,
                },
                l2: {
                    active: 27,
                    inactive: 22946,
                    total: 22973,
                },
                l3: {
                    active: 44,
                    inactive: 50882,
                    total: 50926,
                },
                l4: {
                    active: 122,
                    inactive: 123625,
                    total: 123747,
                },
                l5: {
                    active: 173,
                    inactive: 157741,
                    total: 157914,
                },
                l6: {
                    active: 188,
                    inactive: 154033,
                    total: 154221,
                },
                l7: {
                    active: 163,
                    inactive: 126098,
                    total: 126261,
                },
            },
            options: {
                chart: {
                    type: 'radialBar',
                },
                plotOptions: {
                    offsetX: 0,
                    offsetY: 0,
                    radialBar: {
                        hollow: {
                            margin: 0,
                            size: '60%',
                        },
                        track: {
                            strokeWidth: '70%', // Increase the width of the radial bars
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                offsetY: 3,
                                fontSize: '16px',
                                fontWeight: 600,
                                color: '#FFFFFF',
                            },
                            total: {
                                show: false,
                            }
                        }
                    },
                },
                labels: [''],
                colors: ['#fce68f'],
            },

        };
    },
};
</script>
