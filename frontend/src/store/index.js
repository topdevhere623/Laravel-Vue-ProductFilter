import Vue from 'vue'
import Vuex from 'vuex'
import auth from "./auth";
import site from "./site";
import interval from "./interval";
import patient from "./patient";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth, site, interval, patient
    }
})
