<template>
  <header>
    <v-container class="header text--dark" v-if="patient">
      <v-row v-if="!isMobile">
        <v-col>
          <v-row align="center">
            <v-col>
              <v-card rounded="lg" width="max-content">
                <logo />
              </v-card>
            </v-col>
            <v-col>
              <v-row align="center">
                <span class="mr-1">Статус: </span
                ><span class="font-weight-bold mr-3">{{
                  is_on_now ? "Надет" : "Снят"
                }}</span>
                <custom-button v-if="is_on_now" @click="putOff" color="light">
                  Снять
                </custom-button>
                <custom-button v-else @click="putOn" color="light">
                  Надеть
                </custom-button>
              </v-row>
            </v-col>
          </v-row>
        </v-col>
        <v-spacer></v-spacer>
        <v-col cols="auto" class="d-flex flex-row align-center">
          <span>{{ $date().format("DD.MM.YYYY") }}</span>

          <v-card class="px-2 ml-4 user" rounded="lg" width="max-content">
            <img :src="$auth.user().avatar_url" class="avatar" />
            <text-button :isActive="true" to="dashboard.profile">
              Привет, {{ $auth.user().name }}!
            </text-button>
            <span> | </span>
            <text-button @click="handleLogout">
              {{ $t("scoliotracker.logout") }}
            </text-button>
          </v-card>
        </v-col>
      </v-row>
      <div v-else>
        <v-row
          class="align-center font-weight-bold"
          :class="{
            'primary elevation-3': isMobile,
          }"
        >
          <v-col cols="12" class="d-flex justify-center">
            <a class="logo d-flex align-center" href="/">
              <img
                :src="require('@/assets/icons/logo.png')"
                height="42"
                alt="logo"
              />
            </a>
          </v-col>

          <v-col>
            <span>{{ $date().format("DD.MM.YYYY") }}</span>
          </v-col>
          <v-spacer></v-spacer>
          <v-col cols="auto">
            <text-button class="pa-0 font-weight-bold" @click="handleLogout">
              {{ $t("scoliotracker.logout") }}
            </text-button>
          </v-col>
        </v-row>
        <v-row class="align-center font-weight-bold">
          <v-col cols="auto">
            <span>Статус: </span
            ><span class="font-weight-bold mr-3">{{
              is_on_now ? "Надет" : "Снят"
            }}</span>
          </v-col>
          <v-spacer></v-spacer>
          <v-col cols="auto">
            <custom-button v-if="is_on_now" @click="putOff" color="light"
              >Снять</custom-button
            >
            <custom-button v-else color="light" @click="putOn">Надеть</custom-button
            >
          </v-col>
        </v-row>
      </div>
    </v-container>
  </header>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "Header",
  computed: {
    ...mapGetters({
      patient: "patient/item",
      is_on_now: "patient/is_on_now",
      timerEnable: "patient/timerEnable",
    }),
  },
  methods: {
    ...mapActions({
      setPatient: "patient/setItem",
      putOn: "patient/putOn",
      putOff: "patient/putOff",
    }),
    async handleLogout() {
      await this.$auth.logout();
      await this.$router.push({ name: "login" });
    },
  },
  mounted() {
    this.setPatient();
  },
};
</script>

<style lang="scss" scoped>
.header {
  max-width: 1240px;
}
.avatar {
  border-radius: 100% !important;
  max-width: 40px;
  margin-right: 10px;
}
.user {
  display: flex;
  align-items: center;
  padding: 10px;
}
</style>
