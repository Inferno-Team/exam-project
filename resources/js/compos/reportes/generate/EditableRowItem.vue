<template>
  <th scope="row" @dblclick="localState = !localState" :id="insideId">
    <div v-if="localState" :id="insideId">
      {{ localData }}
    </div>
    <input
      v-model="localData"
      v-else
      class="in-input"
      @change="onDataChange"
      type="text"
      style="width: 5rem"
      autocomplete="off"
    />
  </th>
</template>

<script>
export default {
  props: ["state", "data", "insideId"],
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
    data() {
      this.localData = this.data;
    },
  },
  methods: {
    onDataChange() {
      this.localState = true;
      this.$emit("change", { data: this.localData, id: this.insideId });
    },
  },
};
</script>

<style>
</style>