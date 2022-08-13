<template>
  <div>
    <b-row
      style="justify-content: space-evenly; align-items: center"
      class="my-4"
    >
      <b-col class="chart-container text-center">
        <div class="h6">مخطط عدد الطلاب بكل السنوات</div>
        <canvas id="myChart"></canvas>
      </b-col>
      <b-col class="chart-container text-center">
        <b-select
          v-model="selectedCourse"
          @change="getCourseChartData"
          :options="courses"
        />
        <div class="h6">
          مخطط اعلى علامة و المتوسط و اقل علامة في المادة المختارة
        </div>
        <canvas id="myChart2"></canvas>
      </b-col>

      <b-col class="chart-container text-center">
        <b-select
          v-model="selectedYear"
          @change="getYearChartData"
          :options="years"
        />
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

    axios
      .get("/api/get_students_year_count")
      .then((result) => {
        this.yearsStudentCount = result.data.map((item) => {
          return {
            name: item.name,
            count: item.student_count,
          };
        });

        const chartObject = {
          type: "doughnut",
          data: {
            labels: this.yearsStudentCount.map((item) => item.name),
            datasets: [
              {
                label: "عدد الطلاب في السنة الدراسية",
                data: this.yearsStudentCount.map((item) => item.count),
                backgroundColor: [
                  "rgba(255, 99, 132, 0.2)",
                  "rgba(54, 162, 235, 0.2)",
                  "rgba(255, 206, 86, 0.2)",
                  "rgba(75, 192, 192, 0.2)",
                  "rgba(153, 102, 255, 0.2)",
                ],
                borderColor: [
                  "rgba(255, 99, 132, 1)",
                  "rgba(54, 162, 235, 1)",
                  "rgba(255, 206, 86, 1)",
                  "rgba(75, 192, 192, 1)",
                  "rgba(153, 102, 255, 1)",
                ],
                borderWidth: 1,
              },
            ],
          },
          display: false,
        };
        new Chart(ctx, chartObject);
      })
      .catch(console.error);

    this.loadAllCourses();
    this.loadAllYears();
  },
  data() {
    return {
      yearsStudentCount: [],
      selectedCourse: {},
      courses: [],
      years: [],
      selectedYear: {},
    };
  },
  methods: {
    getCourseChartData() {
      axios
        .post(`/api/get_student_status/${this.selectedCourse}`)
        .then((result) => {
          console.log(result.data);
          const chartObject = {
            type: "bar",
            data: {
              labels: ["أقل علامة", "متوسط العلامات", "اعلى علامة"],
              datasets: [
                {
                  label: "علامة الطالب",
                  data: [result.data.max, result.data.avg, result.data.min],
                  backgroundColor: [
                    "rgba(75, 192, 192, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                    "rgba(255, 99, 132, 0.5)",
                  ],
                  borderColor: [
                    "rgba(75, 192, 192, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 99, 132, 1)",
                  ],
                  borderWidth: 1,
                },
              ],
            },
            display: false,
          };
          let chartStatus = Chart.getChart("myChart2"); // <canvas> id
          if (chartStatus != undefined) {
            chartStatus.destroy();
          }
          const ctx2 = document.getElementById("myChart2").getContext("2d");
          var chart = new Chart(ctx2, chartObject);
          // chart.destroy();
          // var chart = new Chart(ctx2, chartObject);
        })
        .catch(console.error);
    },
    loadAllCourses() {
      axios
        .post("/api/get_courses")
        .then((result) => {
          console.log(result.data);
          this.courses = result.data.courses.map((item) => {
            return {
              text: item.name,
              value: item.id,
            };
          });
        })
        .catch(console.error);
    },
    loadAllYears() {
      axios
        .post("/api/get_years")
        .then((result) => {
          console.log(result.data);
          this.years = result.data.years.map((item) => {
            return {
              text: item.name,
              value: item.id,
            };
          });
        })
        .catch(console.error);
    },
    getYearChartData() {
      axios
        .post(`/api/get_students_status_by_year/${this.selectedYear}`)
        .then((result) => {
          console.log(result.data);
          const chartObject = {
            type: "pie",
            data: {
              labels: [
                "الطلاب الناجحين",
                "الطلاب المنقولين",
                "الطلاب الراسبين",
              ],
              datasets: [
                {
                  label: "عدد الطالب",
                  data: [
                    result.data.success,
                    result.data.passed,
                    result.data.field,
                  ],
                  backgroundColor: [
                    "rgba(75, 192, 192, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                    "rgba(255, 99, 132, 0.5)",
                  ],
                  borderColor: [
                    "rgba(75, 192, 192, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 99, 132, 1)",
                  ],
                  borderWidth: 1,
                },
              ],
            },
            display: false,
          };
          let chartStatus = Chart.getChart("myChart3"); // <canvas> id
          if (chartStatus != undefined) {
            chartStatus.destroy();
          }
          const ctx2 = document.getElementById("myChart3").getContext("2d");
          var chart = new Chart(ctx2, chartObject);
          // chart.destroy();
          // var chart = new Chart(ctx2, chartObject);
        })
        .catch(console.error);
    },
  },
};
</script>
<style scoped>
.chart-container {
  width: 30% !important;
  height: 30% !important;
}
</style>