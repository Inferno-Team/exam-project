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
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-2"
        label-size="lg"
        label="رقم وثيقة التبرع بالدم"
        label-class="student_label"
        label-for="input-2"
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
          id="input-2"
          v-model="bloodNumber"
          type="number"
          style="width: fit-content"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-3"
        label-size="lg"
        label="تاريخ وثيقة التبرع بالدم"
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
        <b-form-input
          id="input-3"
          v-model="bloodDate"
          type="date"
          style="width: fit-content"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-4"
        label-size="lg"
        label="رقم إيصال رسود الدفع"
        label-class="student_label"
        label-for="input-4"
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
          id="input-4"
          v-model="checkNumber"
          type="number"
          style="width: fit-content"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-5"
        label-size="lg"
        label="تاريخ إيصال رسود الدفع"
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
      >
        <b-form-input
          id="input-5"
          v-model="checkDate"
          type="date"
          style="width: fit-content"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-6"
        label-size="lg"
        label="رقم وثيقة التخرج"
        label-class="student_label"
        label-for="input-6"
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
          id="input-6"
          v-model="graduationNumber"
          type="number"
          style="width: fit-content"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-7"
        label-size="lg"
        label="تاريخ وثيقة التخرج"
        label-class="student_label"
        label-for="input-7"
        class="univ_number_class"
        style="
          display: flex;
          align-content: center;
          justify-content: flex-start;
          align-items: center;
          flex-direction: row;
        "
      >
        <b-form-input
          id="input-5"
          v-model="graduationDate"
          type="date"
          style="width: fit-content"
        ></b-form-input>
      </b-form-group>

      <b-button
        @click.prevent="generateReport()"
        v-if="this.univ_id !== ''"
        style="margin-top: 1.5rem"
        variant="primary"
        >توليد</b-button
      >
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      univ_id: "",
      is_shown: false,

      bloodNumber: null,
      bloodDate: null,

      checkNumber: null,
      checkDate: null,

      graduationNumber: null,
      graduationDate: null,
    };
  },
  methods: {
    generateReport() {
      this.$emit("generate", {
        univ_id: this.univ_id,

        blood: this.bloodNumber,
        bloodDate: this.bloodDate,

        check: this.checkNumber,
        checkDate: this.checkDate,

        graduationNumber: this.graduationNumber,
        graduationDate: this.graduationDate,
      });
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