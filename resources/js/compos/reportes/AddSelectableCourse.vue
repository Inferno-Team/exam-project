<template>
  <div
    id="student_field"
    :class="{ shown: this.is_shown === true }"
    class="card m-3 student"
  >
    <span class="x" @click="close" />
    <div style="padding-left: 3rem; padding-right: 3rem">
      <b-form-group
        id="input-group-1"
        label-size="lg"
        label="رقم الجامعي للطالب"
        label-class="student_label"
        label-for="input-1"
        class="univ_number_class"
        style="
          display: flex;
          align-content: center;
          justify-content: center;
          align-items: center;
          flex-direction: row;
        "
      >
        <b-form-input
          id="input-1"
          v-model="univ_id"
          type="number"
          style="width: fit-content"
          @change="onStudentUnivIdChange"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-2"
        label-size="lg"
        label="السنة"
        label-class="student_label"
        label-for="input-2"
        class="univ_number_class"
        style="
          display: flex;
          align-content: center;
          justify-content: flex-start;
          align-items: center;
          flex-direction: row;
        "
      >
        <b-form-select
          id="input-2"
          v-model="selected_year"
          :options="this.years"
          @change="onSelectedYearChange"
          required
        />
      </b-form-group>

      <b-form-group
        id="input-group-3"
        label-size="lg"
        label="الفصل"
        label-class="student_label"
        label-for="input-3"
        class="univ_number_class"
        style="
          display: flex;
          align-content: center;
          justify-content: flex-start;
          align-items: center;
          flex-direction: row;
        "
      >
        <b-form-select
          id="input-3"
          v-model="selected_semester"
          :options="this.semesters"
          style="width: 100%"
          @change="onSelectedSemesterChange"
          required
        />
      </b-form-group>

      <b-form-group
        id="input-group-4"
        label-size="lg"
        label="المجموعة"
        label-class="student_label"
        label-for="input-4"
        class="univ_number_class"
        style="
          display: flex;
          align-content: center;
          justify-content: flex-start;
          align-items: center;
          flex-direction: row;
        "
      >
        <b-form-select
          id="input-4"
          v-model="selectionType"
          :options="this.selectionTypes"
          style="width: 100%"
          @change="getCourses"
          required
        />
      </b-form-group>

      <b-form-group
        id="input-group-5"
        label-size="lg"
        label="مواد المجموعة"
        label-class="student_label"
        label-for="input-5"
        class="univ_number_class"
        style="
          display: flex;
          align-content: center;
          justify-content: flex-start;
          align-items: center;
          flex-direction: row;
        "
        v-if="this.courses.length > 0"
      >
        <b-form-select
          id="input-5"
          v-model="selectedCourse"
          :options="courses"
          style="width: 100%"
          required
        />
      </b-form-group>
    </div>
    <b-button
      @click.prevent="addCourseToStudent()"
      v-if="this.univ_id !== ''"
      style="margin-top: 1.5rem"
      variant="primary"
      >إضافة المادة الى الطالب</b-button
    >
  </div>
</template>
<script>
export default {
  mounted() {
    this.getYears();
    // this.getSemesters();
  },
  data() {
    return {
      selectedCourse: {
        id: 0,
        name: "",
      },
      univ_id: "",
      is_shown: false,
      selected_year: {
        id: 0,
        name: "",
      },
      selected_semester: {
        id: 0,
        semester_name: "",
      },
      selectionTypes: [],
      years: [],
      semesters: [],
      selectionType: "",
      courses: [],
      response: null,
    };
  },
  methods: {
    addCourseToStudent() {
      let selectionSize = 1;
      if (this.selectionType == "مجموعة 2" || this.selectionType == "مجموعة 5")
        selectionSize = 2;
      axios
        .post("/api/add_course_to_student", {
          univ_id: this.univ_id,
          course_id: this.selectedCourse.id,
          selection_name: this.selectionType,
          selection_size: selectionSize,
        })
        .then((response) => {
          this.is_shown = !this.is_shown;
          this.$emit("reset-values", false);
          this.$emit("response", response.data);
        })
        .catch((err) => console.log(err));
    },
    close(e) {
      this.is_shown = !this.is_shown;
      this.$emit("reset-values", false);
    },
    getYears(id) {
      axios
        .post("/api/get_years", { id: id })
        .then((response) => {
          response.data.years.forEach((year) => {
            if (year.id >= 4) this.years.push({ value: year, text: year.name });
          });
        })
        .catch((error) => console.log(error));
    },
    getSemesters(id) {
      axios
        .post(`/api/get_semesters/${id}`)
        .then((response) => {
          this.semesters = [];
          response.data.years.forEach((semester) => {
            this.semesters.push({
              value: semester,
              text: semester.semester_name,
            });
          });
        })
        .catch((error) => console.log(error));
    },
    onSelectedSemesterChange() {
      if (this.selected_year.id == 4) {
        // chack semester
        if (this.selected_semester.semester_name == "فصل أول")
          this.selectionTypes = ["مجموعة 1"];
        else this.selectionTypes = ["مجموعة 2"];
      } else {
        if (this.selected_semester.semester_name == "فصل أول")
          this.selectionTypes = ["مجموعة 3"];
        else this.selectionTypes = ["مجموعة 4", "مجموعة 5"];
      }
    },
    onSelectedYearChange() {
      this.selected_semester = {
        id: 0,
        semester_name: "",
      };
      this.getSemesters(this.selected_year.id);
    },
    onStudentUnivIdChange() {
      axios
        .post(`/api/get_student_years/${this.univ_id}`)
        .then((response) => {
          console.log(response.data);
          this.years = [];
          response.data.years.forEach((year) => {
            if (year.id >= 4) this.years.push({ value: year, text: year.name });
          });
        })
        .catch((error) => {
          console.log(error);
          this.years = [];
        });
    },
    getCourses() {
      axios
        .post("/api/get_courses_by_selection", {
          selection: this.selectionType,
        })
        .then((response) => {
          this.courses = [];
          response.data.forEach((course) => {
            this.courses.push({ value: course, text: course.name });
          });
        })
        .catch((err) => console.log(err));
    },
  },
  props: ["is_shows"],
  watch: {
    is_shows: {
      handler(n, o) {
        this.is_shown = n;
        this.univ_id = "";
        this.selectionTypes = [];
        this.courses = [];
        this.response = [];
        this.selectionType = "";
        this.selected_semester = {
          id: 0,
          name: "",
        };
        this.selected_year = {
          id: 0,
          name: "",
        };
        this.selectedCourse = {
          id: 0,
          name: "",
        };
      },
    },
  },
};
</script>
<style >
.student {
  padding: 1rem;
  max-width: fit-content;
  max-height: fit-content;
  margin: auto !important;
  opacity: 0;
  transform: translateY(-100%);
  transition: 1s;
}
.x {
  direction: ltr;
}
.x::before {
  display: inline-block;
  content: "\00d7"; /* This will render the 'X' */
  color: red;
  cursor: pointer;
}
.student .univ_number_class .student_label {
  width: 10rem;
}
.shown {
  opacity: 1;
  transform: translateY(20%);
}
</style>