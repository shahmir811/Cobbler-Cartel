import Vue from "vue";
import App from "./App.vue";
import localForage from "localforage";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

import "./bootstrap.js";
import "./styles/styles.scss";

import store from "./store";
import router from "./routes/router";

localForage.config({
    driver: localForage.LOCALSTORAGE,
    storeName: "Cobbler_Cartel"
});

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

// Following code is used for persistent login
localForage.getItem("authtoken", (err, token) => {
    store.dispatch("auth/attempt", token).then(() => {
        new Vue({
            el: "#app",
            router,
            store,
            render: h => h(App)
        });
    });
});
