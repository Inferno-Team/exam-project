<template>
  <div class="card text-center m-3">
    <h2 class="name">{{ name }}</h2>
    <div class="grid-table">
      <div
        style="width: 90%"
        v-for="(student, index) in this.pageOfItems"
        :key="index"
      >
        <Student :student="student" @clicked="toggle" />
      </div>
    </div>
    <div class="card-footer pb-0 pt-3">
      <jw-pagination
        :items="students"
        :pageSize="15"
        @changePage="onChangePage"
      ></jw-pagination>
    </div>
  </div>
</template>
<script>
import Student from "./Student.vue";
export default {
  props: ["number", "name"],
  components: { Student },
  mounted() {
    this.getAllStudent();
  },

  data() {
    return {
      students: [],
      pageOfItems: [],
    };
  },
  methods: {
    toggle(id) {
      // const id = item.target.id.split(" ")[1];
      const items = document.getElementById(id);
      const divList = document.getElementsByClassName("mt-2");
      divList.forEach((div) => {
        const classList = div.className;
        if (classList.indexOf("show") !== -1 && div !== items)
          div.classList = div.className.replace("show", "");
      });
    },
    getAllStudent() {
      axios
        .post(`/api/get_all_students/${this.$props.number}?page=1`)
        .then((response) => {
          this.students = response.data.students;
        });
    },
    onChangePage(val) {
      this.pageOfItems = val;
    },
  },
};
</script>

<style scoped>
.name {
  margin: 1rem;
}
.grid-table {
  margin: 1.2rem;
  padding: 0.2rem;
  display: grid;
  grid-template-columns: repeat(5, minmax(92px, 1fr));
  justify-items: start;
  gap: 10px;
}
</style>