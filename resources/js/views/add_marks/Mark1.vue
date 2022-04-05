<template>
  <div class="container" style="padding: 1rem; background: #ccc">
    <b-form @submit.prevent style="padding-left: 3rem; padding-right: 3rem">
      <b-form-group
        style="width: 50%"
        id="input-group-2"
        label="السنة"
        label-for="input-2"
      >
        <b-form-select
          id="input-2"
          v-model="selected.year"
          :options="this.years"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>
      <b-form-group
        style="width: 50%; margin-bottom: 1rem"
        id="input-group-3"
        label="القسم"
        label-for="input-3"
      >
        <b-form-select
          id="input-3"
          v-model="selected.section"
          :options="this.sections"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>
      <b-button
        @click.prevent="getCourses()"
        v-if="
          this.selected.year.name !== '' && this.selected.section.name !== ''
        "
        variant="primary"
      >
        عرض كافة المواد</b-button
      >

      <b-form-group
        style="width: 50%"
        id="input-group-5"
        label="المواد"
        v-if="
          this.selected.year.name !== '' &&
          this.selected.section.name !== '' &&
          this.courses.length > 0
        "
        label-for="input-5"
      >
        <b-form-select
          id="input-5"
          v-model="selected_course"
          :options="this.courses"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>

      <b-form-group
        id="input-group-1"
        v-if="
          this.selected.year.name !== '' && this.selected.section.name !== ''
        "
        label="رقم الطالب الجامعي"
        label-for="input-1"
      >
        <div class="student_div">
          <b-form-input
            id="input-1"
            v-model="student_univ_id"
            type="text"
            v-on:input="onChange"
            style="width: 40%; height: 0%"
            required
          ></b-form-input>
          <Student
            style="width: 40%"
            v-if="this.student !== null && this.student.year !== undefined"
            :student="this.student"
          />
        </div>
      </b-form-group>
      <b-form-group
        id="input-group-11"
        v-if="
          this.selected.year.name !== '' && this.selected.section.name !== ''
        "
        label="علامة العملي"
        label-for="input-11"
        style="margin-bottom: 1rem"
      >
        <b-form-input
          id="input-11"
          v-model="mark"
          type="number"
          style="width: 17%"
          max="30"
          min="0"
          required
        ></b-form-input>
      </b-form-group>
      <b-button
        @click.prevent="addMark()"
        v-if="this.searchValue !== null && this.mark !== null"
        variant="primary"
      >
        إضافة علامة</b-button
      >
    </b-form>
    <Notification :notification="notify" />
  </div>
</template>

<script>
import SearchComponent from "../../compos/SearchComponent.vue";
import SearchedStudent from "../../compos/SearchedStudent.vue";
import Student from "../../compos/Student.vue";
import Notification from "../../compos/Notification.vue";
export default {
  mounted() {
    this.getYears();
    this.getSections();
  },
  components: {
    SearchComponent,
    SearchedStudent,
    Notification,
    Student,
  },
  data() {
    return {
      notify: {
        msg: "",
        code: -1,
      },
      student: null,
      courses: [],
      years: [],
      sections: [],
      isSearching: false,
      selected: {
        year: {
          name: "",
          id: 0,
        },
        section: {
          name: "",
          id: 0,
        },
      },
      student_univ_id: null,
      mark: null,
      selected_course: null,
      searchValue: "",
    };
  },
  methods: {
    getCourses() {
      this.courses = [];
      axios
        .post("/api/get_courses", {
          year_id: this.selected.year.id,
          section_id: this.selected.section.id,
        })
        .then((response) => {
          console.log(response.data);
          response.data.courses.forEach((course) => {
            this.courses.push({ value: course, text: course.name });
          });
        })
        .catch((error) => console.log(error));
    },
    getYears() {
      axios
        .post("/api/get_years")
        .then((response) => {
          response.data.years.forEach((year) => {
            this.years.push({ value: year, text: year.name });
          });
        })
        .catch((error) => console.log(error));
    },
    getSections() {
      axios
        .get("/api/get_sections")
        .then((response) => {
          response.data.forEach((section) => {
            this.sections.push({ value: section, text: section.name });
          });
        })
        .catch((error) => console.log(error));
    },
    addMark() {
      if (this.mark > 30 || this.mark < 0) {
        this.notify = {
          msg: "لا يمكن للعلامة ان تكون اصغر من 0 او اكبر من 30",
          code: 500,
        };
        return;
      }
      axios
        .post("/api/add_student_mark1", {
          student_id: this.student.id,
          mark: this.mark,
          course_id: this.selected_course.id,
        })
        .then((res) => {
          this.notify = {
            code: res.data.code,
            msg: res.data.message,
          };
          if (res.data.code === 200) {
            this.student = null;
            this.selected = {
              year: {
                name: "",
                id: 0,
              },
              section: {
                name: "",
                id: 0,
              },
            };
            this.student_univ_id = null;
            this.mark = null;
            this.selected_course = null;
          }
        })
        .catch((error) => console.log(error));
    },
    search(value) {
      // console.log(value);
      this.searchValue = value;
      if (this.searchValue !== "") this.isSearching = true;
      else this.isSearching = false;
    },
    onChange(v) {
      axios
        .get(`/api/get_student_by_id/${this.student_univ_id}`)
        .then((res) => {
          console.log(res.data);
          if (res.data !== "{}") this.student = res.data;
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style scoped>
.student_div {
  width: 40%;
  display: flex;
  align-content: space-between;
  flex-direction: row;
  justify-content: space-between;
}
</style>