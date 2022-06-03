import Login from "./views/Login";
import Home from "./views/Home";
import Dashboard from "./views/Dashboard";
import ShowAllStudent from './views/student/ShowAllStudent';
import ShowAllDoctor from './views/doctor/ShowAllDoctor'
import Mark1 from './views/add_marks/Mark1';
import Mark2 from './views/add_marks/Mark2';
import AddCourse from './views/courses/AddCourse';
import GenerateReport from './views/reports/GenerateReport';
import SetDate from './views/dates/SetDates';
import MarksReport from './views/reports/templates/MarksReport';
import StudentReport from './views/reports/templates/StudentReport';

export const routes = [{
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
                name: 'show-all-student',
                path: '/dashboard/show-all.student',
                component: ShowAllStudent
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
            {
                name: 'reports',
                path: '/dashboard/reports',
                component: GenerateReport,
            },
            {
                name: 'marks_report',
                path: '/dashboard/generate/:object',
                component: MarksReport,
                props: true
            },
            {
                name: 'report',
                path: '/dashboard/generate/report/:object',
                props: true,
                component: StudentReport
            },
            {
                name: 'set_dates',
                path: '/dashboard/dates',
                component: SetDate
            },

        ],

    },
]