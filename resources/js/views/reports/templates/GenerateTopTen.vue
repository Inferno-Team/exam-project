<template>
  <div style="height: 100%; display: flex; justify-content: center">
    <div class="floating-container">
      <div class="floating-button" @click.prevent="print">طباعة</div>
    </div>
    <div class="table-container" id="printable">
      <table>
        <thead>
          <tr>
            <th scope="row">تسلسل</th>
            <th scope="row">رقم الطالب الجامعي</th>
            <th scope="row">اسم الطالب</th>
            <th scope="row">المعدل</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(student, i) in students" :key="i">
            <th scope="row">{{ i + 1 }}</th>
            <th scope="row">{{ student.univ_id }}</th>
            <th scope="row">{{ student.name }}</th>
            <th scope="row">{{ student.fullMark.toFixed(3) }}</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import html2PDF from "jspdf-html2canvas";

export default {
  props: ["id"],
  mounted() {
    this.loadStudent(this.id);
  },
  data() {
    return {
      students: [],
    };
  },
  methods: {
    loadStudent(id) {
      axios
        .post(`/api/get_student_top_ten/${id}`)
        .then((response) => {
          this.students = response.data;
        })
        .catch(console.error);
    },
    print() {
      let printable = document.getElementById("printable");
      html2PDF(printable, {
        jsPDF: {
          format: "a4",
        },
        imageType: "image/jpeg",
        output: `/pdf/ملف العشر الاوائل للسنة الدراسية ${this.id}.pdf`,
      });
    },
  },
};
</script>

<style scoped>
th,
td {
  border: 1px solid;
  padding: 0.5rem;
  /* display: block; */
}
.table-container {
  overflow-y: auto;
  width: 88%;
}
table {
  width: 100%;
  margin-top: 5rem;
  border-collapse: collapse;
}
.floating-container {
  position: absolute !important;
}
</style>