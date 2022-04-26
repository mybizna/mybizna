const {
    defineConfig
} = require('@vue/cli-service');

module.exports = defineConfig({
    transpileDependencies: true,
    runtimeCompiler: true,
    filenameHashing: false,
    outputDir: __dirname + '/public/live',
    publicPath: "/live/",
    css: {
        extract: false,
    },
    configureWebpack: {

        resolve: {
            alias: {
                vue$: 'vue/dist/vue.esm-bundler.js',
                '@': __dirname + '/resources/js'
            }
        },
        entry: {
            app: './resources/js/app.js'
        },
        optimization: {
            splitChunks: false,
        },
    },
    pluginOptions: {
        vuetify: {
            // https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vuetify-loader
        }
    }
})
