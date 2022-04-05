<template>
  <div class="marks-container">
    <button @click.prevent="printPDF">طباعة</button>
    <div id="printable" style="margin: 1rem; padding: 1rem">
      <p>
        جامعة حلب <br />
        كلية هندسة المعلوماتية
      </p>

      <p
        style="
          text-align: center;
          text-decoration: underline;
          font-size: 20px;
          display: block;
        "
      >
        كشف علامات
      </p>
      <div>
        <p>ندرج فيما يلي كشفاً بالمقررات التي درسها الطالب :</p>
        <p class="name">{{ student.name }}</p>
        <p>اسم الأب :</p>
        <p class="name">{{ student.father_name }}</p>
        <p>اسم الأم :</p>
        <p class="name">{{ student.mother_name }}</p>
        <p>المولود في :</p>
        <p class="name">{{ student.birth_place }}</p>
        <p>
          المتمتع بالجنسية العربية السورية خلال السنوات التي قضاها في كلية
          الهندسةالمعلوماتية جامعة حلب التي نالها في كل مقرر من عام
        </p>
        <p class="name">{{ firstYear }}</p>
        <!-- this would be the student first year we currentlly dont have it on our system -->
        <p>وحتى الدورة الفصلية</p>
        <p class="name">الأولى</p>
        <p>للعام الدراسي</p>
        <p class="name">{{ thisYear }}</p>

        <!-- this would be the current semester -->
        <p>المعدل العام</p>
        <!-- this would be the avrage of student marks -->
        <p class="name">{{ fullMark }}</p>
        <p>التقدير العام</p>
        <p class="name">جيد جداً</p>
        <p>وتخرج بموجب قرار مجلس جامعة حلب رقم /</p>
        <p class="name">1891651</p>
        <p>/ وتاريخ</p>
        <p class="name">2020</p>
      </div>
      <div v-if="this.year !== null">
        <div v-for="i in this.year.id" :key="i">
          <YearTable :yid="i" :sid="student.id" @avr="avrage" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import YearTable from "../../../compos/reportes/generate/YearTable.vue";
// import { jsPDF } from "jspdf";
import html2PDF from "jspdf-html2canvas";
export default {
  components: { YearTable },
  props: ["univID"],
  mounted() {
    this.getStudent();
  },
  data() {
    return {
      year: {},
      firstYear: "",
      thisYear: "",
      student: {},
      fullMark: 0.0,
    };
  },
  methods: {
    getStudent() {
      axios
        .get(`/api/get_student_by_id/${this.$props.univID}`)
        .then((res) => {
          console.log(res.data);
          this.student = res.data;
          this.getStudentYear();
          this.getStudentFirstYear();
          this.getThisYear();
        })
        .catch((err) => console.log(err));
    },
    getStudentYear() {
      const sid = this.student.id;
      axios
        .get(`/api/get_student_year/${sid}`)
        .then((res) => (this.year = res.data.year))
        .catch((err) => console.log(err));
    },
    getStudentFirstYear() {
      const sid = this.student.id;
      axios
        .get(`/api/get_student_first_year/${sid}`)
        .then((res) => {
          console.log(res.data.year);
          let _years = res.data.year.split("/");
          this.firstYear = `${_years[0]}/${_years[1]}`;
        })
        .catch((err) => console.log(err));
    },
    getThisYear() {
      let date = new Date();
      let _time = date.getFullYear();
      this.thisYear = `${_time - 1}/${_time}`;
    },
    avrage(avr) {
      this.fullMark += avr.avr;
      console.log(avr.i === this.year.id);
      if (avr.i === this.year.id) {
        let n = Math.floor((this.fullMark / avr.i) * 100) / 100;
        this.fullMark = n;
      }
    },
    printPDF() {
      let printable = document.getElementById("printable");
      html2PDF(printable, {
        jsPDF: {
          format: "a4",
        },
        imageType: "image/jpeg",
        output: "/pdf/generate.pdf",
      });
      // const doc = new jsPDF({
      //   orientation: "landscape",
      //   unit: "in",
      //   format: [4, 2],
      // });
    },
  },
};
</script>
<style scoped>
.marks-container {
  overflow-y: scroll;
}
.name {
  font-size: 19px;
  color: black;
}
p {
  font-size: 17px;
  display: inline;
  font-weight: 600;
}
</style>