const {
    defineConfig
} = require('@vue/cli-service');

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
            fallback: {
                "fs": false,
                "path": require.resolve("path-browserify")
            },
        },
        entry: {
            app: './resources/js/app.js'
        },
        optimization: {
            splitChunks: false,
        },
    },

})
