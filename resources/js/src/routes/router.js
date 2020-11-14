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
import CompletedOrders from "../pages/Auth/Orders/CompletedOrders.vue";
import ChangeOrderStatus from "../pages/Auth/Orders/ChangeOrderStatus.vue";
import ImportExcelFile from "../pages/Auth/ImportExcelFile/ImportExcelFile.vue";
import ItemsManagementPage from "../pages/Auth/Items/Items.vue";
import InventoryManagementPage from "../pages/Auth/Inventory/Inventory.vue";
import PurchaseManagementPage from "../pages/Auth/Purchases/Purchases.vue";
import NotFound from "../pages/Error/NotFound.vue";
import ForgotPasswordPage from "../pages/Register/ForgotPassword.vue";
import PasswordResetPage from "../pages/Register/PasswordReset.vue";
import ScanBarCodePage from "../pages/Auth/ScanBarCode/ScanBarCode.vue";

// Employee Pages
import MyProfilePage from "../pages/Auth/Profile/Profile.vue";
import UpdatePasswordPage from "../pages/Auth/Profile/UpdatePassword.vue";

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
            path: "/forgot-password",
            component: ForgotPasswordPage,
            name: "forgot-password",
            meta: { guest: false, needsAuth: false }
        },
        {
            path: "/password-reset",
            component: PasswordResetPage,
            name: "password-reset",
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
        },
        {
            path: "/change-order-status/:id",
            component: ChangeOrderStatus,
            name: "change-order-status",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/completed-orders",
            component: CompletedOrders,
            name: "completed-orders",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/items",
            component: ItemsManagementPage,
            name: "items",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/inventory",
            component: InventoryManagementPage,
            name: "inventory",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/purchases",
            component: PurchaseManagementPage,
            name: "purchases",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/my-profile",
            component: MyProfilePage,
            name: "my-profile",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/update-password",
            component: UpdatePasswordPage,
            name: "update-password",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "/scanbarcode",
            component: ScanBarCodePage,
            name: "scanbarcode",
            meta: { guest: false, needsAuth: true }
        },
        {
            path: "*",
            component: NotFound
        }
    ]
});

// Registering beforeEach
router.beforeEach(beforeEach);

export default router;
