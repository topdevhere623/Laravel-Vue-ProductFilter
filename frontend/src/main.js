import { loadProgressBar } from 'axios-progress-bar';
import 'axios-progress-bar/dist/nprogress.css';
import _ from 'lodash';
import Vue from 'vue';
import VueDayjs from 'vue-dayjs-plugin';
import DatetimePicker from 'vuetify-datetime-picker';
import App from './App.vue';
import i18n from './i18n';
import './plugins/vue-auth';
import vuetify from './plugins/vuetify';
import './registerServiceWorker';
import router from './router';
import './scss/app.scss';
import store from './store';

Vue.use(DatetimePicker)
Vue.use(VueDayjs)
Object.defineProperty(Vue.prototype, '$_', { value: _ });

Vue.config.productionTip = false
require('./bootstrap');
loadProgressBar()

const requireComponent = require.context("./components/global", true, /\.vue$/);
requireComponent.keys().forEach(filename => {
    const component = requireComponent(filename)
    const componentName = filename.split("/").pop().replace(/\.\w+$/, "").replace(/-([a-z])/g, g => g[1].toUpperCase()).replace(/(\b\w)/gi, m => m.toUpperCase());
    Vue.component(componentName, component.default || component); /* Global component registration */
});
const requireMixin = require.context("./mixins/global", true, /\.js$/);
requireMixin.keys().forEach(filename => {
    const mixin = requireMixin(filename)
    Vue.mixin(mixin.default); /* Global mixins registration */
});

new Vue({
    router,
    store,
    vuetify,
    i18n,
    render: h => h(App)
}).$mount('#app')
