<template>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th scope="row">رقم الجلوس</th>
          <th scope="row">رقم الطالب الجامعي</th>
          <th scope="row">اسم الطالب</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(student, i) in students" :key="i">
          <th scope="row">{{ student.student.id }}</th>
          <th scope="row">{{ student.student.univ_id }}</th>
          <th scope="row">{{ student.student.name }}</th>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  props: ["students"],
};
</script>
<style scoped>
th,
td {
  border: 1px solid;
  padding: 0.5rem;
  /* display: block; */
}
.table-container {
  overflow-y: auto;
  height: 80%;
}
table {
  width: 100%;

  border-collapse: collapse;
}
</style>