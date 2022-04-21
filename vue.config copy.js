const {
    defineConfig
} = require('@vue/cli-service');

const TerserPlugin = require("terser-webpack-plugin");


module.exports = defineConfig({
    transpileDependencies: true,
    runtimeCompiler: true,
    outputDir: __dirname + '/public/live',
    publicPath: "/live/",
    css: {
        extract: false,
    },
    chainWebpack: webpackConfig => {

        const inlineLimit = 10000;
        const assetsPath = __dirname + '/public/live';

        if (webpackConfig.plugins.has("extract-css")) {
            const extractCSSPlugin = webpackConfig.plugin("extract-css");
            extractCSSPlugin &&
                extractCSSPlugin.tap(() => [{
                    filename: assetsPath + "css/[name].css",
                    chunkFilename: assetsPath + "css/[name].css"
                }]);
        }

        webpackConfig
            .output
            .filename('js/[name].[hash:8].js')
            .chunkFilename('js/chunk[id].[hash:8].js');


        webpackConfig.module
            .rule('images')
            .test(/\.(png|jpe?g|gif)(\?.*)?$/)
            .use('url-loader')
            .loader('url-loader')
            .options({
                limit: inlineLimit,
                name: 'images/[name].[hash:8].[ext]'
            });

        webpackConfig.module
            .rule('fonts')
            .test(/\.(woff2?|eot|ttf|otf)(\?.*)?$/i)
            .use('url-loader')
            .loader('url-loader')
            .options({
                limit: inlineLimit,
                name: 'fonts/[name].[hash:8].[ext]'
            });

        webpackConfig.optimization.minimizer('terser').tap(args => {
            const opts = args[0];

            opts.terserOptions.mangle = {
                ...opts.terserOptions.mangle,
                properties: {
                    regex: /_$/, // mangle property names that end with "_"
                },
            };

            return args;
        });

        webpackConfig.plugin("copy").tap(([options]) => {
            options.patterns[0].globOptions.ignore.push("assets/**");
            return [options];
          });

        webpackConfig.plugins
            .delete("html")
            .delete("prefetch")
            .delete("preload");
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
            minimize: true,
            minimizer: [new TerserPlugin()],
        },
    },
    pluginOptions: {
        vuetify: {
            // https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vuetify-loader
        }
    }
})
