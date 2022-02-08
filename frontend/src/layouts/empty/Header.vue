<template>
    <header class="primary elevation-3">
        <v-container class="header" :class="$vuetify.breakpoint.name">
            <logo />
            <nav class="nav dark--text" v-if="!$vuetify.breakpoint.smAndDown">
                <text-button :isActive="$route.name == 'login'" to="login">
                    {{ $t("scoliotracker.login") }}
                </text-button>
                <span>|</span>
                <text-button
                    :isActive="$route.name == 'register'"
                    to="register"
                >
                    {{ $t("scoliotracker.signup") }}
                </text-button>
            </nav>
        </v-container>
    </header>
</template>

<script>
export default {
    name: "Header",
};
</script>

<style lang="scss" scoped>
.header {
    padding: 10px;
    display: grid;
    grid-template-columns: 1fr auto;
    grid-gap: 15px;
    align-items: center;

    &.xs,
    &.sm {
        grid-template-columns: 1fr;
        justify-items: center;
    }

    .nav {
        display: grid;
        align-items: center;
        grid-auto-flow: column;
        grid-gap: 2px;
    }
}
</style>
