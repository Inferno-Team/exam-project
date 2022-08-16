<template>
  <div style="overflow-y: auto">
    <div class="floating-container" v-if="students.length > 0">
      <div class="floating-button" @click.prevent="saveToDatabase">طباعة</div>
    </div>
    <div class="tables" id="printable">
      <div v-if="selected" class="mx-5 px-5">
        <p>
          الجمهوية العربية السورية <br />
          جامعة حلب <br />
          كلية هندسة المعلوماتية
        </p>
        <p class="centered">جدول العلامات ونسب النجاح في مقرر</p>
        <p class="centered">{{ course.name }}</p>
        <p class="centered">مستجدون</p>
        <p class="centered">عدد المتقدمين {{ students.length }}</p>
        <div
          v-if="!editState"
          style="width: 9rem; text-align: end"
          class="me-auto"
        >
          <p style="display: block">الكلي : {{ passedAllMark }}%</p>
          <p style="display: block; text-align: start">نسبة النجاح</p>
          <p style="display: block">النظري : {{ passedMark2 }}%</p>
        </div>
      </div>

      <table v-if="students.length > 0" class="mx-auto my-4">
        <tr>
          <td>ت</td>
          <td>الرقم الجامعي</td>
          <td>الاسم والكنية</td>
          <td>العملي</td>
          <td>النظري</td>
          <td>المجموع</td>
          <td>كتابة</td>
          <td>النتيجة</td>
        </tr>
        <tr v-for="(student, i) in students" :key="i">
          <th scope="row">{{ i + 1 }}</th>
          <th scope="row">{{ student.univ_id }}</th>
          <th scope="row">{{ student.name }}</th>
          <th scope="row">{{ student.mark1 }}</th>
          <editable-row-item
            :data="student.mark2"
            :state="student.mark2State"
            @change="onMark2Changed"
            :insideId="i"
          />
          <th scope="row">{{ student.fullMark }}</th>
          <th scope="row">{{ student.fullMarkWrite }}</th>
          <th scope="row">{{ student.result }}</th>
        </tr>
      </table>
      <div v-if="students.length > 0" class="mx-auto in-the-end">
        <div style="max-width: fit-content">
          <p>أعضاء لجنة الرصد</p>
          <div class="empty-space"></div>
        </div>
        <div style="max-width: fit-content">
          <p>المسجل</p>
          <div class="empty-space"></div>
        </div>
        <div style="max-width: fit-content">
          <p>المدقق</p>
          <div class="empty-space"></div>
        </div>
        <div style="max-width: fit-content">
          <p>رئيس اللجنة</p>
          <div class="empty-space"></div>
        </div>
        <div style="max-width: fit-content;text-align: center;">
          <p>رئيس شعبة الامتحانات</p>
          <div class="empty-space">
            <p>م.سمى صباغ</p>
          </div>
        </div>
        <div style="max-width: fit-content;text-align: center;">
          <p>عميد الكلية</p>
          <div class="empty-space">
            <p>أ.د.محمد الحميد</p>
          </div>
        </div>
      </div>
      <b-form-select
        v-if="students.length === 0 && !selected"
        :options="courses"
        class="mx-auto my-5"
        v-on:change="onChange"
        v-model="course"
      ></b-form-select>
    </div>
  </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import * as XLSX from "xlsx";
