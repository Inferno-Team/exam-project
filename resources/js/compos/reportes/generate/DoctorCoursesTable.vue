<template>
  <div class="tables">
    <table>
      <tr>
        <th scope="row">اليوم</th>
        <th scope="row">السنة</th>
        <th scope="row">المقرر</th>
        <th scope="row">عدد القاعات</th>
        <th scope="row">من</th>
        <th scope="row">الى</th>
      </tr>
      <tr v-for="(course, i) in courses" :key="i">
        <th scope="row" :id="'d ' + i" @dblclick="onDayDoubleClick($event)">
          <div v-if="dayShows[i]" :id="'d ' + i">{{ coursesTable[i].day }}</div>
          <input
            v-model="coursesTable[i].day"
            v-else
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
        <th scope="row">{{ course.year_semester.year.name }}</th>
        <th scope="row">{{ course.name }}</th>
        <th scope="row" :id="'h ' + i" @dblclick="onHallDoubleClick($event)">
          <div v-if="hallShows[i]" :id="'h ' + i">
            {{ coursesTable[i].hall }}
          </div>
          <input
            v-model="coursesTable[i].hall"
            v-else
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
        <th scope="row" :id="'f ' + i" @dblclick="onFromDoubleClick($event)">
          <div v-if="fromShows[i]" :id="'f ' + i">
            {{ coursesTable[i].from }}
          </div>
          <input
            v-model="coursesTable[i].from"
            v-else
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
        <th scope="row" :id="'f ' + i" @dblclick="onToDoubleClick($event)">
          <div v-if="toShows[i]" :id="'f ' + i">{{ coursesTable[i].to }}</div>
          <input
            v-model="coursesTable[i].to"
            v-else
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      courses: [],
      dayShows: [],
      hallShows: [],
      fromShows: [],
      toShows: [],
      coursesTable: [],
    };
  },
  methods: {
    loadDoctorCoureses() {
      const editable = "";
      axios
        .post(`/api/load-doctor-courses/${this.id}`)
        .then((result) => {
          this.courses = result.data;
          this.courses.forEach((course) => {
            this.dayShows.push(true);
            this.hallShows.push(true);
            this.fromShows.push(true);
            this.toShows.push(true);
            this.coursesTable.push({
              day: editable,
              hall: editable,
              from: editable,
              to: editable,
            });
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onDayDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.dayShows[id] = !this.dayShows[id];
      var lastIndex = this.courses.length - 1;
      this.courses.push(this.courses[lastIndex]);
      this.courses.splice(lastIndex, 1);
    },
    onHallDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.hallShows[id] = !this.hallShows[id];
      var lastIndex = this.courses.length - 1;
      this.courses.push(this.courses[lastIndex]);
      this.courses.splice(lastIndex, 1);
    },
    onFromDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.fromShows[id] = !this.fromShows[id];
      var lastIndex = this.courses.length - 1;
      this.courses.push(this.courses[lastIndex]);
      this.courses.splice(lastIndex, 1);
    },
    onToDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.toShows[id] = !this.toShows[id];
      var lastIndex = this.courses.length - 1;
      this.courses.push(this.courses[lastIndex]);
      this.courses.splice(lastIndex, 1);
    },
  },
  mounted() {
    this.loadDoctorCoureses();
  },
};
</script>

<style scoped>
th,
td {
  border: 1px solid;
  padding: 0.5rem;
}
th {
  text-align: center;
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
.in-input {
  width: 7rem;
}
</style>