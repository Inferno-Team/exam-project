<template>
  <div class="marks-container">
    <div class="floating-container">
      <div class="floating-button" @click.prevent="printPDF">طباعة</div>
    </div>

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
          الهندسة المعلوماتية جامعة حلب التي نالها في كل مقرر من عام
        </p>
        <p class="name">{{ firstYear }}</p>
        <!-- this would be the student first year we currentlly dont have it on our system -->
        <p>وحتى الدورة الفصلية</p>
        <!-- this would be the current semester -->
        <p class="name">{{ thisSemester }}</p>
        <p>للعام الدراسي</p>
        <p class="name">{{ thisYear }}</p>

        <p>المعدل العام</p>
        <!-- this would be the avrage of student marks -->
        <p class="name">{{ fullMark }}</p>
        <p>التقدير العام</p>
        <p class="name">{{ rank }}</p>
        <div
          style="display: inline"
          v-if="this.object.graduationNumber !== null"
        >
          <p>وتخرج بموجب قرار مجلس جامعة حلب رقم /</p>
          <p class="name">{{ object.graduationNumber }}</p>
          <p>/ وتاريخ</p>
          <p class="name">{{ object.graduationDate }}</p>
        </div>
      </div>
      <div v-if="this.year !== null">
        <div v-for="i in this.year.id" :key="i">
          <YearTable :yid="i" :sid="student.id" @avr="avrage" />
        </div>
      </div>
      <div style="margin-right: 1rem">
        <h6 class="under-line">
          وثيقة تبرع بالدم رقم / {{ this.object.blood }} / تاريخ
          {{ this.object.bloodDate }} صادرة عن بنك الدم بحلب.
        </h6>
        <h6 class="under-line">
          سددت الرسوم بموجب إيصال رقم / {{ this.object.check }} / تاريخ
          {{ this.object.checkDate }}
        </h6>
        <h6 v-if="this.object.graduationNumber !== null" class="under-line">
          اُعطي هذا الكشف بموجب وثيقة التخرج رقم /
          {{ this.object.graduationNumber }} / وبتاريخ
          {{ this.object.graduationDate }}
        </h6>
      </div>
      <div class="mx-auto in-the-end">
        <div style="max-width: fit-content">
          <p>المسجل</p>
          <div class="empty-space"></div>
        </div>
        <div style="max-width: fit-content">
          <p>المدقق</p>
          <div class="empty-space"></div>
        </div>

        <div style="max-width: fit-content; text-align: center">
          <p>رئيس شعبة الامتحانات</p>
          <div class="empty-space">
            <p>م.سمى صباغ</p>
          </div>
        </div>
        <div style="max-width: fit-content; text-align: center">
          <p>عميد الكلية</p>
          <div class="empty-space">
            <p>أ.د.محمد الحميد</p>
          </div>
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
  props: ["object"],
  mounted() {
    this.getStudent();
    this.getThisSemester();
  },
  data() {
    return {
      year: {},
      firstYear: "",
      thisYear: "",
      student: {},
      fullMark: 0.0,
      rank: "",
      thisSemester: "",
    };
  },
  methods: {
    getStudent() {
      axios
        .get(`/api/get_student_by_id/${this.$props.object.univID}`)
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
      this.fullMark += parseFloat(avr.avr);
      console.log(this.fullMark);
      if (avr.i === this.year.id) {
        this.fullMark /= avr.i;
        this.fullMark = parseFloat(this.fullMark.toFixed(2));
        if (this.fullMark < 60) {
          this.rank = "راسب";
        } else if (this.fullMark >= 60 && this.fullMark < 75.0) {
          this.rank = "جيد";
        } else if (this.fullMark >= 75.0 && this.fullMark < 90) {
          this.rank = "جيد جداً";
        } else if (this.fullMark >= 90 && this.fullMark < 95) {
          this.rank = "ممتاز";
        } else {
          this.rank = "ممتاز مع مرتبة الشرف";
        }
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
    getThisSemester() {
      axios
        .get("/api/dates")
        .then((result) => {
          let date = result.data;
          if (date == null) this.thisSemester = "فصل الاول";
          else {
            if (
              date.current === "first-tirm" ||
              date.current === "first-tirm-exam" ||
              date.current === "spring-holiday"
            )
              this.thisSemester = "فصل الاول";
            else this.thisSemester = "فصل الثاني";
          }
        })
        .catch((err) => {});
    },
  },
};
</script>
<style scoped>
.marks-container {
  overflow-y: auto;
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
.under-line {
  margin-top: 0.5rem;
  text-decoration-line: underline;
  font-weight: 600;
  text-underline-offset: 0.125rem;
}
.in-the-end {
  justify-content: space-evenly;
  display: flex;
}
.empty-space {
  height: 100px;
  padding: 2rem;
}
</style>