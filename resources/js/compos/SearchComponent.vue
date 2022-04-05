<template>
  <div class="search_comp">
    <form @submit.prevent>
      <i
        class="fa fa-search"
        style="position: absolute; padding: 10px; min-width: 40px; left: 0"
      />
      <input
        class="form-control mr-sm-2"
        type="text"
        placeholder="بحث عن طالب"
        aria-label="Search"
        v-model="value"
        v-on:input="onChange"
      />
    </form>
  </div>
</template>
<script>
import { mdbIcon, mdbFormInline, mdbInput } from "mdbvue";
export default {
  components: {
    mdbIcon,
    mdbFormInline,
    mdbInput,
  },
  data() {
    return {
      value: "",
    };
  },
  methods: {
    onChange(v) {
      this.$emit("search-value", this.value);
    },
  },
};
</script>
<style>
.search_comp {
  margin: 2rem;
  padding: 0.2rem;
}
.search_comp form {
  position: absolute;
  width: 65%;
  height: max-content;
}
</style>