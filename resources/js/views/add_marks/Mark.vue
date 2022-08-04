<template>
  <div>
    <div class="tables">
      <table v-if="students.length > 0">
        <tr>
          <td rowspan="2">تسلسل</td>
          <td rowspan="2">الرقم الجامعي</td>
          <td rowspan="2">الاسم والكنية</td>

          <td colspan="2">الدرجات</td>
          <td colspan="2">المجموع</td>
          <td rowspan="2">النتيجة</td>
        </tr>
        <tr>
          <td>عملي</td>
          <td>تحريري</td>
          <td>رقماً</td>
          <td>كتابة</td>
        </tr>
        <tr v-for="(student, i) in students" :key="i">
          <th scope="row">{{ i + 1 }}</th>
          <th scope="row">{{ student.univ_id }}</th>
          <th scope="row">{{ student.name }}</th>
          <th scope="row">{{ student.mark1 }}</th>
          <th scope="row">{{ student.mark2 }}</th>
          <th scope="row">{{ student.fullMark }}</th>
          <th scope="row">{{ student.fullMarkWrite }}</th>
          <th scope="row">{{ student.result }}</th>
        </tr>
      </table>
      <vue-dropzone
        v-else
        ref="myVueDropzone"
        id="dropzone"
        :options="dropzoneOptions"
        @vdropzone-file-added="vfileAdded"
      ></vue-dropzone>
    </div>
  </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import * as XLSX from "xlsx";
import { toArabicWord } from "number-to-arabic-words/index.js";

import EditableRowItem from "../../compos/reportes/generate/EditableRowItem.vue";
export default {
  components: { vueDropzone: vue2Dropzone, EditableRowItem },
  data() {
    return {
      students: [],
      dropzoneOptions: {
        acceptedFiles:
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        url: "https://httpbin.org/post",
        autoProcessQueue: false,
        maxFilesize: 0.5,
        addRemoveLinks: true,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        maxFiles: 1,
        thumbnailMethod: "contain",
      },
    };
  },
  methods: {
    vfileAdded(file) {
      const reader = new FileReader();

      reader.onload = (event) => {
        var data = new Uint8Array(event.target.result);
        let workbook = XLSX.read(data, { type: "array" });
        let first_sheet_name = workbook.SheetNames[0];
        let worksheet = workbook.Sheets[first_sheet_name];
        let _students = XLSX.utils.sheet_to_json(worksheet, {
          header: 1,
        });
        console.log(_students);
        _students.forEach((student) => {
          if (student !== _students[0])
            this.students.push({
              id: student[0],
              univ_id: student[1],
              name: student[2],
              mark1: student[3],
              mark2: student[4],
              fullMark: student[3] + student[4],
              fullMarkWrite: toArabicWord(student[3] + student[4]),
              result: "",
            });
        });
      };
      reader.readAsArrayBuffer(file);
    },
  },
  mounted() {},
};
</script>

<style scoped>
th,
td {
  border: 1px solid;
  padding: 0.5rem;
}
th,
td {
  text-align: center;
  font-weight: 600;
  font-size: 21px;
}
table {
  width: 80%;
  /* display: inline-block; */
  border-collapse: collapse;
}
.tables {
  display: flex;
  justify-content: center;
  height: 99%;
  overflow-y: auto;
}
</style>