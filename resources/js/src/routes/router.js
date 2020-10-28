import Vue from "vue";
import Router from "vue-router";
import beforeEach from "./beforeEach";

Vue.use(Router);

import Landing from "../pages/Landing/Landing.vue";
import Login from "../pages/Login/Login.vue";
import Home from "../pages/Auth/Home/Home.vue";
import Users from "../pages/Auth/Users/Users.vue";
import AddUer from "../pages/Auth/Users/AddUser.vue";
import UpdateUser from "../pages/Auth/Users/UpdateUser.vue";
import Orders from "../pages/Auth/Orders/Orders.vue";
import ImportExcelFile from "../pages/Auth/ImportExcelFile/ImportExcelFile.vue";
// import Register from "../pages/Register/Register.vue";

// Employee Pages
// import EmployeeHome from "../pages/Employee/Home/Home.vue";
// import EmployeeImportFile from "../pages/Employee/ImportFile/ImportFile.vue";

const router = new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            component: Landing,
            name: "landing",
            meta: { guest: true, needsAuth: false }
        },
        {
            path: "/login",
            component: Login,
            name: "login",
            meta: { guest: true, needsAuth: false }
        },
        {
            path: "/home",
            component: Home,
            name: "home",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/users",
            component: Users,
            name: "users",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/add-user",
            component: AddUer,
            name: "add-user",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/update-user/:id",
            component: UpdateUser,
            name: "update-user",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/orders",
            component: Orders,
            name: "orders",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/import-file",
            component: ImportExcelFile,
            name: "import-file",
            meta: { guest: false, needsAuth: true }
        }
    ]
});

// Registering beforeEach
router.beforeEach(beforeEach);

export default router;
