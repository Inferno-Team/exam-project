<template>
  <div class="container" style="padding: 1rem; background: #ccc">
    <b-form
      @submit.prevent="addCourse"
      style="padding-left: 3rem; padding-right: 3rem"
    >
      <b-form-group id="input-group-1" label="اسم المادة" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="course_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        style="width: 50%"
        id="input-group-2"
        label="السنة"
        label-for="input-2"
      >
        <b-form-select
          id="input-2"
          v-model="selected_year"
          :options="this.years"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>
      <b-form-group
        style="width: 50%"
        id="input-group-20"
        label="نوع المادة"
        label-for="input-20"
      >
        <b-form-select
          id="input-20"
          v-model="type"
          :options="this.types"
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
        variant="primary"
      >
        إضافة مادة</b-button
      >
    </b-form>
    <div
      class="notification"
      id="notification"
      :class="{
        success: this.notification.code === 200,
        error: this.notification.code > 200,
      }"
    >
      <div>
        <h3>{{ this.notification.msg }}</h3>
        <h2>{{ this.notification.code }}</h2>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    this.getYears();
    this.getSections();
  },

  data() {
    return {
      years: [],
      sections: [],
      selected_year: {
        id: 0,
        name: "",
      },
      selected_section: {
        id: 0,
        name: "",
      },
      types: ["عادي", "اجبارية"],
      type: "",
      course_name: "",
      notification: {
        msg: "",
        code: -1,
      },
    };
  },
  methods: {
    showNotification() {
      document
        .getElementById("notification")
        .classList.toggle("notification-destory");
      setTimeout(() => {
        document
          .getElementById("notification")
          .classList.toggle("notification-destory");
      }, 2500);
    },
    addCourse() {
      axios
        .post("/api/add_course", {
          name: this.course_name,
          year_id: this.selected_year.id,
          section_id: this.selected_section.id,
          type: this.type,
        })
        .then((response) => {
          this.notification = {
            msg: response.data.msg,
            code: response.status,
          };
          this.showNotification();
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
  },
};
</script>
<style scoped>
.notification {
  width: 25%;
  border-radius: 0.8rem;
  position: absolute;
  bottom: 1rem;
  left: -30rem;
  padding: 4px;
  transition: 1s;
}
.notification h3,
.notification h2 {
  font-size: 1.2rem;
}
.success {
  border: 1px solid #0f0;
  background: rgb(123, 255, 123);
  left: 1rem;
}
.error {
  border: 1px solid #f00;
  background: rgb(255, 123, 123);
  left: 1rem;
}
.notification-destory {
  left: -30rem;
}
</style>