<template>
  <th scope="row" @dblclick="localState = !localState">
    <div v-if="localState">
      {{ localData }}
    </div>
    <input
      v-model="localData"
      v-else
      class="in-input"
      @change="onDataChange"
      type="text"
      autocomplete="off"
    />
  </th>
</template>

<script>
export default {
  props: ["state", "data"],
  mounted() {
    this.localState = this.state;
    this.localData = this.data;
  },
  data() {
    return {
      localState: Boolean,
      localData: String,
    };
  },
  watch: {
    state() {
      this.localState = this.state;
    },
  },
  methods: {
    onDataChange() {
      this.$emit("change", this.localData);
    },
  },
};
</script>

<style>
</style>