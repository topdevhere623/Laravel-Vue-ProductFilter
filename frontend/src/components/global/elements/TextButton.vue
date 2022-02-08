<template>
    <v-btn
        :class="{ 'font-weight-bold': isActive }"
        class="pa-0"
        min-width="0"
        plain
        @click="$emit('click')"
        :to="{
            name: to ? to : '',
        }"
    >
        <slot> </slot>
    </v-btn>
</template>

<script>
export default {
    name: "TextButton",
    props: {
        isActive: { default: true },
        to: {
            required: false,
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
