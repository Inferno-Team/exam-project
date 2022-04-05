<template>
  <Tilt class="_card" :options="option">
    <h3>{{ data.title }}</h3>
    <div class="content">
      <h2>{{ data.desc }}</h2>
      <a :id="index" @click.prevent="move">الانتقال إلى الصفحة</a>
    </div>
  </Tilt>
</template>
<script>
import Tilt from "vanilla-tilt-vue";
export default {
  components: { Tilt },
  setup() {},
  props: ["data", "index"],
  methods: {
    move(event) {
      this.$emit("report-click", event);
    },
  },
  data() {
    return {
      option: {
        max: 25,
        speed: 400,
        transition: true,
        easing: "cubic-bezier(.03,.98,.52,.99)",
        glare: true,
      },
    };
  },
};
</script>
<style scoped>
._card {
  position: relative;
  width: 200px;
  height: 250px;
  margin: 30px;
  opacity: 0.5;
  box-shadow: 20px 20px 30px rgba(88, 157, 221, 0.541);
  border-radius: 15px;
  background: rgba(175, 187, 255, 0.2);
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  border-top: 1px solid rgba(255, 255, 255, 0.5);
  border-left: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(5px);
  flex-direction: column;
}
._card .content {
  padding: 20px;
  text-align: center;
  transform: translateY(100px);
  opacity: 0;
  transition: 0.5s;
}
._card:hover {
  opacity: 1;
}
._card:hover .content {
  transform: translateY(0);
  opacity: 1;
}

._card h3 {
  font-size: 1.4rem;
  color: rgb(1, 80, 249);
  z-index: 1;
}

._card .content h2 {
  font-size: 1.3em !important;
  color: rgb(0, 0, 0);
  z-index: 1;
}

._card .content a {
  position: relative;
  display: inline-block;
  padding: 10px;
  margin-top: 7px;
  background: #fff;
  text-decoration: none;
  font-weight: 500;
  border-radius: 20px;
  color: #000;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  cursor: pointer;
}
</style>