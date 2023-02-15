const {
    defineConfig
} = require('@vue/cli-service');

const MomentLocalesPlugin = require('moment-locales-webpack-plugin');


module.exports = defineConfig({
    transpileDependencies: true,
    runtimeCompiler: true,
    filenameHashing: false,
    outputDir: __dirname + '/public/mybizna',
    publicPath: "/mybizna/",
    css: {
        extract: true,
    },
    configureWebpack: {

        resolve: {
            extensions: ['.js', '.vue', '.json', '.ts', '.tsx', '.jsx'],
            //extensions: ['.js', '.vue', '.json'],
            alias: {
                vue$: 'vue/dist/vue.esm-bundler.js',
                '@': __dirname + '/resources/js'
            },
        },
        entry: {
            app: './resources/js/app.js'
        },
        optimization: {
            splitChunks: false,
        },
        plugins: [
            // To strip all locales except “en”
            new MomentLocalesPlugin(),

            // Or: To strip all locales except “en”, “es-us” and “ru”
            // (“en” is built into Moment and can’t be removed)
            new MomentLocalesPlugin({
                localesToKeep: ['es-us'],
            }),
        ],
    },

})
