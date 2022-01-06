<template>
  <div class="container" style="padding: 1rem; background: #ccc">
    <b-form
      @submit.prevent="addMark()"
      style="padding-left: 3rem; padding-right: 3rem"
    >
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
        style="width: 50%"
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
        id="input-group-1"
        v-if="
          this.selected.year.name !== '' && this.selected.section.name !== ''
        "
        label="رقم الطالب الجامعي"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="student_univ_id"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

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
    </b-form>
  </div>
</template>
<style scoped>
</style>
<script>
export default {
  mounted() {
    this.getYears();
    this.getSections();
  },

  data() {
    return {
      courses: [],
      years: [],
      sections: [],
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
      student_univ_id: -1,
      selected_course: {},
    };
  },
  methods: {
    getCourses() {
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

    },
  },
};
</script>