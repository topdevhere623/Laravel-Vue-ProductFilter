<template>
    <div style="min-height: 200px">
        <canvas  id="chart123"  height="80vh"  ref="canvas"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js/auto'

export default {
    name: 'IntervalsChart',
    props: ['periods' ,'on', 'off'],
    data() {
        return {
            chart: null,
            config: {},
        }
    },
    methods: {

    },
    mounted() {
        const ctx = this.$refs.canvas;
        console.log( this.on)
        console.log( this.off)
        console.log( this.periods)
        this.config = {
            type: 'bar',
            data: {
                labels: this.periods,
                datasets: [
                    {
                        data: this.on,
                        backgroundColor: '#4FB',
                        borderColor: '#888888',
                        borderWidth: 1,
                    },
                    {
                        data: this.off,
                        backgroundColor: '#84B',
                        borderColor: '#888888',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true
                    },
                    x: {
                        stacked: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };
        this.chart = new Chart(ctx,  this.config);
        this.$forceUpdate()
    },
}

</script>

