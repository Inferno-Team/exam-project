<template>
  <div
    id="student_field"
    :class="{ shown: this.is_shown === true }"
    class="card m-3 student"
  >
    <span class="x" @click="close"></span>
    <div style="padding-left: 3rem; padding-right: 3rem">
      <b-form-group
        id="input-group-3"
        label-size="lg"
        label="السنة الدراسية"
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
          v-model="selectedYear"
          :options="years"
          style="width: 100%"
          required
        />
      </b-form-group>
    </div>
    <b-button
      v-if="this.selectedYear !== null"
      style="margin-top: 1.5rem"
      variant="primary"
      @click.prevent="generateReport()"
      >توليد تقرير</b-button
    >
  </div>
</template>

<script>
export default {
  props: ["is_shows"],
  mounted() {
    this.getAllYears();
  },
  watch: {
    is_shows: {
      handler(nV, oV) {
        this.is_shown = nV;
      },
    },
  },
  data() {
    return {
      is_shown: false,
      years: [],
      selectedYear: null,
    };
  },
  methods: {
    close(e) {
      this.is_shown = !this.is_shown;
      this.$emit("reset-values", false);
    },

    getAllYears() {
      axios
        .post("/api/get_years")
        .then((response) => {
          this.years = response.data.years.map((year) => {
            return { value: year, text: year.name };
          });
        })
        .catch(console.error);
    },
    generateReport() {
      this.$router.push({
        name: "generate-top-ten",
        params: {
          id: this.selectedYear.id,
        },
      });
    },
  },
};
</script>

<style scoped>
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