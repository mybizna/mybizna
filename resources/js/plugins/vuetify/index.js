// Styles
import 'vuetify/styles';

import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/lib/styles/main.sass';

import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import { aliases, fa } from 'vuetify/lib/iconsets/fa';
import { mdi } from 'vuetify/lib/iconsets/mdi';
// Vuetify
import { createVuetify } from 'vuetify';

export default createVuetify(
    components,
    directives,
    {
        icons: {
            defaultSet: 'fa',
            aliases,
            sets: {
                fa,
                mdi,
            }
        }
    }
);
