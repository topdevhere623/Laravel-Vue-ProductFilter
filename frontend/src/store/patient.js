import Interval from "@/models/Interval";
import Vue from 'vue';

const state = () => ({
    item: null,
    defaultItem: {
        created_at: "",
        duration_today_for_humans: "",
        duration_today_seconds: null,
        goal: null,
        id: null,
        is_on_now: null,
        latest_interval: null,
        latest_workout: null,
        latest_xray: null,
        updated_at: "",
        user_id: null,
    },
    items: [],
})

const getters = {
    item: state => {
        return state.item;
    },
    is_on_now: state => {
        return state.item.is_on_now;
    },
}

const actions = {
    async putOff({ state, dispatch }) {
        await Interval.custom(`/intervals/${state.item.latest_interval.id}/end`).get();
        dispatch('refreshItem')
    },
    async putOn({ dispatch }) {
        let interval = new Interval({
            is_on: true,
        });
        await interval.save();
        dispatch('refreshItem')

    },
    setItem({ state }) {
        state.item = Vue.auth.user().patient
    },
    async refreshItem({ dispatch }) {
        await Vue.auth.fetch()
        dispatch('setItem')
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
}
