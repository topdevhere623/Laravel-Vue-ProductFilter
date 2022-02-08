<template>
    <dashboard-layout>
        <div v-if="$auth.user()">
            <v-row align="center">
                <v-col cols="auto">
                    <div v-if="workoutNotInProgress">
                        <CustomButton @click="startWorkout"
                            >Начать тренировку</CustomButton
                        >
                    </div>
                    <div v-if="workoutInProgress">
                        <CustomButton @click="endWorkout"
                            >Завершить</CustomButton
                        >
                    </div>
                </v-col>
                <v-spacer></v-spacer>
                <v-col cols="auto"
                    ><h4>
                        Перед началом тренировки необходимо снять корсет!
                    </h4></v-col
                >
            </v-row>
        </div>
        <div v-if="workouts.length > 0">
            <div
                v-for="workout in workouts"
                :key="`workout-` + workout.id"
            ></div>
        </div>

        <v-container>
            <MobileTable v-if="isMobile" :headers="headers" :items="workouts" />
            <CustomTable v-else :headers="headers" :items="workouts" />
        </v-container>
        <edit-workout-modal
            @saved="handleSuccessfulSave"
            @click:outside="showEditWorkoutModal = false"
            :workout="editedWorkout"
            v-if="showEditWorkoutModal"
        />
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../layouts/dashboard/Index";
import Workout from "../../../models/Workout";
import EditWorkoutModal from "../../../components/modals/EditWorkoutModal";

export default {
    name: "dashboard-index",
    components: { EditWorkoutModal, DashboardLayout },
    computed: {
        workoutNotInProgress() {
            let user = this.$auth.user();
            return Boolean(
                user &&
                    user.patient &&
                    (!user.patient.latest_workout ||
                        user.patient.latest_workout.ended_at)
            );
        },
        workoutInProgress() {
            let user = this.$auth.user();
            return (
                user &&
                user.patient &&
                user.patient.latest_workout &&
                !user.patient.latest_workout.ended_at
            );
        },
    },
    created() {
        this.headers = [
            {
                text: "Начало",
                value: "started_at",
                formatter: (v) => this.$date(v).format("DD.MM H:mm:ss"),
            },
            {
                text: "Конец",
                value: "ended_at",
                formatter: (v) => this.$date(v).format("DD.MM H:mm:ss"),
                default: "Сейчас",
            },
            {
                text: "Всего времени",
                value: "duration_for_humans",
                formatter: (v, obj) => (obj.ended_at ? v : "Сeйчас"),
            },
            {
                text: "Название",
                value: "note",
                formatter: (v) => v.substring(0, 25),
            },
        ];
    },
    data: function () {
        return {
            workouts: [],
            showEditWorkoutModal: false,
            editedWorkout: {},
        };
    },
    methods: {
        async init() {
            this.workouts = await Workout.get();
            this.$auth.fetch();
        },
        async endWorkout() {
            let patient = this.$auth.user().patient;
            let workout = patient.latest_workout;
            await Workout.custom(`/workouts/${workout.id}/end`).get();
            await this.init();
        },
        async startWorkout() {
            if(this.$auth.user().patient.is_on_now === true) {
                alert("Put off the Corset");
            } else {
                let workout = new Workout({});
                await workout.save();
                await this.init();
            }
        },
        async handleCreateWorkout() {
            this.showEditWorkoutModal = true;
        },
        async editWorkout(workout) {
            this.editedWorkout = workout;
            this.showEditWorkoutModal = true;
        },
        handleSuccessfulSave() {
            this.editedWorkout = {};
            this.init();
        },
    },
    mounted() {
        this.init();
    },
};
</script>

<style scoped>
</style>
