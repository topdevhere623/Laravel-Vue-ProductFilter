<template>
    <v-dialog
        v-model="dialog"
        width="500"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                x-small
                icon
                v-bind="attrs"
                v-on="on"
            >
                <v-icon dark>mdi-trash-can</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                Are you sure?
            </v-card-title>
            <v-card-text>
                This cannot be undone
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="danger"
                    text
                    @click="handleDelete"
                >
                    Delete
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>

import Workout from "../../models/Workout";

export default {
    props: ['workout'],
    data() {
        return {
            dialog: false,
        }
    },
    methods: {
        async handleDelete() {
            this.dialog = false
            let deletingWorkout = new Workout(this.workout)
            await deletingWorkout.delete()
            this.$emit('deleted')
        }
    }
}
</script>
