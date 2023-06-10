const {
    defineConfig
} = require('@vue/cli-service');

const MomentLocalesPlugin = require('moment-locales-webpack-plugin');
const TerserPlugin = require("terser-webpack-plugin");

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
            minimize: true,
            minimizer: [new TerserPlugin()],
        },
        plugins: [
            new MomentLocalesPlugin(),
            new MomentLocalesPlugin({
                localesToKeep: ['es-us'],
            }),
        ],
    },

})
