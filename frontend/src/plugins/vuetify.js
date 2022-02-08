import '@mdi/font/css/materialdesignicons.css';
import Vue from 'vue';
import 'vuetify/dist/vuetify.css'; // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css';
import Vuetify from 'vuetify/lib/framework';

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
    theme: {
        options: {
            customProperties: true,
        },
        theme: { dark: true },
        themes: {
            light: {
                primary: '#008080',
                secondary: '#6477D8',
                dark: '#20416C',
                light: '#FFFFFF',
                lightGrey: '#F2F2F2',
                lightBlue: "#D8DDF5",
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
            dark: {
                primary: '#fd5312',
                secondary: '#6477D8',
                lightGrey: '#F2F2F2',
                lightBlue: "#D8DDF5",
                accent: '#fb9f1e',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
        },
    },
});
