<template>
  <div
    style="height: 99%; overflow-y: auto"
    v-if="supervisor != null && date != null"
  >
    <div id="printable" style="margin: 1rem; padding: 1rem">
      <p class="data" style="font-size: 17px">
        الجمهورية العربية السورية
        <br />
        جامعة حلب <br />
        كلية هندسة المعلوماتية
      </p>

      <div
        style="
          margin-top: 1rem;
          margin-left: 4rem;
          margin-right: 4rem;
          text-align: center;
        "
      >
        <p>تكليف المراقبات النظرية للدورة</p>
        <p class="data">{{ date.current }}</p>
        <p>للعاد الدراسي</p>
        <p class="data">{{ date.date }}</p>
      </div>
      <div style="margin-top: 1rem; margin-left: 4rem; margin-right: 4rem">
        <p style="font-size: 23px; text-decoration: underline">المراقب :</p>
        <p class="data">{{ supervisor.name }}</p>
      </div>
      <div>
        <div
          @click.prevent="addRow"
          class="add"
          v-if="toPrint"
          style="max-width: fit-content; padding: 0.5rem; margin: 0.5rem"
        >
          +
        </div>
        <supervisor-table :size="size" />
      </div>

      <div
        style="display: flex; justify-content: space-evenly; margin-top: 3rem"
      >
        <p>رئيسة شعبة الامتحانات</p>
        <p>رئيس الدائرة</p>
        <p>عميد كلية هندسة المعلوماتية</p>
      </div>
    </div>
    <div class="floating-container">
      <div class="floating-button" @click="print">طباعة</div>
    </div>
  </div>
</template>

<script>
import html2PDF from "jspdf-html2canvas";
import SupervisorTable from "../../../compos/reportes/generate/SupervisorTable.vue";
export default {
  components: { SupervisorTable },
  props: ["object"],
  mounted() {
    this.getSupervisor();
    this.loadDate();
  },
  data() {
    return {
      date: null,
      size: 3,
      toPrint: true,
      supervisor: null,
    };
  },
  methods: {
    getSupervisor() {
      axios
        .post(`/api/get_supervisor/${this.object}`)
        .then((result) => {
          this.supervisor = result.data;
        })
        .catch(console.error);
    },
    loadDate() {
      axios
        .get("/api/dates")
        .then((result) => {
          this.date = {};
          var date = result.data;
          var startYear;
          const d = new Date();
          if (date.current === "first-tirm") startYear = d.getFullYear();
          else startYear = d.getFullYear() - 1;
          if (
            date.current === "first-tirm" ||
            date.current === "first-tirm-exam" ||
            date.current === "spring-holiday"
          ) {
            this.date.current = "الفصل الأول";
          } else this.date.current = "الفصل الثاني";
          this.date.date = `${startYear}/${startYear + 1}`;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    print() {
      this.toPrint = false;
      setTimeout(() => {
        let printable = document.getElementById("printable");
        html2PDF(printable, {
          jsPDF: {
            format: "a4",
          },
          imageType: "image/jpeg",
          output: `/pdf/${this.supervisor.name}.pdf`,
        });
      }, 100);

      setTimeout(() => {
        this.toPrint = true;
      }, 1000);
    },
    addRow() {
      this.size++;
    },
  },
};
</script>

<style scoped>
p {
  font-size: 1.75rem;
  display: inline;
  font-weight: 400;
}
.data {
  font-weight: 600;
}
.add {
  font-size: 1.5rem;
  font-weight: 600;
  cursor: pointer;
}
.add:hover {
  color: #00bcd4;
}
</style>