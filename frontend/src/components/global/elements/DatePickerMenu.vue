<template>
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
                v-model="dateFormatted"
                prepend-inner-icon="mdi-calendar"
                v-bind="attrs"
                v-on="on"
                :error-messages="error"
                @change="$emit('change')"
                readonly
                @blur="date = parseDate(dateFormatted)"
            ></v-text-field>
        </template>
        <v-date-picker
            v-model="date"
            no-title
            @input="menu = false"
        ></v-date-picker>
    </v-menu>
</template>

<script>
export default {
    name: "DatePickerMenu",
    props: {
        value: {
            required: true
        },
        error: {
            required: false
        },
        label: {
            required: false
        }
    },
    data() {
        return {
            date: new Date().toISOString().substr(0, 10),
            dateFormatted: null,
            menu: false
        };
    },
    created() {
        if (this.value)
            this.dateFormatted = this.formatDate(
                new Date(this.value).toISOString().substr(0, 10)
            );
    },
    watch: {
        date() {
            this.dateFormatted = this.formatDate(this.date);
            this.$emit("input", this.date);
            this.$emit("change");
        }
    },
    methods: {
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split("-");
            return `${month}/${day}/${year}`;
        },
        parseDate(date) {
            if (!date) return null;
            const [month, day, year] = date.split("/");
            return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
        }
    }
};
</script>
