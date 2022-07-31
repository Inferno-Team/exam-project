<template>
  <div>
    <div class="tables">
      <table>
        <tr>
          <th scope="row">ت</th>
          <th scope="row">رقم الجامعي</th>
          <th scope="row">اسم الطالب</th>
          <th scope="row">العملي</th>
          <th scope="row">النظري</th>
          <th scope="row">المجموع</th>
          <th scope="row">كتابة</th>
          <th scope="row">النتيجة</th>
        </tr>
        <tr v-for="(student, i) in students" :key="i">
          <th scope="row">{{ i + 1 }}</th>
          <th scope="row">{{ student.student.univ_id }}</th>
          <th scope="row">{{ student.name + " " + student.last_name }}</th>
          <th scope="row" :id="'h ' + i" @dblclick="onHallDoubleClick($event)">
            <div v-if="mark1State[i]" :id="'mk1 ' + i">
              {{ students[i].mark1 }}
            </div>
            <input
              v-model="students[i].mark1"
              v-else
              class="in-input"
              type="text"
              autocomplete="off"
            />
          </th>
          <th scope="row">{{ student.student.last_name }}</th>
          <th scope="row">{{ student.student.last_name }}</th>
          <th scope="row">{{ student.student.last_name }}</th>
          <th scope="row">{{ student.student.last_name }}</th>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      students: [],
    };
  },
  methods: {
      
  },
  mounted() {},
};
</script>

<style>
</style>