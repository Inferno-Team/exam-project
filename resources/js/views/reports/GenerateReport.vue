<template>
  <div>
    <div class="report-container">
      <Report
        v-for="(_, index) in this.reports"
        :data="reports[index]"
        :key="index"
        :index="index"
        @report-click="click"
      />
      <StudentSearchField
        @generate="generate"
        @reset-values="reset"
        style="position: absolute; right: 50%; top: 0%"
        :is_shows="is_shows"
      />
    </div>
  </div>
</template>
<script>
import Report from "../../compos/Report.vue";
import StudentSearchField from "../../compos/reportes/StudentSearchField.vue";

export default {
  components: {
    Report,
    StudentSearchField,
  },
  data() {
    return {
      reports: [
        {
          title: "توليد كشف علامات",
          desc: "",
        },
      ],
      is_shows: false,
    };
  },
  methods: {
    click(event) {
      const _index = event.target.id;
      if (_index === "0") {
        this.is_shows = !this.is_shows;
      }
    },
    generate(univ_id) {
      console.log(univ_id);
      this.checkStudent(univ_id);
    },
    reset(value) {
      this.is_shows = value;
    },
    checkStudent(univ_id) {
      this.$router.push({
        name: "marks_report",
        params: { univID: univ_id },
      });
     
    },
  },
};
</script>
<style scoped>
.report-container {
  display: grid;
  grid-template-columns: repeat(2, minmax(92px, 0.5fr));
  justify-items: center;
  gap: 10px;
}
</style>