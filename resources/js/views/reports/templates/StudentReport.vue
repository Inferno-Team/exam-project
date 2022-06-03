<template>
  <div>
    <YearTab :years="years" @selectYear="onSelectedYearChange" />
    <YearStudentsTable :students="students" />
    <button @click.prevent="printXLSX">طباعة</button>
  </div>
</template>
<script>
import YearTab from "../../../compos/reportes/generate/YearTab.vue";
import YearStudentsTable from "../../../compos/reportes/generate/YearStudentsTable.vue";
let XLSX = require("xlsx");

export default {
  props: ["object"],
  components: { YearTab, YearStudentsTable },
  mounted() {
    this.getYears();
    switch (this.$props.object) {
      case "ناجح":
        {
          // send get request for all successed student with tap to select student year
        }
        break;
      case "راسب":
        {
          // send get request for all passed student with tap to select student year
        }
        break;
      case "منقول":
        {
          // send get request for all failure student with tap to select student year
        }
        break;
    }
  },
  methods: {
    getYears() {
      axios
        .post("/api/get_years")
        .then((response) => {
          this.years = response.data.years;
        })
        .catch((error) => console.log(error));
    },
    onSelectedYearChange(id) {
      this.loadStudent(id, this.object);
    },
    printXLSX() {
      if (this.students.length == 0) return;
      const invoices = this.students.reduce((ac, student) => {
        ac.push({
          id: student.student.id,
          univ_id: student.student.univ_id,
          name: student.student.name,
        });
        return ac;
      }, []);

      var invoicesWS = XLSX.utils.json_to_sheet(invoices);
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, invoicesWS, "لائحة الطلاب");
      XLSX.writeFile(wb, "student.xlsx");
    },
    loadStudent(yearId, type) {
      axios
        .get(`/api/get_year_student_with_type/${yearId}/${type}`)
        .then((response) => {
          this.students = response.data;
        })
        .catch((error) => console.log(error));
    },
  },
  data() {
    return {
      years: [],
      students: [],
    };
  },
};
</script>