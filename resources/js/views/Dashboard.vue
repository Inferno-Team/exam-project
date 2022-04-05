<template>
  <div class="dashboard">
    <sidebar-menu :menu="menu" :rtl="true" :relative="true" />
    <div class="my-container">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menu: [
        {
          header: false,
          title: "Dashboard",
          icon: "fa fa-bars",
        },
        {
          title: "عرض كافة الطلاب",
          icon: "fa fa-university",
          href: "/dashboard/show-all.student",
        },
        {
          title: "دكتور",
          icon: "fa fa-user",
          href: "/dashboard/show-all.doctor",
        },
        {
          title: "إضافة علامات الطلاب",
          icon: "fa fa-user",
          child: [
            {
              title: "عملي",
              icon: "fa fa-pencil-square-o",
              href: "/dashboard/add.marks1",
            },
            {
              title: "نظري",
              icon: "fa fa-minus",
              href: "/dashboard/add.marks2",
            },
          ],
        },
        {
          title: "إضافة مادة",
          icon: "fa fa-pencil-square-o",
          href: "/dashboard/add.course",
        },
        {
          title: "توليد تقرير",
          icon: "fa fa-pencil-square-o",
          href: "/dashboard/reports",
        },
        {
          title: "تحديد تواريخ",
          icon: "fa fa-clock-o",
          href: "/dashboard/dates",
        },
      ],
    };
  },
};
</script>

<style>
.dashboard {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.dashboard .my-container {
  width: 100%;
  height: 100%;
  background: #ccc;
}
.v-sidebar-menu .vsm--toggle-btn::after {
  content: "\f03a" !important;
  font-family: "FontAwesome" !important;
}
.v-sidebar-menu .vsm--arrow::after {
  content: "\f060" !important;
  font-family: "FontAwesome" !important;
}
</style>