import { toArabicWord } from "number-to-arabic-words/index.js";
import html2PDF from "jspdf-html2canvas";
import EditableRowItem from "../../compos/reportes/generate/EditableRowItem.vue";
export default {
  components: { vueDropzone: vue2Dropzone, EditableRowItem },
  data() {
    return {
      students: [],
      selected: false,
      courses: [],
      course: {},
      allStudentsEditCount: 0,
      passedMark2: 0,
      passedAllMark: 0,
      editState: true,
      dropzoneOptions: {
        acceptedFiles:
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        url: "https://httpbin.org/post",
        autoProcessQueue: false,
        maxFilesize: 0.5,
        addRemoveLinks: true,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        maxFiles: 1,

        thumbnailMethod: "contain",
      },
    };
  },
  methods: {
    vfileAdded(file) {
      const reader = new FileReader();

      reader.onload = (event) => {
        var data = new Uint8Array(event.target.result);
        let workbook = XLSX.read(data, { type: "array" });
        let first_sheet_name = workbook.SheetNames[0];
        let worksheet = workbook.Sheets[first_sheet_name];
        let _students = XLSX.utils.sheet_to_json(worksheet, {
          header: 1,
        });
        console.log(_students);
        _students.forEach((student) => {
          if (student !== _students[0])
            this.students.push({
              id: student[0],
              univ_id: student[1],
              name: student[2],
              mark1: student[3],
              mark2: student[4],
              fullMark: student[3] + student[4],
              fullMarkWrite: toArabicWord(student[3] + student[4]),
              result: "",
            });
        });
      };
      reader.readAsArrayBuffer(file);
    },
    saveToDatabase() {
      axios
        .post("/api/save_student_mark2", {
          students: this.students,
          course_id: this.course.id,
        })
        .then((res) => {
          console.log(res);
          let data = res.data;
          let msg = data.msg;
          alert(msg);
        })
        .catch((err) => {
          console.log(err);
        });
      let printable = document.getElementById("printable");
      html2PDF(printable, {
        jsPDF: {
          format: "a4",
        },
        imageType: "image/jpeg",
        output: `علامات_النظري_لمادة_${this.course.name}.pdf`,
      });
    },
    onChange() {
      this.selected = true;
      axios
        .get(`/api/get_student_mark1/${this.course.id}`)
        .then((res) => {
          let data = res.data;
          console.log(data);
          data.forEach(async (student) => {
            let mark = this.getStudentMark(student.courses);
            // console.log(mark);
            this.students.push({
              id: student.id,
              univ_id: student.univ_id,
              name: student.name + " " + student.last_name,
              mark1: mark.mark1,
              mark2State: true,
            });
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getStudentMark(courses) {
      for (let index = 0; index < courses.length; index++) {
        const course = courses[index];
        if (course.course_id == this.course.id) {
          return course;
        }
      }
    },
    loadCourses() {
      axios
        .post("/api/get_courses")
        .then((res) => {
          res.data.courses.forEach((course) => {
            this.courses.push({
              text: course.name,
              value: course,
            });
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onMark2Changed({ data, id }) {
      let mark1 = parseInt(this.students[id].mark1);
      let mark2 = parseInt(data);
      if (mark1 + mark2 > 100) {
        this.students[id].mark2 = "";
        var lastIndex = this.students.length - 1;
        this.students.push(this.students[lastIndex]);
        this.students.splice(lastIndex, 1);
        alert("علامة الكلية لا يمكن ان تكون اكبر من 100");
        return;
      }
      this.students[id].mark2 = mark2;
      let fullmark = mark1 + mark2;
      this.students[id].fullMark = fullmark;
      this.students[id].fullMarkWrite = toArabicWord(fullmark);
      this.students[id].result =
        this.students[id].fullMark >= 60 ? "ناجح" : "راسب";
      var lastIndex = this.students.length - 1;
      this.students.push(this.students[lastIndex]);
      this.students.splice(lastIndex, 1);
      this.allStudentsEditCount++;
      if (this.allStudentsEditCount >= this.students.length) {
        this.calculateParse();
      }
    },
    calculateParse() {
      this.editState = false;
      let sumMark2 = 0,
        sumFullMark = 0;
      this.students.forEach((student) => {
        if (student.fullMark >= 60) sumFullMark++;
        if (student.mark2 >= 42) sumMark2++;
      });
      console.log(sumMark2);
      console.log(sumFullMark);
      this.passedMark2 = ((sumMark2 * 100) / this.students.length).toFixed(2);
      this.passedAllMark = ((sumFullMark * 100) / this.students.length).toFixed(
        2
      );
    },
  },

  mounted() {
    this.loadCourses();
  },
};
</script>

<style scoped>
th,
td {
  border: 1px solid;
  padding: 0.5rem;
}
th,
td {
  text-align: center;
  font-weight: 600;
  font-size: 21px;
}
table {
  width: 80%;
  /* display: inline-block; */
  border-collapse: collapse;
}
.name {
  font-size: 19px;
  color: black;
}
p {
  font-size: 17px;
  display: inline;
  font-weight: 600;
  margin-bottom: 0.25rem;
}
.centered {
  text-align: center;
  font-size: 20px;
  display: block;
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