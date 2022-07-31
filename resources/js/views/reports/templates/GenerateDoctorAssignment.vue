<template>
  <div
    style="height: 99%; overflow-y: auto"
    v-if="doctor != null && date != null"
  >
    <div id="printable" style="margin: 1rem; padding: 1rem">
      <p class="data" style="font-size: 17px">
        جامعة حلب <br />
        كلية الهندسة المعلوماتية
      </p>
      <div style="display: block; text-align: center; margin-top: 5rem">
        <p style="text-align: center; font-size: 22px">السيد الاستاذ</p>
        <p
          class="data"
          style="
            text-align: center;

            font-size: 22px;
          "
        >
          {{ doctor.name }}
        </p>
        <p style="text-align: center; font-size: 22px">المحترم</p>
      </div>
      <div style="margin-top: 1rem; margin-left: 4rem; margin-right: 4rem">
        <p>رأينا تكليفكم بوضع اسئلة الدورة</p>
        <p class="data">{{ date.current }}</p>
        <p>للعاد الدراسي</p>
        <p class="data">{{ date.date }}</p>
        <p>، للمواد التي تدرسونها ، كما نرجو تقديمها</p>
        <p style="font-size: 23px; text-decoration: underline">
          قبل يومين من موعدها
        </p>
        <p>للأنسة رئيسة الامتحانات</p>
      </div>
      <div
        style="display: flex; justify-content: space-evenly; margin-top: 3rem"
      >
        <p>رئيسة شعبة الامتحانات</p>
        <p>رئيس الدائرة</p>
        <p>عميد كلية هندسة المعلوماتية</p>
      </div>
      <doctor-courses-table style="margin-top: 9rem" :id="object" />
    </div>
    <div class="floating-container">
      <div class="floating-button" @click="print">طباعة</div>
    </div>
  </div>
</template>

<script>
import DoctorCoursesTable from "../../../compos/reportes/generate/DoctorCoursesTable.vue";
import html2PDF from "jspdf-html2canvas";
export default {
  components: { DoctorCoursesTable },
  props: ["object"],
  mounted() {
    this.loadDoctor();
    this.loadDate();
  },
  data() {
    return {
      doctor: null,
      date: null,
    };
  },
  methods: {
    loadDoctor() {
      axios
        .post(`/api/get-doctor/${this.object}`)
        .then((result) => {
          this.doctor = result.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    loadDate() {
      axios
        .get("/api/dates")
        .then((result) => {
          this.date = {};
          var date = result.data;
          var startYear;
          const d = new Date();
          if (date.current === "first-tirm") startYear = d.getFullYear();
          else startYear = d.getFullYear() - 1;
          if (
            date.current === "first-tirm" ||
            date.current === "first-tirm-exam" ||
            date.current === "spring-holiday"
          ) {
            this.date.current = "الفصل الأول";
          } else this.date.current = "الفصل الثاني";
          this.date.date = `${startYear}/${startYear + 1}`;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    print() {
      let printable = document.getElementById("printable");
      html2PDF(printable, {
        jsPDF: {
          format: "a4",
        },
        imageType: "image/jpeg",
        output: `/pdf/${this.doctor.name}.pdf`,
      });
    },
  },
};
</script>

<style scoped>
p {
  font-size: 21px;
  display: inline;
  font-weight: 400;
}
.data {
  font-weight: 600;
}
</style>