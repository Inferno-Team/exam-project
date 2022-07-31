<template>
  <div class="card text-center m-3">
    <h2 class="name">{{ name }}</h2>
    <div class="tables">
      <table>
        <tr>
          <th scope="row">رقم الجامعي</th>
          <th scope="row">اسم الطالب</th>
          <th scope="row">الكنية</th>
        </tr>
        <tr v-for="(student, i) in pageOfItems" :key="i">
          <th scope="row">{{ student.univ_id }}</th>
          <th scope="row">{{ student.name }}</th>
          <th scope="row">{{ student.last_name }}</th>
        </tr>
      </table>
    </div>
    <div class="card-footer pb-0 pt-3">
      <jw-pagination
        :items="students"
        :pageSize="10"
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
          console.log(response.data);
          this.students = response.data.students;
        })
        .catch((e) => console.log(e));
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