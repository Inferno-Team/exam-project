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
        label="المراقب"
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
          v-model="selectedSupervisor"
          :options="supervisors"
          style="width: 100%"
          required
        />
      </b-form-group>
    </div>
    <b-button
      @click.prevent="generateReport()"
      v-if="this.selectedSupervisor !== null"
      style="margin-top: 1.5rem"
      variant="primary"
      >توليد تقرير</b-button
    >
  </div>
</template>

<script>
export default {
  props: ["is_shows"],
  mounted() {
    this.getSupervisor();
  },
  watch: {
    is_shows: {
      handler(nV, oV) {
        this.is_shown = nV;
      },
    },
  },
  methods: {
    close(e) {
      this.is_shown = !this.is_shown;
      this.$emit("reset-values", false);
    },

    getSupervisor() {
      axios
        .post("/api/get_supervisors")
        .then((result) => {
          result.data.forEach((supervisor) => {
            this.supervisors.push({ value: supervisor, text: supervisor.name });
          });
        })
        .catch((err) => {});
    },
    generateReport() {
      this.$router.push({
        name: "generate-supervisor-assignment",
        params: {
          object: this.selectedSupervisor.id,
        },
      });
    },
  },
  data() {
    return {
      is_shown: false,
      supervisors: [],
      selectedSupervisor: null,
    };
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