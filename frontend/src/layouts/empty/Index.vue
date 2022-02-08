<template>
    <v-app class="lightGrey">
        <Header />
        <v-main class="main">
            <v-container class="main--container">
                <slot> <!--CONTENT--> </slot>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import Header from "./Header.vue";
export default {
    name: "EmptyLayout",
    components: { Header },
};
</script>

<style lang="scss" scoped>
.main {
    &--container {
        height: 100%;
    }
}
</style>
