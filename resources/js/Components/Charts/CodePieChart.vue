<template>
  <apexchart
    type="donut"
    :options="chartOptions"
    :series="chartData.series"></apexchart>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
  name: "CodePieChart",

  components: {
    apexchart: VueApexCharts
  },

  props: {
    chartData: Object,
    type: {
      type: String,
      default: "code"
    }
  },

  setup(props) {
    const options = {
      chart: {
        type: "donut"
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        position: "bottom"
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: "bottom"
          }
        }
      }]
    };

    const chartOptions = computed(() => {
      switch (props.type) {
        case "code":
          return { ...options, labels: props.chartData.labels, colors: props.chartData.colors };
        case "user":
          return { ...options, labels: props.chartData.labels };
        default:
          return options;
      }
    });

    return {
      chartOptions
    };
  }
};
</script>

<style scoped>

</style>
