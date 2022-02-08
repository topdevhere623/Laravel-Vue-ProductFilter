<template>
  <div class="rounded-lg pa-4 w-100 light elevation-3">
    <div class="track rounded-lg lightBlue mb-5">
      <div
        class="value secondary rounded-lg"
        v-for="(value, i) in values"
        :key="i"
        :style="{
          right: getRight(value),
          left: getLeft(value),
        }"
      >
        <div class="d-flex flex-row mt-4 justify-center">
          <span>{{ getLeftTime(value) }}</span> -
          <span>{{ getRightTime(value) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    intervals: {
      default: [],
    },
    currentDate: {
      default: null,
    },
  },
  data() {
    return {
      values: null,
      startTime: null,
      endTime: null,
    };
  },
  watch: {
    intervals() {
      this.values = this.intervals;
    },
  },
  methods: {
    getRight(value) {
      let end = new Date(value.ended_at);
      let currentDateString = new Date(this.currentDate).toDateString();
      const endTime = `${currentDateString} 11:59:59 PM`;
      const utcEndTime = new Date(endTime);
      if (end.getTime() >= utcEndTime.getTime()) {
        return 0;
      }
      let midnight = new Date(new Date(value.ended_at).setHours(24, 0, 0, 0));
      let minutes = Math.round((midnight - end) / 1000 / 60);

      return minutes >= 0 ? (minutes * 100) / 1440 + "%" : "0";
    },
    getLeft(value) {
      let start = new Date(value.started_at);
      let currentDateString = new Date(this.currentDate).toDateString();
      const startTime = `${currentDateString} 12:00:00 AM`;
      const utcStartTime = new Date(startTime);
      if (start.getTime() < utcStartTime.getTime()) {
        return 0;
      }
      let midnight = new Date(new Date(value.started_at).setHours(0, 0, 0, 0));
      let minutes = Math.round((start - midnight) / 1000 / 60);
      return (minutes * 100) / 1440 + "%";
    },
    getRightTime(value) {
      let end = new Date(value.ended_at);
      let currentDateString = new Date(this.currentDate).toDateString();
      const endTime = `${currentDateString} 11:59:59 PM`;
      const utcEndTime = new Date(endTime);
      if (end.getTime() >= utcEndTime.getTime()) {
        return "24:00";
      }
      return this.$date(value.ended_at).format("H:mm");
    },
    getLeftTime(value) {
      let start = new Date(value.started_at);
      let currentDateString = new Date(this.currentDate).toDateString();
      const startTime = `${currentDateString} 12:00:00 AM`;
      const utcStartTime = new Date(startTime);
      if (start.getTime() < utcStartTime.getTime()) {
        return "00:00";
      }
      return this.$date(value.started_at).format("H:mm");
    },
  },
};
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
</style>
