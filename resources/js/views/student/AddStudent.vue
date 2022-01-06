<template>
  <div class="container" style="padding: 1rem; background: #ccc">
    <b-form
      @submit.prevent="addStudent"
      style="padding-left: 3rem; padding-right: 3rem"
    >
      <b-form-group id="input-group-1" label="اسم الطالب" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="student.name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-2" label="اسم الأب" label-for="input-2">
        <b-form-input
          id="input-2"
          v-model="student.father_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-2-2" label="الكنية" label-for="input-22">
        <b-form-input
          id="input-22"
          v-model="student.last_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="اسم الأم" label-for="input-3">
        <b-form-input
          id="input-3"
          v-model="student.mother_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-30" label="مكان الولادة" label-for="input-30">
        <b-form-input
          id="input-30"
          v-model="student.birth_place"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-4" label="رقم الخانة" label-for="input-4">
        <b-form-input
          id="input-4"
          v-model="student.field_number"
          type="number"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-5" label="شعبة التجنيد" label-for="input-5">
        <b-form-input
          id="input-5"
          v-model="student.recruitment_division"
          type="text"
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-7" label="العنوان" label-for="input-7">
        <b-form-input
          id="input-7"
          v-model="student.address"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        style="width: 50%"
        id="input-group-6"
        label="الجنس"
        label-for="input-6"
      >
        <b-form-select
          id="input-6"
          v-model="student.gender"
          :options="this.genderType"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>
      <b-form-group
        style="width: 50%"
        id="input-group-7"
        label="السنة"
        label-for="input-7"
      >
        <b-form-select
          id="input-7"
          v-model="student.year_name"
          :options="this.years"
          style="width: 50%"
          required
        ></b-form-select>
      </b-form-group>

      <b-button type="submit" variant="primary">إضافة</b-button>
    </b-form>
    <div
      class="notification"
      id="notification"
      :class="{
        success: this.notification.code === 200,
        error: this.notification.code > 200,
      }"
    >
      <div>
        <h3>{{ this.notification.msg }}</h3>
        <h2>{{ this.notification.code }}</h2>
      </div>
    </div>
  </div>
</template>
<script>
import {
  mdbContainer,
  mdbRow,
  mdbCol,
  mdbIcon,
  mdbBtn,
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter,
  mdbInput,
  mdbTextarea,
} from "mdbvue";
import "mdbvue/lib/css/mdb.min.css";

export default {
  mounted() {
    this.getYears();
  },
  components: {
    mdbContainer,
    mdbRow,
    mdbCol,
    mdbIcon,
    mdbBtn,
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbInput,
    mdbTextarea,
  },
  data() {
    return {
      student: {
        name: "",
        father_name: "",
        last_name: "",
        mother_name: "",
        gender: "",
        birth_place: "",
        field_number: null,
        recruitment_division: "",
        address: "",
        univ_id: 0,
        year_name: "",
      },
      rest_student: {
        name: "",
        father_name: "",
        last_name: "",
        mother_name: "",
        gender: "",
        birth_place: "",
        field_number: null,
        recruitment_division: "",
        address: "",
        univ_id: 0,
      },
      notification: {
        msg: "",
        code: -1,
      },
      genderType: ["انثى", "ذكر"],
      years: [],
      isAdded: false,
    };
  },
  methods: {
    showNotification() {
      const notf = document.getElementById("notification");
      if (notf !== null) {
        const oldClasss = notf.className;
        if (oldClasss.indexOf("notification-destory") !== -1)
          notf.className = notf.className.replace("notification-destory", "");
      }
      setTimeout(() => {
        const notf = document.getElementById("notification");
        const oldClasss = notf.className;
        notf.className = `${oldClasss} notification-destory`;
      }, 2500);
    },
    addStudent() {
      this.student.univ_id = this.generateUniversityId(0, 9999);
      console.log(JSON.stringify(this.student));
      axios
        .post("/api/add_student", this.student)
        .then((response) => {
          console.log(response);
          this.student = this.rest_student;
          this.isAdded = true;
          this.notification = {
            msg: response.data.msg,
            code: response.status,
          };
          this.showNotification();
        })
        .catch((error) => {
          console.log(error);
          this.notification = {
            code: 500,
            msg: "حصل خطأ ما",
          };
          this.isAdded = true;
          this.showNotification();
        });
    },
    generateUniversityId(min, max) {
      // min and max included
      return Math.floor(Math.random() * (max - min + 1) + min);
    },
    getYears() {
      axios
        .post("/api/get_years")
        .then((response) => {
          console.log(response);
          response.data.years.forEach((year) => {
            this.years.push(year.name);
          });
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
<style scoped>
.notification {
  width: 25%;
  border-radius: 0.8rem;
  position: absolute;
  bottom: 1rem;
  left: -30rem;
  padding: 4px;
  transition: 1s;
  
}
.notification h3,
.notification h2 {
  font-size: 1.2rem;
}
.success {
  border: 1px solid #0f0;
  background: rgb(123, 255, 123);
  left: 1rem;
}
.error {
  border: 1px solid #f00;
  background: rgb(255, 123, 123);
  left: 1rem;
}
.notification-destory {
  left: -30rem;
}
</style>