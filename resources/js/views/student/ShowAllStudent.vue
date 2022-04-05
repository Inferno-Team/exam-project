<template>
  <div style="overflow-y: scroll; height: 100%">
    <SearchComponent @search-value="search" />
    <div v-if="!this.isSearching">
      <div v-for="(year, index) in this.years" :key="index">
        <YearsStudents :number="year.id" :name="year.name" />
      </div>
    </div>

    <div class="search-items" v-if="this.isSearching">
      <SearchedStudent :name="this.searchValue" />
    </div>

    <div v-if="this.years.length <= 0 && !this.isLoading">
      <h1>لا يوجد طلاب في قاعدة البيانات</h1>
    </div>
    <div v-if="this.isLoading">
      <h1>جاري التحميل</h1>
    </div>
  </div>
</template>

<script>
import YearsStudents from "../../compos/YearsStudents.vue";
import SearchComponent from "../../compos/SearchComponent.vue";
import SearchedStudent from "../../compos/SearchedStudent.vue";
export default {
  mounted() {
    this.getYears();
  },
  components: {
    YearsStudents,
    SearchComponent,
    SearchedStudent,
  },
  data() {
    return {
      years: [],
      isLoading: true,
      isSearching: false,
      searchValue: "",
    };
  },
  methods: {
    getYears() {
      axios
        .post("/api/get_years")
        .then((response) => {
          this.years = response.data.years;
          this.isLoading = false;
        })
        .catch((error) => console.log(error));
    },
    search(value) {
      // console.log(value);
      this.searchValue = value;
      if (this.searchValue !== "") this.isSearching = true;
      else this.isSearching = false;
    },
  },
};
</script>
