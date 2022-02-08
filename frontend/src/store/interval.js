import Interval from "@/models/Interval";
const state = () => ({
    item: null,
    defaultItem: {
        created_at: "",
        duration_for_humans: "",
        ended_at: null,
        ended_at_moscow: null,
        id: null,
        note: null,
        patient_id: null,
        started_at: "",
        started_at_moscow: "",
        updated_at: "",
    },
    items: [],
})

const getters = {
    item: state => {
        return state.item;
    },
    items: state => {
        return state.items;
    },

}
const mutations = {

}

const actions = {
    async setItems({ state }, date) {
        const startTime = `${date} 12:00:00 AM`;
        const endTime = `${date} 11:59:59 PM`;
        const utcStartTime = new Date(startTime).toISOString();
        const utcEndTime = new Date(endTime).toISOString();
        state.items = await Interval.where('startTime', utcStartTime).where('endTime', utcEndTime).get()
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
