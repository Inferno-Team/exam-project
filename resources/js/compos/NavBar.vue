<template>
  <div style="padding: 0px !important">
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand href="#">كلية هندسة المعلوماتية</b-navbar-brand>
      <b-navbar-toggle target="navbar-toggle-collapse"></b-navbar-toggle>
      <b-collapse id="navbar-toggle-collapse" is-nav>
        <b-navbar-nav class="ml-auto">
          <b-button
            class="my-sm-0"
            type="submit"
            @click="dashboard"
            v-if="isLoggedIn"
            >لوحة الإدارة</b-button
          >
          <b-button
            class="my-sm-0"
            type="submit"
            @click="logout"
            v-if="isLoggedIn"
            >تسجيل الخروج</b-button
          >
          <b-button
            class="my-sm-0"
            type="submit"
            @click="login"
            v-if="!isLoggedIn"
            >تسجيل الدخول</b-button
          >
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>
<script>
export default {
  mounted() {
    if (localStorage.getItem("user-token") !== null) {
      this.isLoggedIn = true;
    } else this.isLoggedIn = false;
  },
  data() {
    return {
      isLoggedIn: false,
    };
  },
  methods: {
    logout() {
      axios
        .post("/api/logout")
        .then((response) => {
          console.log(response);
          if (response.status === 200) {
            location.reload();
          }
        })
        .catch((error) => console.log(error));
      localStorage.removeItem("user-token");
    },
    login() {
      this.$router.push({ name: "login" });
    },
    dashboard() {
      this.$router.push({ name: "dashboard" });
    },
  },
};
</script>
<style >
.navbar-collapse {
  justify-content: flex-end;
}
.my-sm-0 {
  margin-left: 16px;
}
</style>