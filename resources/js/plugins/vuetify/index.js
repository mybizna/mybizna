import Vue from 'vue';
import Vuetify from 'vuetify';
import preset from './default-preset/preset';

Vue.use(Vuetify);

export default new Vuetify({
  preset,
  icons: {
    iconfont: 'md',
  },
  theme: {
    options: {
      customProperties: true,
      variations: false,
    },
  },
});
