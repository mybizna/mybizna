// Styles
import 'vuetify/styles';
import 'vuetify/lib/styles/main.sass';
import '@fortawesome/fontawesome-free/css/all.css';

import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

// Vuetify
import {
    createVuetify
} from 'vuetify';

import {
    aliases,
    fa
} from 'vuetify/lib/iconsets/fa';

export default createVuetify(
    components,
    directives, {
        icons: {
            defaultSet: 'fa',
            aliases,
            sets: {
                fa,
            },
        },
    }
);
