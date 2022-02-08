<template>
    <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
            <v-btn  color="primary"  icon width="auto" height="auto"
                    v-bind="attrs"
                    v-on="on" outlined
            >
                <v-avatar>
                    <v-img class="outlined" v-if="$auth.user().avatar_url" :src="$auth.user().avatar_url" />
                    <v-icon v-else dark>mdi-account-circle</v-icon>
                </v-avatar>
            </v-btn>
        </template>
        <v-list>
            <v-list-item :to="{name: dashboardLink}">
                <v-list-item-title>{{$t('scoliotracker.dashboard')}}</v-list-item-title>
            </v-list-item>
            <v-list-item  @click="handleLogout">
                <v-list-item-title class="cursor-pointer">{{$t('scoliotracker.logout')}}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>

export default {
    name: "auth-user-dropdown",
    computed: {
        dashboardLink() {
            return this.$auth.user().primary_role_name === 'admin' ? 'admin.index' : 'dashboard.index'
        },
        auth() {
            return this.$auth
        }
    },
    data: function () {
        return {}
    },
    methods: {
        async handleLogout() {
            await this.$auth.logout()
            await this.$router.push({name: 'login'})
        },
    }
}
</script>

<style>
.v-img.outlined {
    border: 1px solid white;
    border-radius:50%;
    height: 56px;
    width: 56px;
}
</style>
