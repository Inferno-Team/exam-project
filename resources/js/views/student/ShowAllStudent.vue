<template>
  <div style="overflow-y: scroll;height:100%">
    <div class="grid-table">
      <div
        v-for="(student, index) in this.students"
        :key="index"
        style="width: 100%"
      >
        <b-button
          v-b-toggle="'' + index"
          :id="'id ' + index"
          variant="primary"
          style="width: 90%"
          @click="toggle($event)"
          >{{ student.name }}</b-button
        >
        <b-collapse :id="'' + index" class="mt-2">
          <b-card
            border-variant="primary"
            :header="student.univ_id"
            header-bg-variant="primary"
            header-text-variant="white"
            align="center"
          >
            <b-card-text v-if="student.year !== null">{{
              student.year.year.name
            }}</b-card-text>
            <b-card-text>{{ student.father_name }}</b-card-text>
            <b-card-text>{{ student.last_name }}</b-card-text>
          </b-card>
        </b-collapse>
      </div>
    </div>

    <div v-if="this.students.length <= 0 && !this.isLoading">
      <h1>لا يوجد طلاب في قاعدة البيانات</h1>
    </div>
    <div v-if="this.isLoading">
      <h1>جاري التحميل</h1>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getAllStudent();
  },
  data() {
    return {
      students: [],
      isLoading: true,
    };
  },
  methods: {
    toggle(item) {
      const id = item.target.id.split(" ")[1];
      const items = document.getElementById(id);
      const divList = document.getElementsByClassName("mt-2");
      divList.forEach((div) => {
        const classList = div.className;
        if (classList.indexOf("show") !== -1 && div !== items)
          div.classList = div.className.replace("show", "");
      });
    },
    getAllStudent() {
      axios.post("/api/get_all_students").then((response) => {
        this.students = response.data;

        this.isLoading = false;
      });
    },
  },
};
</script>

<style scoped>
.grid-table {
  display: grid;
  grid-template-columns: repeat(5, minmax(92px, 1fr));
  justify-items: start;
  gap: 10px;
}
</style>