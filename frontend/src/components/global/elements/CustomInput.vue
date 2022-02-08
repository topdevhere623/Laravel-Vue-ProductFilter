<template>
    <div>
        <v-textarea
            v-if="type == 'textarea'"
            dense
            v-model="content"
            :rules="rules"
            color="dark"
            :label="label"
            :required="required"
            :error-messages="error"
            @input="$emit('input', content)"
            @change="$emit('change')"
            :filled="$vuetify.theme.dark"
        ></v-textarea>
        <v-text-field
            v-else
            dense
            :type="type"
            v-model="content"
            :rules="rules"
            :label="label"
            color="dark"
            :required="required"
            :error-messages="error"
            @input="$emit('input', content)"
            @change="$emit('change')"
            :filled="$vuetify.theme.dark"
        ></v-text-field>
    </div>
</template>

<script>
export default {
    name: "CustomInput",
    props: {
        type: { default: "text" },
        label: { required: false },
        value: { required: false },
        rules: { required: false },
        error: { required: false },
        required: { default: false },
    },
    data() {
        return {
            content: this.value,
        };
    },
    watch: {
        value() {
            this.content = this.value;
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
