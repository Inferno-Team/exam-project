<template>
  <div
    class="card m-3"
    style="padding: 1rem; width: 75%; height: 50%; margin: auto !important"
  >
    <div class="grid_view">
      <div>
        <p>اسم المادة</p>
        <b-form-input id="input-1" v-model="course_name" type="text" required />
      </div>

      <div>
        <p>السنة</p>
        <b-form-select
          id="input-2"
          v-model="selected_year"
          :options="this.years"
          style="width: 50%"
          @change="selectedYearChanged"
          required
        />
      </div>
      <div>
        <p>الفصل</p>
        <b-form-select
          id="input-3"
          v-model="selected_semester"
          :options="this.semesters"
          style="width: 50%"
          required
        />
      </div>
      <div style="display: flex; justify-content: space-between">
        <div style="width: 11rem">
          <p>نوع المادة</p>
          <b-form-checkbox
            id="input-4"
            v-model="type"
            @change="selectedType"
            style="width: 50%"
            required
          />
        </div>
        <div v-if="selected_year.id >= 4" style="width: 11rem">
          <p>مجموعة المادة</p>
          <b-form-select
            id="input-4"
            v-model="selectionType"
            :options="this.selectionTypes"
            style="width: 50%"
            required
          />
        </div>
      </div>
      <div>
        <p>القسم</p>
        <b-form-select
          id="input-5"
          v-model="selected_section"
          :options="this.sections"
          style="width: 50%"
          required
        />
      </div>
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
    </div>
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
  },

  data() {
    return {
      years: [],
      semesters: [],
      sections: [],
      selectionType: "",
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
      types: [],
      selectionTypes: [],
      type: false,
      course_name: "",
    };
  },
  methods: {
    selectedYearChanged() {
      this.getSemesters(this.selected_year.id);
    },
    selectedType() {
      if (this.type) {
        if (this.selected_year.id == 4)
          this.selectionTypes = ["مجموعة 1", "مجموعة 2"];
        else this.selectionTypes = ["مجموعة 3", "مجموعة 4", "مجموعة 5"];
      } else this.selectionTypes = [];
    },
    addCourse() {
      var course = {
        name: this.course_name,
        year_id: this.selected_year.id,
        section_id: this.selected_section.id,
        semester_id: this.selected_semester.id,
        type: this.type,
        selection_type: this.selectionType,
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
    getSemesters(id) {
      axios
        .post(`/api/get_semesters/${id}`)
        .then((response) => {
          this.semesters = [];
          response.data.forEach((semester) => {
            this.semesters.push({
              value: semester,
              text: semester.semester_name,
            });
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
.grid_view p {
  font-size: 1rem;
  margin: 0.5rem;
  font-weight: 600;
}
.card {
  border: none !important;
}
.grid_view {
  display: grid;
  grid-template-columns: repeat(2, minmax(92px, 1fr));
  grid-template-rows: repeat(3, minmax(92px, 1fr));
}
</style>