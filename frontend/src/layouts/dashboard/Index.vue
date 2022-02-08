<template>
    <v-app class="lightGrey">
        <Header />
        <v-container
            class="wrapper"
            :style="{}"
            :class="$vuetify.breakpoint.name"
        >
            <Sidebar class="sidebar" ref="sidebar" />
            <v-main class="main">
                <slot> <!--CONTENT--> </slot>
            </v-main>
        </v-container>
    </v-app>
</template>

<script>
import Header from "./Header.vue";
import Sidebar from "./Sidebar.vue";
export default {
    name: "DashboardLayout",
    components: { Header, Sidebar },
};
</script>

<style lang="scss" scoped>
.wrapper {
    display: grid;
    grid-gap: 10px;
    grid-template-columns: auto 1fr;
    max-width: 1240px;

    &.xs,
    &.sm {
        grid-template-columns: 1fr;
        .main {
            margin-bottom: 56px;
        }
        .sidebar {
            grid-area: 2/1/3/2;
        }
    }
}
</style>
