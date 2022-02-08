<template>
    <div class="pa-4 light rounded-lg elevation-3">
        <v-row dense class="text-center" align="end">
            <v-col cols="2">
                <div class="mb-1">{{ $t("scoliotracker.putOn") }}</div>
                <v-chip class="d-flex justify-center" label color="lightBlue">
                    <v-datetime-picker
                        :time-picker-props="{ format: `24hr` }"
                        v-model="interval.started_at"
                    >
                    </v-datetime-picker
                ></v-chip>
            </v-col>
            <v-col cols="2">
                <div class="mb-1">{{ $t("scoliotracker.putOff") }}</div>
                <v-chip class="d-flex justify-center" label color="lightBlue">
                    <v-datetime-picker
                        :time-picker-props="{ format: `24hr` }"
                        v-model="interval.ended_at"
                    >
                    </v-datetime-picker
                ></v-chip>
            </v-col>
            <v-col>
                <div class="mb-1">{{ $t("scoliotracker.comment") }}</div>
                <v-chip class="d-flex justify-center" label color="lightBlue">
                    <input
                        class="input"
                        v-model="interval.note"
                        type="text"
                        @change="$emit('input', interval)"/></v-chip
            ></v-col>
            <v-col cols="auto"
                ><CustomButton @click="handleAdd" color="light">{{
                    $t("scoliotracker.add")
                }}</CustomButton></v-col
            >
        </v-row>
    </div>
</template>

<script>
export default {
    name: "IntervalAddForm",
    props: {
        currentDate: {
            default: null,
        },
    },
    data() {
        return {
            interval: {
                started_at: null,
                ended_at: null,
                note: null
            }
        };
    },
    watch: {
        currentDate() {
            console.log('watch', this.currentDate);
            this.interval.started_at = null;
            this.interval.ended_at = null;
            this.interval.note = null;
            this.$emit("input");
            console.log('aaa', this.interval);
        }
    },
    methods: {
        handleAdd() {
            if(this.interval.started_at === null || this.interval.ended_at === null) {
                alert("Please select the right date.")
            } else {
                this.$emit("add", this.interval);
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.input {
    outline: none;
}
</style>
