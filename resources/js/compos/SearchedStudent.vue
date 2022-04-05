<template>
  <div class="card text-center m-3">
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
        :pageSize="30"
        @changePage="onChangePage"
      ></jw-pagination>
    </div>
  </div>
</template>
<script>
import Student from "./Student.vue";
export default {
  props: ["name"],
  components: { Student },
  watch: {
    name: {
      immediate: true,
      handler(nVal, oVal) {
        this.search(nVal);
      },
    },
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
    search(val) {
      if (!isNaN(val)) {
        axios
          .get(`/api/search_by_id?id=${val}&page=1`)
          .then((response) => {
            console.log(response);
            this.students = response.data.data;
          })
          .catch((error) => console.log(error));
      } else {
        var names = val.split(" ");
        var name = names[0];
        var father_name = names.length > 1 ? names[1] : "";
        var last_name = names.length > 2 ? names[2] : "";
        axios
          .get(
            `/api/search?page=1&name=${name}&f_name=${father_name}&l_name=${last_name}`
          )
          .then((response) => {
            this.students = response.data.data;
          })
          .catch((error) => console.log(error));
      }
    },
    onChangePage(val) {
      this.pageOfItems = val;
    },
  },
};
</script>

<style scoped>
.grid-table {
  margin: 1.2rem;
  padding: 0.2rem;
  display: grid;
  grid-template-columns: repeat(5, minmax(92px, 1fr));
  justify-items: start;
  gap: 10px;
}
</style>