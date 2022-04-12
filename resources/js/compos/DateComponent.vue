<template>
  <div class="dateContainer">
    <p>{{ title }}</p>

    <DatePicker v-model="date" :lang="lang" />

    <b-button
      @click.prevent="setDate"
      variant="primary"
      v-if="date != '' && date != null"
    >
      تحديد الوقت
    </b-button>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";

import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/ar";
import moment from "moment";

export default {
  props: ["title", "field", "oldDate"],
  components: { DatePicker },

  mounted() {
      console.log(this.$props.oldDate);
    if (this.oldDate != undefined) {
      var x = new Date();
      x.setTime(this.$props.oldDate);
      console.log(x);
      this.date = x;
    }
  },
  data() {
    return {
      date: "",
      lang: {
        formatLocale: {
          firstDayOfWeek: 1,
        },
        monthBeforeYear: false,
      },
    };
  },
  methods: {
    setDate() {
      let fieldName = "";
      if (this.field == 1) {
        fieldName = "first_tirm_start";
      } else if (this.field == 2) {
        fieldName = "first_tirm_end";
      } else if (this.field == 3) {
        fieldName = "first_tirm_exam_end";
      } else if (this.field == 4) {
        fieldName = "second_tirm_start";
      } else if (this.field == 5) {
        fieldName = "second_tirm_end";
      } else if (this.field == 6) {
        fieldName = "second_tirm_exam_end";
      } else fieldName = "next_year_first_tirm_start";
      this.saveField(fieldName);
    },
    saveField(fieldName) {
      var milliseconds = this.date.getTime();
        let json = `${fieldName}:${milliseconds}`;
        json = JSON.stringify(json).toString();
        console.log(json);
        axios
          .post("/api/set_dates", json, {
            headers: {
              "Content-Type": "application/json",
            },
          })
          .then((response) => console.log(response.data))
          .catch((err) => console.log(err));
    },
  },
};
</script>
<style scoped>
.dateContainer {
  margin: 2rem;
  display: grid;
  grid-template-columns: repeat(3, minmax(92px, 1fr));
  justify-items: start;
  gap: 10px;
}
.dateContainer p {
  font-size: 1.25rem;
  font-weight: 600;
}
</style>