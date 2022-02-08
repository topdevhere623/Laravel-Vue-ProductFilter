<template>
    <v-btn
        @click="$emit('click')"
        :color="color"
        :to="{
            name: to ? to : '',
        }"
        :disabled="disabled"
        class="rounded-lg font-weight-bold"
    >
        <slot></slot>
    </v-btn>
</template>

<script>
export default {
    name: "CustomButton",
    props: {
        isActive: { default: false },
        color: { default: "secondary" },
        to: {
            required: false,
        },
        disabled: { default: false },
    },
};
</script>

<style lang="scss" scoped>
</style>
