<template>
  <div
    id="student_field"
    :class="{ shown: this.is_shown === true }"
    class="card m-3 student"
  >
    <span class="x" @click="close" />
    <b-form @submit.prevent style="padding-left: 3rem; padding-right: 3rem">
      <b-form-group
        id="input-group-1"
        label-cols="4"
        label-cols-lg="2"
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
          type="text"
          style="width: fit-content"
          required
        ></b-form-input>
      </b-form-group>
      <b-button
        @click.prevent="generateReport()"
        v-if="this.univ_id !== ''"
        style="margin-top: 1.5rem"
        variant="primary"
        >توليد</b-button
      >
    </b-form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      univ_id: "",
      is_shown: false,
    };
  },
  methods: {
    generateReport() {
      this.$emit("generate", this.univ_id);
    },
    close(e) {
      this.is_shown = !this.is_shown;
      this.$emit("reset-values", false);
    },
  },
  props: ["is_shows"],
  watch: {
    is_shows: {
      handler(n, o) {
        this.is_shown = n;
        this.univ_id = "";
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
  transform: translateY(0%);
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
  transform: translateY(100%);
}
</style>