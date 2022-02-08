<template>
    <aside class="sidebar" :class="$vuetify.breakpoint.name">
        <v-card
            rounded="lg"
            class="nav"
            v-if="!isMobile"
        >
            <v-navigation-drawer
                width="max-content"
                permanent
                :mini-variant="mini"
            >
                <v-list class="pa-0">
                    <v-list-item-group color="light" active-class="secondary">
                        <v-list-item
                            link
                            :to="{ name: route.name }"
                            v-for="(route, i) in routes"
                            :key="i"
                        >
                            <v-icon class="mr-2">{{ route.meta.icon }}</v-icon>

                            <v-list-item-title class="d-flex mr-0">{{
                                route.meta.text
                            }}</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>

                <template v-slot:append>
                    <v-list>
                        <v-list-item @click="mini = !mini">
                            <v-icon
                                :class="{ 'mdi-rotate-180': mini }"
                                class="mr-2"
                                >mdi-arrow-left-drop-circle-outline
                            </v-icon>

                            <v-list-item-title>Свернуть</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </template>
            </v-navigation-drawer>
        </v-card>
        <v-bottom-navigation v-else color="light" hide-on-scroll fixed>
            <v-btn
                active-class="secondary"
                :to="{ name: route.name }"
                v-for="(route, i) in routes"
                :key="i"
            >
                <v-icon>{{ route.meta.icon }}</v-icon>
            </v-btn>
        </v-bottom-navigation>
    </aside>
</template>

<script>
import routes from "@/router/dashboard.routes";
export default {
    name: "Sidebar",
    data() {
        return {
            mini: false,
        };
    },
    computed: {
        routes() {
            return routes.filter((route) => route.meta.visible);
        },
    },
};
</script>

<style lang="scss" scoped>
.sidebar {
    position: relative;
    .nav {
        position: sticky;
        box-sizing: border-box;
        top: 0;
        height: 85vh;
    }
}
</style>
