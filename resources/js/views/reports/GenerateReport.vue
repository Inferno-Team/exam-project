<template>
  <div>
    <div class="report-container">
      <Report
        v-for="(_, index) in this.reports"
        :data="reports[index]"
        :key="index"
        :index="index"
        @report-click="click"
      />
      <StudentSearchField
        @generate="generate"
        @reset-values="reset"
        style="position: absolute; right: 50%; top: 0%"
        :is_shows="is_shows"
      />
      <AddSelectableCourse
        :is_shows="is_shows2"
        @response="onSelectCourseResponse"
        @reset-values="reset2"
        style="position: absolute; right: 50%; top: 0%"
      />
    </div>
    <Notification :notification="notify" />
  </div>
</template>
<script>
import Report from "../../compos/Report.vue";
import StudentSearchField from "../../compos/reportes/StudentSearchField.vue";
import AddSelectableCourse from "../../compos/reportes/AddSelectableCourse.vue";
import Notification from "../../compos/Notification.vue";

export default {
  components: {
    Report,
    StudentSearchField,
    AddSelectableCourse,
    Notification,
  },
  data() {
    return {
      reports: [
        {
          title: "توليد كشف علامات",
          desc: "",
        },
        {
          title: "اخيتار مادة",
          desc: "تقديم طلب لاختيار مادة من المجموعات 1..5",
        },
        {
          title: "إنشاء تكليف امتحاني",
          desc: "إنشاء تكليف امتحاني للدكاترة",
        },
        {
          title: "تقرير بأسماء الطلاب المنقولين",
          desc: "",
        },
        {
          title: "تقرير بأسماء الطلاب الراسبين",
          desc: "",
        },
        {
          title: "تقرير بأسماء الطلاب الناجحين",
          desc: "",
        },
      ],
      is_shows: false,
      is_shows2: false,
      is_shows3: false,
      notify: {
        msg: "",
        code: -1,
      },
      reportType: ["منقول", "راسب", "ناجح"],
    };
  },
  methods: {
    click(event) {
      const _index = event.target.id;
      if (_index === "0") {
        this.is_shows = !this.is_shows;
      } else if (_index === "1") this.is_shows2 = !this.is_shows2;
      else if (_index === "3" || _index === "4" || _index === "5")
        this.$router.push({
          name: "report",
          params: {
            object: this.reportType[_index - 3],
          },
        });
    },
    generate({
      univ_id,
      blood,
      bloodDate,
      check,
      checkDate,
      graduationNumber,
      graduationDate,
    }) {
      console.log(univ_id);
      this.$router.push({
        name: "marks_report",
        params: {
          object: {
            univID: univ_id,
            blood: blood,
            check: check,
            bloodDate: bloodDate,
            checkDate: checkDate,
            graduationNumber: graduationNumber,
            graduationDate: graduationDate,
          },
        },
      });
    },
    reset(value) {
      this.is_shows = value;
    },
    reset2(value) {
      this.is_shows2 = value;
    },
    onSelectCourseResponse(response) {
      // response : {course? , code , msg}
      console.log(response);
      let msg = response.msg;
      if (response.code == 400) {
        response.course.forEach((course) => {
          msg += ` \n اسم المادة : ${course.course.name}\n`;
        });
      }
      this.notify = {
        code: response.code,
        msg: msg,
      };
    },
  },
};
</script>
<style scoped>
.report-container {
  display: grid;
  grid-template-columns: repeat(3, minmax(92px, 0.5fr));
  justify-items: center;
  gap: 10px;
  height: 99%;
  overflow-y: auto;
}
</style>