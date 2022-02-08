<template>
    <dashboard-layout>
        <v-form class="latest">
            <v-row class="x-ray">
                <v-col cols="4">
                    <span> {{ $date($auth.user().patient.latest_xray.created_at).format("DD.MM.YYYY") }} </span>
                    <img :src="$auth.user().patient.latest_xray.file_url" class="screen" />
                </v-col>
                <v-col>
                    <h4>Комментарий врача</h4>
                    <v-card class="latest-comments" rounded="lg">
                        <v-card-text class="latest-note">
                            <span> {{ $auth.user().patient.latest_xray.note }} </span>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-form>
        <v-form>
            <v-row class="x-ray">
                <v-col cols="4">
                    <span>Дата</span>
                    <CustomFileUpload
                        label="Загрузить фото"
                        v-model="newXray.file_url"
                        directory="xrays"
                        class="body"
                    />
                </v-col>
                <v-col>
                    <h4>Комментарий врача</h4>
                    <v-card class="body" rounded="lg">
                        <v-card-text>
                            <v-textarea
                                dense
                                flat
                                solo
                                v-model="newXray.note"
                                placeholder="Оставьте комментарий из Вашей медицинской карты..."
                                elevation="0"
                                color="dark"
                            ></v-textarea>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-form>
        <v-row justify="end">
            <v-col cols="auto">
                <CustomButton @click="saveXray">Сохранить</CustomButton>
            </v-col>
        </v-row>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../layouts/dashboard/Index";
import Xray from "../../../models/Xray";

export default {
    name: "dashboard-index",
    components: { DashboardLayout },
    computed: {},
    data: function () {
        return {
            xrays: [],
            newXray: {},
        };
    },
    methods: {
        async init() {
            this.xrays = await Xray.get();
        },
        async saveXray() {
            if(this.newXray.note !== undefined && this.newXray.file_url !== undefined) {
                console.log('newXray', this.newXray.file_url);
                let xray = new Xray(this.newXray);
                await xray.save();
                this.newXray = {};
                await this.init();
            } else {
                alert("PLease upload photo or add comments!");
            }
        },
    },
    mounted() {
        this.init();
    },
};
</script>

<style scoped>
.x-ray {
    padding-left: 16px;
}
.body {
    margin-top: 20px;
}
.latest-comments {
    margin-top: 20px;
    height: 64%;
    object-fit: cover;
}
.latest-note {
    font-size: 17px;
}
.latest {
    height: 36%;
    margin-bottom: 40px;
}
.screen {
    width: 100%;
    height: 65%;
    border-radius: 10px;
    margin-top: 20px;
    object-fit: cover;
}
</style>
