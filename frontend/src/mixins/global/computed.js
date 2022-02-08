export default {
    computed: {
        isMobile() {
            return this.$vuetify.breakpoint.smAndDown;
        },
        isAdmin() {
            return this.$auth.user().roles[0].name == 'admin';
        },
    },
};
