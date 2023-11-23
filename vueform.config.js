import en from '@vueform/vueform/locales/en'
import { defineConfig } from '@vueform/vueform'
import tailwind from '@vueform/vueform/themes/tailwind'

// You might place these anywhere else in your project
import '@vueform/vueform/themes/vueform/css/index.min.css';

export default defineConfig({
    theme: tailwind,
    locales: { en },
    locale: 'en',
})


