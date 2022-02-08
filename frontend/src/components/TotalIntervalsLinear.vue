<template>
  <div class="rounded-lg pa-4 w-100" v-if="intervals">
    <v-row v-if="patientIsOnNow">
      <span class="time">Текущая сессия: {{ time }}</span>
    </v-row>
    <div class="track rounded-lg lightBlue mb-5">
      <div
        class="value gradient rounded-lg"
        :style="{
          right: getSum(),
          left: 0,
        }"
      >
        <div class="total flex-row mt-4 justify-start">
          <span>Total: {{ getFormatedFromSeconds(getTotal()) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: {
    intervals: {
      required: true,
      default: null,
    },
    currentDate: {
      default: null,
    },
    patientIsOnNow: {
      default: false,
    },
  },
  data() {
    return {
      values: [],
      time: '00:00:00',
      timer: null,
      timeBegan: null,
      timeStopped: null,
      stoppedDuration: 0,
      started: null,
      running: false,
      loaded: false,
    }
  },

  watch: {
    intervals() {
      this.values = this.intervals
    },
    patientIsOnNow() {
      this.startOrStopTimer()
    },
  },
  created() {
    this.startOrStopTimer()
  },
  methods: {
    ...mapActions({
      setIntervals: "interval/setItems",
    }),
    getSum() {
      let sum = 0;
      for (let i = 0; i < this.values.length; i++) {
        let value = this.values[i];
        let diffTime = 0;
        let start = new Date(value.started_at);
        let end = new Date(value.ended_at);
        let currentDateString = new Date(this.currentDate).toDateString();
        const currentStartTime = new Date(`${currentDateString} 12:00:00 AM`);
        const currentEndTime = new Date(`${currentDateString} 11:59:59 PM`);
        if (start.getTime() < currentStartTime.getTime()) {
          diffTime = end.getTime() - currentStartTime.getTime();
        } else if (end.getTime() >= currentEndTime.getTime()) {
          diffTime = currentEndTime.getTime() - start.getTime() + 1000;
        } else {
          diffTime = end.getTime() - start.getTime();
        }
        sum += diffTime;
      }

      let seconds = sum / 1000;
      return 100 - (seconds * 100) / (3600 * 24) + '%';
    },
    getTotal() {
      let sum = 0;
      for (let i = 0; i < this.values.length; i++) {
        let value = this.values[i];
        let diffTime = 0;
        let start = new Date(value.started_at);
        let end = new Date(value.ended_at);
        let currentDateString = new Date(this.currentDate).toDateString();
        const currentStartTime = new Date(`${currentDateString} 12:00:00 AM`);
        const currentEndTime = new Date(`${currentDateString} 11:59:59 PM`);
        if (start.getTime() < currentStartTime.getTime()) {
          diffTime = end.getTime() - currentStartTime.getTime();
        } else if (end.getTime() >= currentEndTime.getTime()) {
          diffTime = currentEndTime.getTime() - start.getTime() + 1000;
        } else {
          diffTime = end.getTime() - start.getTime();
        }

        sum += diffTime;
      }
      return sum / 1000;
    },
    getFormatedFromSeconds(seconds) {
      return new Date(seconds * 1000).toISOString().substr(11, 8);
    },
    start() {
      if (this.running) return;
      this.setIntervals(new Date(this.currentDate).toDateString());

      if (localStorage.getItem('timeBegan') === null) {
        this.reset()
        this.timeBegan = new Date()
        localStorage.setItem('timeBegan', this.timeBegan.toString())
      }

      if (this.timeStopped !== null) {
        this.stoppedDuration += new Date() - this.timeStopped
      }

      this.started = setInterval(this.clockRunning, 1000)
      this.running = true
    },
    stop() {
      this.running = false
      this.timeBegan = null
      localStorage.removeItem('timeBegan')
      this.timeStopped = new Date()
      clearInterval(this.started)
    },
    reset() {
      this.running = false;
      clearInterval(this.started);
      this.stoppedDuration = 0;
      this.timeStopped = null;
      this.time = "00:00:00";
    },
    clockRunning() {
      let startTime = localStorage.getItem('timeBegan');

      if (this.isToday()) {
        if (this.intervals.length > 0) {
          startTime = this.intervals[0].started_at
          this.intervals[0].ended_at = new Date().toString()
        }
      }

      let timeDiff = new Date().getTime() - new Date(startTime).getTime();

      this.time = this.getFormatedFromSeconds(timeDiff / 1000);
    },
    startOrStopTimer() {
      if (this.patientIsOnNow) {
        this.start()
      } else {
        this.stop()
      }
    },
    isToday() {
      if (
        new Date(this.currentDate).toDateString() == new Date().toDateString()
      )
        return true
      else return false
    },
  },
}
</script>

<style lang="scss" scoped>
.track {
  height: 10px;
  border-radius: 5px;
  width: 100%;

  position: relative;
  .value {
    position: absolute;
    top: 0;
    bottom: 0;
  }
}
.gradient {
  background: linear-gradient(90deg, #6477d8 0%, #69a79e 50.21%, #6dd864 100%);
}
.time {
  margin-left: 12px;
  margin-bottom: 20px;
}
.total {
  width: 120px;
}
</style>
