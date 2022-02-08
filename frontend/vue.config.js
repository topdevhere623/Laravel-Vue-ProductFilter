module.exports = {
    "devServer": {
        "proxy": process.env.APP_URL
    },

    "outputDir": "../public/assets/",

    "publicPath": process.env.NODE_ENV === 'production'
        ? '/assets/'
        : '/',


    // modify the location of the generated HTML file.
    "indexPath": '../../resources/views/spa.blade.php',
    css: {
        extract: process.env.NODE_ENV !== "development",
    },

    // "transpileDependencies": [
    //     "vuetify"
    // ],

    pages: {
        index: {
            // entry for the page
            entry: 'src/main.js',
            // the source template
            template: 'src/index.html',
            // output as dist/index.html
            filename: process.env.NODE_ENV === 'production'
                ? '../../resources/views/spa.blade.php'
                : 'index.html',
            // when using title option,
            // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
            title: process.env.VUE_APP_APP_NAME,
            locale: process.env.VUE_APP_I18N_LOCALE,
        },

    },

    pluginOptions: {
        i18n: {
            locale: 'en',
            fallbackLocale: 'en',
            localeDir: 'locales',
            enableInSFC: false
        }
    }
}
