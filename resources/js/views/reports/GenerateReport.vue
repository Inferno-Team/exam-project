<template>
  <div>
    <div class="report-container">
      <Report
        v-for="(rep, index) in this.reports"
        :data="rep"
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
      <ExamAssignmentForDoctors
        :is_shows="is_shows3"
        style="position: absolute; right: 50%; top: 0%"
        @response="onSelectDoctorResponse"
        @reset-values="reset3"
      />
      <ExamAssignmentForSupervisor
        :is_shows="is_shows4"
        style="position: absolute; right: 50%; top: 0%"
        @response="onSelectDoctorResponse"
        @reset-values="reset4"
      />
      <TopTenYearSelector
        :is_shows="is_shows5"
        style="position: absolute; right: 50%; top: 0%"
        @response="onSelectYearResponse"
        @reset-values="reset5"
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
import ExamAssignmentForDoctors from "../../compos/reportes/ExamAssignmentForDoctors.vue";
import ExamAssignmentForSupervisor from "../../compos/reportes/ExamAssignmentForSupervisor.vue";
import TopTenYearSelector from "../../compos/reportes/TopTenYearSelector.vue";

export default {
  components: {
    Report,
    StudentSearchField,
    AddSelectableCourse,
    Notification,
    ExamAssignmentForDoctors,
    ExamAssignmentForSupervisor,
    TopTenYearSelector,
  },
  data() {
    return {
      reports: [
        {
          title: "توليد كشف علامات",
          desc: "توليد كشف علامات لكافة الطلاب",
        },
        {
          title: "اخيتار مادة",
          desc: "تقديم طلب لاختيار مادة من المجموعات 1..5",
        },
        {
          title: "إنشاء تكليف امتحاني",
          desc: "إنشاء تكليف للدكاترة لكتابة اسئلة موادهم",
        },
        {
          title: "إنشاء تكليف مراقبة",
          desc: "إنشاء تكليف للدكاترة و المهندسين و الموظفين لمراقبة العملية الامتحانية",
        },
        {
          title: "تقرير بأسماء الطلاب المنقولين",
          desc: "تقرير بأسماء الطلاب المنقولين",
        },
        {
          title: "تقرير بأسماء الطلاب الراسبين",
          desc: "تقرير بأسماء الطلاب الراسبين",
        },
        {
          title: "تقرير بأسماء الطلاب الناجحين",
          desc: "تقرير بأسماء الطلاب الناجحين",
        },
        {
          title: "تقرير العشر الاوائل",
          desc: "تقرير بأسماء الطلاب العشر الاوائل",
        },
      ],
      is_shows: false,
      is_shows2: false,
      is_shows3: false,
      is_shows4: false,
      is_shows5: false,
      notify: {
        msg: "",
        code: -1,
      },
      reportType: ["منقول", "راسب", "ناجح"],
    };
  },
  methods: {
    click(id) {
      const _index = id;
      if (_index == 0) {
        this.is_shows = !this.is_shows;
      } else if (_index == 1) this.is_shows2 = !this.is_shows2;
      else if (_index == 2) {
        this.is_shows3 = !this.is_shows3;
      } else if (_index == 3) {
        this.is_shows4 = !this.is_shows4;
      } else if (_index == 4 || _index == 5 || _index == 6)
        this.$router.push({
          name: "report",
          params: {
            object: this.reportType[_index - 4],
          },
        });
      else if (_index == 7) {
        this.is_shows5 = !this.is_shows5;
      }
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
    reset3(value) {
      this.is_shows3 = value;
    },
    reset4(value) {
      this.is_shows4 = value;
    },
    reset5(value) {
      this.is_shows5 = value;
    },

    onSelectDoctorResponse(response) {},
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
    onSelectYearResponse() {
      this.is_shows5 = false;
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