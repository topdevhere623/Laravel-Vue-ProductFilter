<template>
    <v-dialog
        v-model="dialog"
        width="400px"
    >
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

import Interval from "../../models/Interval";

export default {
    props: ['interval'],
    data() {
        return {
            dialog: true,
        }
    },
    methods: {
        async handleDelete() {
            this.dialog = false
            let deletingInterval = new Interval(this.interval)
            await deletingInterval.delete()
            this.$emit('deleted')
        }
    }
}
</script>
