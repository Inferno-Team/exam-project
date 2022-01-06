<template>
  <div class="my-container">
    <NavBar />
    <div class="first-section">
      <img src="/imgs/home_img.jpg" />
    </div>
  </div>
</template>

<script>
export default {

  data() {
    return {
      user: {},
    };
  },
  methods: {
    getUser() {
      axios
        .get("/api/user")
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
<style >
.my-container {
  display: flex;
  justify-content: space-between;
  flex-direction: column;
}
.first-section img {
  width: 100%;
  height: 100%;
  opacity: 0.75;
}
.-first-section::before {
  content: "";
  position: absolute;
  top: 56px;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(225deg, #e91e63, #03a9fa);
  z-index: 1;
  mix-blend-mode: screen;
}
</style>