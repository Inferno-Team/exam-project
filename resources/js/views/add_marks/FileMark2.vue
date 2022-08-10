<template>
  <div>
    <div class="floating-container" v-if="students.length > 0">
      <div class="floating-button" @click.prevent="saveToDatabase">طباعة</div>
    </div>
    <div class="tables">
      <table v-if="students.length > 0">
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
      <b-form-select
        v-if="students.length === 0 && !selected"
        :options="courses"
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

import EditableRowItem from "../../compos/reportes/generate/EditableRowItem.vue";
export default {
  components: { vueDropzone: vue2Dropzone, EditableRowItem },
  data() {
    return {
      students: [],
      selected: false,
      courses: [],
      course: {},
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
        .post("/api/save_student_mark1", {
          students: this.students,
          course_id: this.course,
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
    },
    onChange() {
      this.selected = true;
      axios
        .get(`/api/get_student_mark1/${this.course}`)
        .then((res) => {
          let data = res.data;
          // console.log(data);
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
        if (course.course_id == this.course) {
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
              value: course.id,
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
      if (mark2 > 70) {
        this.students[id].mark2 = '';
        var lastIndex = this.students.length - 1;
        this.students.push(this.students[lastIndex]);
        this.students.splice(lastIndex, 1);
        alert("علامة النظري لا يمكن ان تكون اكبر من 70");
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
.tables {
  display: flex;
  justify-content: center;
  height: 99%;
  overflow-y: auto;
}
</style>