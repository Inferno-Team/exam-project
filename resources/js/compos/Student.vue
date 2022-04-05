<template>
  <div >
    <b-button
      v-b-toggle="'' + student.univ_id"
      :id="'id ' + student.univ_id"
      variant="primary"
      style="width: 90%"
      @click="toggle($event)"
      >{{ student.name }}</b-button
    >
    <b-collapse :id="'' + student.univ_id" class="mt-2">
      <b-card
        border-variant="primary"
        :header="student.univ_id"
        header-bg-variant="primary"
        header-text-variant="white"
        align="center"
      >
        <b-card-text>{{ student.year.year.name }}</b-card-text>
        <b-card-text>{{ student.father_name }}</b-card-text>
        <b-card-text>{{ student.last_name }}</b-card-text>
      </b-card>
    </b-collapse>
  </div>
</template>
<script>
export default {
  props: ["student"],
  methods: {
    toggle(item) {
      const id = item.target.id.split(" ")[1];
      this.$emit("clicked", id);
    },
  },
};
</script>