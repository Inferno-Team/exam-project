import Login from "./views/Login";
import Home from "./views/Home";
import HomeLayout from "./views/HomeLayout";
import Dashboard from "./views/Dashboard";
import ShowAllStudent from './views/student/ShowAllStudent';
import Mark from './views/add_marks/Mark';
import FileMark2 from './views/add_marks/FileMark2';
import Mark1 from './views/add_marks/Mark1';
import Mark2 from './views/add_marks/Mark2';
import AddCourse from './views/courses/AddCourse';
import GenerateReport from './views/reports/GenerateReport';
import SetDate from './views/dates/SetDates';
import MarksReport from './views/reports/templates/MarksReport';
import StudentReport from './views/reports/templates/StudentReport';
import GenerateDoctorAssignment from './views/reports/templates/GenerateDoctorAssignment';
import GenerateSupervisorAssignment from './views/reports/templates/GenerateSupervisorAssignment';
import GenerateTopTen from './views/reports/templates/GenerateTopTen';
import ChartLayout from './views/charts/ChartLayout';
export const routes = [{
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/',
        name: 'home',
        component: HomeLayout
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        children: [{
                path: '',
                name: 'home',
                component: Home
            },
            // dashboard - student
            {
                name: 'show-all-student',
                path: '/dashboard/show-all.student',
                component: ShowAllStudent
            },
            {
                name: 'add-mark',
                path: '/dashboard/file.add.marks1',
                component: Mark
            }, {
                name: 'add-mark-2',
                path: '/dashboard/file.add.marks2',
                component: FileMark2
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
            {
                name: 'generate-doctor-assignment',
                path: '/dashboard/generate/doctor-assignment/:object',
                props: true,
                component: GenerateDoctorAssignment
            },
            {
                name: 'generate-supervisor-assignment',
                path: '/dashboard/generate/supervisor-assignment/:object',
                props: true,
                component: GenerateSupervisorAssignment
            }, {
                name: 'generate-top-ten',
                path: '/dashboard/generate/top-ten/:id',
                props: true,
                component: GenerateTopTen
            },
            {
                name: "charts",
                path: "/dashboard/charts",
                component: ChartLayout
            }

        ],

    },
]