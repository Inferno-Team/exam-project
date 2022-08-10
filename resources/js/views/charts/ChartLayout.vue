<template>
  <div>
    <b-row style="justify-content: space-evenly" class="my-4">
      <b-col class="chart-container text-center">
        <div class="h6">مخطط عدد الطلاب بكل السنوات</div>
        <canvas id="myChart"></canvas>
      </b-col>
      <b-col class="chart-container text-center">
        <div class="h6">مخطط عدد الطلاب بكل السنوات</div>
        <canvas id="myChart2"></canvas>
      </b-col>
      <b-col class="chart-container text-center">
        <div class="h6">مخطط عدد الطلاب بكل السنوات</div>
        <canvas id="myChart3"></canvas>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import Chart from "chart.js/auto";
export default {
  mounted() {
    const ctx = document.getElementById("myChart");
    const ctx2 = document.getElementById("myChart2");
    const ctx3 = document.getElementById("myChart3");
    const chartObject = {
      type: "doughnut",
      data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
          {
            label: "# of Votes",
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(255, 159, 64, 0.2)",
            ],
            borderColor: [
              "rgba(255, 99, 132, 1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)",
            ],
            borderWidth: 1,
          },
        ],
      },
      display: false,
      //   options: {
      //     scales: {
      //       y: {
      //         beginAtZero: true,
      //       },
      //     },
      //   },
    };
    new Chart(ctx, chartObject);
    new Chart(ctx2, chartObject);
    new Chart(ctx3, chartObject);
  },
};
</script>
<style scoped>
.chart-container {
  width: 30% !important;
  height: 30% !important;
}
</style>