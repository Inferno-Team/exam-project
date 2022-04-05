<template>
  <div>
    <div class="year-container">
      <h6 style="display: inline" class="name">{{ year.name }}</h6>
      <p style="display: inline">للعام الدراسي</p>
      <p style="display: inline" class="name">{{ yearHistory.year_date }}</p>
      <p style="display: inline">التيجة :</p>
      <p style="display: inline" class="name">{{ status }}</p>
      <p style="display: inline">المعدل :</p>
      <p style="display: inline" class="name">{{ avrage }}</p>
      <p style="display: inline">المعدل كتابتاً :</p>
      <p style="display: inline" class="name">{{ avrageWriting }}</p>

      <div class="tables">
        <table>
          <tr>
            <th scope="row">مقررات الفصل الأول</th>
            <th scope="row">العلامة رقماً</th>
            <th scope="row">العلامة كتابتاً</th>
          </tr>
          <tr v-for="(mark, i) in marks" :key="i">
            <th scope="row">{{ mark.course.name }}</th>
            <th scope="row">{{ mark.fullMark }}</th>
            <th scope="row">{{ mark.fullMarkName }}</th>
          </tr>
        </table>
        <table>
          <tr>
            <th scope="row">مقررات الفصل الثاني</th>
            <th scope="row">العلامة رقماً</th>
            <th scope="row">العلامة كتابتاً</th>
          </tr>
          <tr v-for="(mark, i) in marks" :key="i">
            <th scope="row">{{ mark.course.name }}</th>
            <th scope="row">{{ mark.fullMark }}</th>
            <th scope="row">{{ mark.fullMarkName }}</th>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import { toArabicWord } from "number-to-arabic-words/index.js";
export default {
  props: ["sid", "yid"],
  mounted() {
    this.getYear();
    this.getYearHistory();
    this.getYearStudentMarks();
  },
  methods: {
    getYear() {
      let year_id = this.$props.yid;
      axios
        .get(`/api/get_year/${year_id}`)
        .then((res) => (this.year = res.data.year))
        .catch((err) => console.log(err));
    },
    getYearHistory() {
      let year_id = this.$props.yid;
      let student_id = this.$props.sid;
      axios
        .get(`/api/get_student_year_history/${student_id}/${year_id}`)
        .then((res) => (this.yearHistory = res.data))
        .catch((err) => console.log(err));
    },
    getYearStudentMarks() {
      let year_id = this.$props.yid;
      let student_id = this.$props.sid;
      axios
        .get(`/api/get_student_year_marks/${student_id}/${year_id}`)
        .then((res) => {
          this.marks = res.data;
          let removed = [];

          for (let index = 0; index < this.marks.length; index++) {
            let mark = this.marks[index];
            if (mark.marks.length == 2) {
              mark.fullMark = mark.marks[0].mark + mark.marks[1].mark;
              mark.fullMarkName = toArabicWord(mark.fullMark);
            } else {
              let index = this.marks.indexOf(mark);
              removed.push(index);
            }
          }

          for (let index = 0; index < removed.length; index++) {
            const element = removed[index];
            console.log(element);
            this.marks.splice(element);
          }
          let m = 0;
          let fc = 0;
          for (let index = 0; index < this.marks.length; index++) {
            if (this.marks[index].status === "راسب") {
              this.status = "منقول";
              fc++;
            }
            const element = this.marks[index].fullMark;
            m += element;
          }
          if (fc > 4) this.status = "راسب";
          else if (fc === 0) this.status = "ناجح";
          this.avrage = m / this.marks.length;
          this.avrageWriting = toArabicWord(this.avrage);
          this.$emit("avr", { avr: this.avrage, i: this.$props.yid });
        })
        .catch((err) => console.log(err));
    },
  },
  data() {
    return {
      year: {},
      yearHistory: {},
      marks: [],
      avrage: 0.0,
      avrageWriting: "",
      status: "",
    };
  },
};
</script>
<style scoped>
.name {
  font-size: 19px;
  color: black;
}
p {
  font-size: 17px;
  display: inline;
  font-weight: 600;
}
.year-container {
  border: 1px dashed black;
  margin: 0.2rem;
  padding: 0.4rem;
}
th,
td {
  border: 1px solid;
  padding: 0.5rem;
}
table {
  width: 100%;
  /* display: inline-block; */
  border-collapse: collapse;
}
.tables {
  display: flex;
  justify-content: space-between;
}
</style>