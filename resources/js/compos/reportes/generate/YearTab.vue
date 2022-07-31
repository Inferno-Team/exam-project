<template>
  <div class="year-tab-container">
    <div v-for="(year, index) in years" :key="index" >
      <b-button
        :id="year.id"
        variant="primary"
        class="year-button"
        @click="click($event)"
        >{{ year.name }}</b-button
      >
    </div>
  </div>
</template>
<script>
export default {
  props: ["years"],
  methods: {
    click(event) {
      const id = event.target.id;
      this.$emit("selectYear",id);
    },
  },
};
</script>
<style scoped>
.year-tab-container {
  display: flex;
  justify-content: space-evenly;
  margin: 1rem;
}
.year-button {
  padding: 0.5rem;
}
</style>