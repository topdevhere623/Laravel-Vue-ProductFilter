<template>
    <v-dialog
        v-model="dialog"
        max-width="400px"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">User Profile</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col>
                            <v-datetime-picker  :time-picker-props="{format: `24hr`}" label="Select Datetime" v-model="started_at"> </v-datetime-picker>
                        </v-col>
                        <v-col>
                            <v-datetime-picker  :time-picker-props="{format: `24hr`}" label="Select Datetime" v-model="ended_at"> </v-datetime-picker>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-textarea outlined v-model="note" />
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="handleSave"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>

import Workout from "../../models/Workout";

export default {
    props:['workout'],
    data () {
        return {
            dialog: true,
            started_at: null,
            ended_at:null,
            note: null,
        }
    },
    methods: {
        async handleSave() {
            let payload = {id: this.workout.id, started_at: this.started_at, ended_at: this.ended_at, note: this.note}
            let savingWorkout = new Workout(payload)
            await savingWorkout.save()
            this.$emit('saved')
            this.dialog = false
        }
    },
    mounted() {
        if (this.workout.started_at) {
            this.started_at = this.$dayjs(this.workout.started_at).toDate()
        }
        if (this.workout.ended_at) {
            this.ended_at = this.$dayjs(this.workout.ended_at).toDate()
        }
        if (this.workout.note) {
            this.note = this.workout.note
        }
    }
}
</script>
