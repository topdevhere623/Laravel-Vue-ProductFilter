<template>
    <empty-layout>
        <div
            class="flex-wrapper-full-background d-flex fill-height"
            style="width: 100%"
        >
            <v-card
                class="mx-auto my-auto pa-5 dark--text"
                max-width="500"
                min-width="350"
                raised
                rounded="xl"
            >
                <v-card-title
                    ><span class="font-weight-bold mx-auto">{{
                        $t("scoliotracker.register")
                    }}</span></v-card-title
                >
                <v-card-text>
                    <v-form>
                        <v-row>
                            <v-col>
                                <custom-input
                                    :error="errors.email"
                                    :label="$t('scoliotracker.email')"
                                    v-model="email"
                                />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <custom-input
                                    :error="errors.password"
                                    type="password"
                                    :label="$t('scoliotracker.password')"
                                    v-model="password"
                                />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <custom-input
                                    :error="errors.confirmPassword"
                                    type="password"
                                    :label="
                                        $t('scoliotracker.confirm_password')
                                    "
                                    v-model="confirmPassword"
                                />
                            </v-col>
                        </v-row>
                        <custom-button
                            class="text-uppercase"
                            style="width: 100%"
                            @click="handleRegister"
                            >{{ $t("scoliotracker.signup") }}</custom-button
                        >
                    </v-form>
                </v-card-text>
                <v-card-actions class="text-center justify-space-around">
                    <v-row class="align-center justify-center">
                        <text-button to="login">
                            {{ $t("scoliotracker.have_account") }}
                        </text-button>
                    </v-row>
                </v-card-actions>
            </v-card>
        </div>
    </empty-layout>
</template>

<script>
export default {
    name: "Register",
    components: { EmptyLayout: () => import("../layouts/empty/Index.vue") },

    data: function () {
        return {
            email: "",
            password: "",
            confirmPassword: "",
            errors: {},
        };
    },

    methods: {
        async handleRegister() {},
    },
};
</script>

<style scoped lang="scss">
</style>
