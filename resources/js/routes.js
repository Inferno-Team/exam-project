import Login from "./views/Login";
import Home from "./views/Home";
import Dashboard from "./views/Dashboard";
import AddStudent from "./views/student/AddStudent";
import RemoveStudent from './views/student/RemoveStudent';
import UpdateStudent from './views/student/UpdateStudent';
import ShowAllStudent from './views/student/ShowAllStudent';
import AddDoctor from './views/doctor/AddDoctor';
import RemoveDoctor from './views/doctor/RemoveDoctor';
import UpdateDoctor from './views/doctor/UpdateDoctor';
import Mark1 from './views/add_marks/Mark1';
import Mark2 from './views/add_marks/Mark2';
import AddCourse from './views/courses/AddCourse';
export const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        children: [

            // dashboard - student
            {
                name: 'add-student',
                path: '/dashboard/add.student',
                component: AddStudent
            },
            {
                name: 'remove-student',
                path: '/dashboard/remove.student',
                component: RemoveStudent
            },
            {
                name: 'update-student',
                path: '/dashboard/update.student',
                component: UpdateStudent
            },
            {
                name: 'show-all-student',
                path: '/dashboard/show-all.student',
                component: ShowAllStudent
            },

            // dashboard - doctors
            {
                name: 'add-doctor',
                path: "/dashboard/add.doctor",
                component: AddDoctor
            },
            {
                name: 'remove-doctor',
                path: '/dashboard/remove.doctor',
                component: RemoveDoctor
            },
            {
                name: 'update-doctor',
                path: '/dashboard/update.doctor',
                component: UpdateDoctor
            },
            {
                name: 'add-mark1',
                path: '/dashboard/add.marks1',
                component: Mark1
            },
            {
                name: 'add-mark2',
                path: '/dashboard/add.marks2',
                component: Mark2
            },
            {
                name: 'add-course',
                path: '/dashboard/add.course',
                component: AddCourse
            },



        ]
    },


]