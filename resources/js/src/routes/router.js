import Vue from "vue";
import Router from "vue-router";
import beforeEach from "./beforeEach";

Vue.use(Router);

import Landing from "../pages/Landing/Landing.vue";
import Login from "../pages/Login/Login.vue";
import Register from "../pages/Register/Register.vue";

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
            path: "/register",
            component: Register,
            name: "register",
            meta: { guest: true, needsAuth: false }
        }
    ]
});

// Registering beforeEach
router.beforeEach(beforeEach);

export default router;
