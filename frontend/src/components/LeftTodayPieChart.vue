<template>
  <div style="height: 300px; width: 300px">
    <canvas id="left-today" ref="canvas"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
  name: "LeftTodayPieChart",
  props: ["leftSeconds", "alreadySeconds"],
  data() {
    return {
      chart: null,
      config: {},
    };
  },
  mounted() {
    const ctx = this.$refs.canvas;
    this.config = {
      type: "doughnut",
      data: {
        labels: ["Уже", "Осталось"],
        datasets: [
          {
            label: "My First Dataset",
            data: [this.alreadySeconds, this.leftSeconds],
            backgroundColor: ["rgb(54, 162, 235)", "rgb(255, 99, 132)"],
            hoverOffset: 4,
          },
        ],
      },
      options: {
        responsive: true,
      },
    };
    this.chart = new Chart(ctx, this.config);
    this.$forceUpdate();
  },
};
</script>

<style scoped>
</style>
