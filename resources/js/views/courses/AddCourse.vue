<template>
  <div
    class="card m-3"
    style="padding: 1rem; width: 75%; height: 50%; margin: auto !important"
  >
    <b-form
      @submit.prevent="addCourse"
      style="padding-left: 3rem; padding-right: 3rem"
    >
      <b-form-group
        id="input-group-1"
        label-cols="4"
        label-cols-lg="2"
        label-size="lg"
        label="اسم المادة"
        label-for="input-1"
        class="card center-text"
        style="flex-direction: row"
      >
        <b-form-input
          id="input-1"
          v-model="course_name"
          type="text"
          style="width: fit-content"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        style="width: 50%"
        id="input-group-2"
        class="card center-text input-form"
      >
        <label
          class="label"
          style="height: 100%; margin: auto; margin-left: 4rem"
          for="input-2"
          >السنة</label
        >
        <b-form-select
          id="input-2"
          v-model="selected_year"
          :options="this.years"
          style="width: 50%"
          :change="selectedYearChanged"
          required
        ></b-form-select>
      </b-form-group>

      <b-form-group
        style="width: 50%"
        id="input-group-3"
        class="card center-text input-form"
      >
        <label
          class="label"
          style="height: 100%; margin: auto; margin-left: 4rem"
          for="input-3"
          >الفصل</label
        >
        <b-form-select
          id="input-2"
          v-model="selected_semester"
          :options="this.semesters"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>

      <b-form-group
        style="width: 50%"
        id="input-group-4"
        class="card center-text input-form"
      >
        <label
          class="label"
          style="height: 100%; margin: auto; margin-left: 2.4rem"
          for="input-4"
          >نوع المادة</label
        >
        <b-form-select
          id="input-4"
          v-model="type"
          :options="this.types"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>

      <b-form-group
        style="width: 50%"
        id="input-group-5"
        class="card center-text input-form"
      >
        <label
          class="label"
          style="height: 100%; margin: auto; margin-left: 3.9rem"
          for="input-5"
          >القسم</label
        >
        <b-form-select
          id="input-5"
          v-model="selected_section"
          :options="this.sections"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>

      <b-button
        @click.prevent="addCourse()"
        v-if="
          this.selected_year.name !== '' && this.selected_section.name !== ''
        "
        style="margin-top: 1.5rem"
        variant="primary"
      >
        إضافة مادة</b-button
      >
    </b-form>
    <Notification :notification="notify" />
  </div>
</template>
<script>
import Notification from "../../compos/Notification.vue";
export default {
  components: {
    Notification,
  },
  mounted() {
    this.getYears();
    this.getSections();
    this.getSemesters();
  },

  data() {
    return {
      years: [],
      semesters: [],
      sections: [],
      selected_year: {
        id: 0,
        name: "",
      },
      selected_semester: {
        id: 0,
        name: "",
      },
      selected_section: {
        id: 0,
        name: "",
      },
      notify: {
        msg: "",
        code: -1,
      },
      types: ["عادي", "اختياري"],
      type: "",
      course_name: "",
    };
  },
  methods: {
    selectedYearChanged(year) {
    },
    addCourse() {
      var course = {
        name: this.course_name,
        year_id: this.selected_year.id,
        section_id: this.selected_section.id,
        semester_id: this.selected_semester.id,
        type: this.type,
      };
      
      axios
        .post("/api/add_course", course)
        .then((response) => {
          console.log(response);
          this.notify = {
            msg: "تمت الاضافة بشكل ناجح",
            code: response.status,
          };
        })
        .catch((error) => {
          console.log(error);
          this.notify = {
            msg: "حدث خطأ ما يرجى المحاولة مرة اخرى",
            code: 500,
          };
        });
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
    getSemesters() {
      axios
        .post("/api/get_semesters")
        .then((response) => {
          response.data.years.forEach((semester) => {
            if (semester.name !== "تكميلي")
              this.semesters.push({ value: semester, text: semester.name });
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
  },
};
</script>
<style scoped>
.label {
  font-size: 1rem;
  margin: 0.5rem;
  font-weight: 600;
}
.card {
  border: none !important;
}
</style>