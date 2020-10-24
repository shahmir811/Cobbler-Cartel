import Vue from "vue";
import Router from "vue-router";
import beforeEach from "./beforeEach";

Vue.use(Router);

import Landing from "../pages/Landing/Landing.vue";
import Login from "../pages/Login/Login.vue";
// Admin Pages
import AdminHome from "../pages/Admin/Home/Home.vue";
import AdminUsers from "../pages/Admin/Users/Users.vue";
import AdminAddUer from "../pages/Admin/Users/AddUser.vue";
import AdminUpdateUser from "../pages/Admin/Users/UpdateUser.vue";
// import Register from "../pages/Register/Register.vue";

// Employee Pages
import EmployeeHome from "../pages/Employee/Home/Home.vue";
import EmployeeImportFile from "../pages/Employee/ImportFile/ImportFile.vue";

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
        // Admin Routes
        {
            path: "/admin/home",
            component: AdminHome,
            name: "admin-home",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/admin/users",
            component: AdminUsers,
            name: "admin-users",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/admin/add-user",
            component: AdminAddUer,
            name: "admin-add-user",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/admin/update-user/:id",
            component: AdminUpdateUser,
            name: "admin-update-user",
            meta: { guest: false, needsAuth: true }
        },
        // Employee Routes
        {
            path: "/employee/home",
            component: EmployeeHome,
            name: "employee-home",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/employee/import-file",
            component: EmployeeImportFile,
            name: "employee-import-file",
            meta: { guest: false, needsAuth: true }
        }
    ]
});

// Registering beforeEach
router.beforeEach(beforeEach);

export default router;
