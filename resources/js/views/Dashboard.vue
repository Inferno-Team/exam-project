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
          title: "طالب",
          icon: "fa fa-user",
          child: [
            {
              title: "عرض كافة الطالب",
              icon: "fa fa-university",
              href: "/dashboard/show-all.student",
            },
            {
              title: "إضافة طالب",
              icon: "fa fa-plus",
              href: "/dashboard/add.student",
            },
            {
              title: "حذف طالب",
              icon: "fa fa-minus",
              href: "/dashboard/remove.student",
            },
            {
              title: "تعديل طالب",
              icon: "fa fa-pencil-square-o",
              href: "/dashboard/update.student",
            },
          ],
        },
        {
          title: "دكتور",
          icon: "fa fa-user",
          child: [
            {
              title: "إضافة دكتور",
              icon: "fa fa-plus",
              href: "/dashboard/add.doctor",
            },
            {
              title: "حذف دكتور",
              icon: "fa fa-minus",
              href: "/dashboard/remove.doctor",
            },
            {
              title: "تعديل دكتور",
              icon: "fa fa-pencil-square-o",
              href: "/dashboard/update.doctor",
            },
          ],
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