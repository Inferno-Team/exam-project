<template></template>

<script>
export default {
  mounted() {
    const token = localStorage.getItem("user-token");

    if (token !== undefined && token !== null)
      this.$router.push({ path:"/dashboard/" });
    else this.$router.push({ name: "login" });
  },
};
</script>

<style>
</style>