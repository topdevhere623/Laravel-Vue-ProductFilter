<template>
    <dashboard-layout>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <date-picker-menu
                    :label="$t('scoliotracker.from')"
                    :date_prop="
                        $dayjs().subtract(7, 'day').format('YYYY-MM-DD')
                    "
                    v-model="from"
                />
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <date-picker-menu
                    :label="$t('scoliotracker.to')"
                    v-model="to"
                />
            </v-col>
            <v-spacer></v-spacer>
        </v-row>
        <div v-if="$auth.user()">
            <div style="min-height: 300px">
                <intervals-chart
                    v-if="showChart"
                    :on="on"
                    :off="off"
                    :periods="periods"
                />
            </div>

            <div>
                <div>Всего</div>
                <div
                    v-for="interval in intervals"
                    :key="`total-` + interval.id"
                >
                    {{
                        $date(interval.started_at).format("DD/MM/YYYY H:mm:ss")
                    }}-{{
                        $date(interval.ended_at).format("DD/MM/YYYY H:mm:ss")
                    }}
                </div>
            </div>
        </div>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../layouts/dashboard/Index";
import Interval from "../../../models/Interval";
import IntervalsChart from "../../../components/IntervalsChart";

export default {
    name: "dashboard-index",
    // eslint-disable-next-line vue/no-unused-components
    components: { IntervalsChart, DashboardLayout },
    data: function () {
        return {
            intervals: [],
            showChart: false,
            from: "",
            to: "",
            menu1: "",
            menu2: "",
            periods: [],
            on: [],
            off: [],
        };
    },
    methods: {
        async init() {
            this.intervals = await Interval.get();
            this.from = this.$dayjs().subtract(7, "day").format("YYYY-MM-DD");
        },
        async fetchAnalytics() {
            this.showChart = false;
            let response = await window.axios.get("/api/analytics/intervals", {
                params: { from: this.from, to: this.to },
            });
            this.periods = response.data.periods;
            this.on = response.data.on;
            this.off = response.data.off;
            this.showChart = true;
        },
    },
    mounted() {
        this.init();
    },
    watch: {
        from() {
            this.fetchAnalytics();
        },
        to() {
            this.fetchAnalytics();
        },
    },
};
</script>

<style scoped>
</style>
