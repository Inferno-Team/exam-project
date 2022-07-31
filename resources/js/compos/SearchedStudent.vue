<template>
  <div class="card text-center m-3">
    <div class="tables">
      <table>
        <tr>
          <th scope="row">رقم الجامعي</th>
          <th scope="row">السنة</th>
          <th scope="row">اسم الطالب</th>
          <th scope="row">الكنية</th>
        </tr>
        <tr v-for="(student, i) in pageOfItems" :key="i">
          <th scope="row">{{ student.student.univ_id }}</th>
          <th scope="row">{{ student.year.name }}</th>
          <th scope="row">{{ student.student.name }}</th>
          <th scope="row">{{ student.student.last_name }}</th>
        </tr>
      </table>
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
        console.log(names);
        var name = names[0];
        var father_name = names.length > 2 ? names[1] : "%";
        var last_name = names.length >= 2 ? names[names.length - 1] : "%";
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
th,
td {
  border: 1px solid;
  padding: 0.5rem;
}
th {
  text-align: center;
}
table {
  width: 80%;
  /* display: inline-block; */
  border-collapse: collapse;
}
.tables {
  display: flex;
  justify-content: center;
}
</style>