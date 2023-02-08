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
                    <a v-if="dropdown_menu.type == 'event'" class="dropdown-item"
                        @click="firePassedEvent(dropdown_menu, pitem)" :alt="dropdown_menu.title">
                        <i :class="dropdown_menu.icon + ' text-blue-300'"></i>
                        {{ dropdown_menu.title }}
                    </a>
                    <router-link v-else-if="dropdown_menu.type == 'router' || dropdown_menu.type == 'route'"
                        class="dropdown-item" :to="{ name: dropdown_menu.name, params: pitem }"
                        :alt="dropdown_menu.title">
                        <i :class="dropdown_menu.icon + ' text-blue-300'"></i>
                        {{ dropdown_menu.title }}
                    </router-link>
                    <a v-else class="dropdown-item" :alt="dropdown_menu.title"
                        :href="processLink(dropdown_menu, pitem)">
                        <i :class="dropdown_menu.icon + ' text-blue-300'"></i>
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
    data() {
        return {
            generated_url: "",
        };
    },
    methods: {
        firePassedEvent(dropdown_menu, item) {
            var counter = 0;
            var message = "Are you sure you want to delete this record? \n";

            for (const [key, value] of Object.entries(item)) {

                message += ((key != 'id') ? "    " : '') +
                    `${window.$func.toUnicodeVariant(key, 'bold sans', 'bold')}:-${value}`;

                if (counter > 3) {
                    break;
                }

                counter++;
            }

            if (confirm(message)) {
                var path = { type: 'router', link: dropdown_menu.return };
                this.$emitter.emit(dropdown_menu.event, { ids: [item.id], path: path });
            }
        },

        processLink(dropdown_menu, item) {
            return dropdown_menu.link;
        },

        toUnicodeVariant(str, variant, flags) {
            const offsets = {
                m: [0x1d670, 0x1d7f6],
                b: [0x1d400, 0x1d7ce],
                i: [0x1d434, 0x00030],
                bi: [0x1d468, 0x00030],
                c: [0x1d49c, 0x00030],
                bc: [0x1d4d0, 0x00030],
                g: [0x1d504, 0x00030],
                d: [0x1d538, 0x1d7d8],
                bg: [0x1d56c, 0x00030],
                s: [0x1d5a0, 0x1d7e2],
                bs: [0x1d5d4, 0x1d7ec],
                is: [0x1d608, 0x00030],
                bis: [0x1d63c, 0x00030],
                o: [0x24B6, 0x2460],
                p: [0x249C, 0x2474],
                w: [0xff21, 0xff10],
                u: [0x2090, 0xff10]
            }

            const variantOffsets = {
                'monospace': 'm',
                'bold': 'b',
                'italic': 'i',
                'bold italic': 'bi',
                'script': 'c',
                'bold script': 'bc',
                'gothic': 'g',
                'gothic bold': 'bg',
                'doublestruck': 'd',
                'sans': 's',
                'bold sans': 'bs',
                'italic sans': 'is',
                'bold italic sans': 'bis',
                'parenthesis': 'p',
                'circled': 'o',
                'fullwidth': 'w'
            }

            // special characters (absolute values)
            var special = {
                m: {
                    ' ': 0x2000,
                    '-': 0x2013
                },
                i: {
                    'h': 0x210e
                },
                g: {
                    'C': 0x212d,
                    'H': 0x210c,
                    'I': 0x2111,
                    'R': 0x211c,
                    'Z': 0x2128
                },
                o: {
                    '0': 0x24EA,
                    '1': 0x2460,
                    '2': 0x2461,
                    '3': 0x2462,
                    '4': 0x2463,
                    '5': 0x2464,
                    '6': 0x2465,
                    '7': 0x2466,
                    '8': 0x2467,
                    '9': 0x2468,
                },
                p: {},
                w: {}
            }
            //support for parenthesized latin letters small cases 
            for (var i = 97; i <= 122; i++) {
                special.p[String.fromCharCode(i)] = 0x249C + (i - 97)
            }
            //support for full width latin letters small cases 
            for (var i = 97; i <= 122; i++) {
                special.w[String.fromCharCode(i)] = 0xff41 + (i - 97)
            }

            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            const numbers = '0123456789';

            var getType = function (variant) {
                if (variantOffsets[variant]) return variantOffsets[variant]
                if (offsets[variant]) return variant;
                return 'm'; //monospace as default
            }
            var getFlag = function (flag, flags) {
                if (!flags) return false
                return flags.split(',').indexOf(flag) > -1
            }

            var type = getType(variant);
            var underline = getFlag('underline', flags);
            var strike = getFlag('strike', flags);
            var result = '';

            for (var k of str) {
                let index
                let c = k
                if (special[type] && special[type][c]) c = String.fromCodePoint(special[type][c])
                if (type && (index = chars.indexOf(c)) > -1) {
                    result += String.fromCodePoint(index + offsets[type][0])
                } else if (type && (index = numbers.indexOf(c)) > -1) {
                    result += String.fromCodePoint(index + offsets[type][1])
                } else {
                    result += c
                }
                if (underline) result += '\u0332' // add combining underline
                if (strike) result += '\u0336' // add combining strike
            }
            return result
        }

    },
};
</script>
