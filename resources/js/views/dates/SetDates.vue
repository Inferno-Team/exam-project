<template>
  <div>
    <div v-if="dates != null">
      <DateComponent
        :title="'تاريخ بداية الفصل الأول'"
        :field="'1'"
        :oldDate="dates.first_tirm_start"
      />
      <DateComponent
        :title="'تاريخ نهاية الفصل الأول'"
        :field="'2'"
        :oldDate="dates.first_tirm_end"
      />
      <DateComponent
        :title="'تاريخ نهاية امتحانات الفصل الأول'"
        :field="'3'"
        :oldDate="dates.first_tirm_exam_end"
      />
      <DateComponent
        :title="'تاريخ بداية الفصل الثاني'"
        :field="'4'"
        :oldDate="dates.second_tirm_start"
      />
      <DateComponent
        :title="'تاريخ نهاية الفصل الثاني'"
        :field="'5'"
        :oldDate="dates.second_tirm_end"
      />
      <DateComponent
        :title="'تاريخ نهاية امتحانات الفصل الثاني'"
        :field="'6'"
        :oldDate="dates.second_tirm_exam_end"
      />
      <DateComponent
        :title="'تاريخ بداية السنة الجديدة'"
        :field="'7'"
        :oldDate="dates.next_year_first_tirm_start"
      />
    </div>
  </div>
</template>
<script>
import DateComponent from "../../compos/DateComponent.vue";
export default {
  components: { DateComponent },
  mounted() {
    axios
      .get("/api/dates")
      .then((response) => {
        this.dates = response.data;
        console.log(this.dates);
      })
      .catch((err) => console.log(err));
  },
  data() {
    return {
      dates: null,
    };
  },
};
</script>
<style scoped>
.flexContainer {
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
</style>