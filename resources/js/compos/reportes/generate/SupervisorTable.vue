<template>
  <div class="tables" v-if="table.length > 0">
    <table>
      <tr>
        <th scope="row">ت</th>
        <th scope="row">اليوم</th>
        <th scope="row">الساعة</th>
        <th scope="row">القاعة</th>
        <th scope="row">توقيع رئيس القاعة</th>
      </tr>
      <tr v-for="(_, i) in insideSize" :key="i">
        <th scope="row" :id="'a ' + i">
          <div>{{ i + 1 }}</div>
        </th>
        <th scope="row" :id="'a ' + i" @dblclick="onDayDoubleClick($event)">
          <div v-if="dayShows[i]" :id="'a ' + i">{{ table[i].day }}</div>
          <input
            v-else
            v-model="table[i].day"
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
        <th scope="row" :id="'a ' + i" @dblclick="onHallDoubleClick($event)">
          <div v-if="hallShows[i]" :id="'a ' + i">{{ table[i].hall }}</div>
          <input
            v-else
            v-model="table[i].hall"
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
        <th scope="row" :id="'h ' + i" @dblclick="onHourDoubleClick($event)">
          <div v-if="hourShows[i]" :id="'h ' + i">{{ table[i].hour }}</div>
          <input
            v-else
            v-model="table[i].hour"
            class="in-input"
            type="text"
            autocomplete="off"
          />
        </th>
        <th scope="row" :id="'s ' + i" @dblclick="onSigDoubleClick($event)">
          <div v-if="sigShows[i]" :id="'s ' + i">{{ table[i].sig }}</div>
          <input
            v-else
            v-model="table[i].sig"
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
  props: ["id", "size"],
  mounted() {
    this.insideSize = this.size;
    for (let index = 0; index < 3; index++) {
      this.dayShows.push(true);
      this.hourShows.push(true);
      this.hallShows.push(true);
      this.sigShows.push(true);
      this.table.push({
        day: "",
        hour: "",
        hall: "",
        sig: "",
      });
    }
  },
  data() {
    return {
      dayShows: [],
      hallShows: [],
      hourShows: [],
      sigShows: [],
      table: [],
      insideSize: 0,
    };
  },
  watch: {
    size: function (newSize) {
      this.insideSize = this.size;
      this.dayShows = new Array(newSize).fill(true);
      this.hallShows = new Array(newSize).fill(true);
      this.hourShows = new Array(newSize).fill(true);
      this.sigShows = new Array(newSize).fill(true);
      this.table.push({
        day: "",
        hour: "",
        hall: "",
        sig: "",
      });
    },
  },
  methods: {
    onDayDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.dayShows[id] = !this.dayShows[id];
      this.insideSize++;
      this.insideSize--;
    },
    onHallDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.hallShows[id] = !this.hallShows[id];
      this.insideSize++;
      this.insideSize--;
    },
    onHourDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.hourShows[id] = !this.hourShows[id];
      this.insideSize++;
      this.insideSize--;
    },
    onSigDoubleClick(event) {
      var id = event.target.id.split(" ")[1];
      id = parseInt(id);
      this.sigShows[id] = !this.sigShows[id];
      this.insideSize++;
      this.insideSize--;
    },
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