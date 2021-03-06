import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import state from "./state";
import * as getters from "./getters";
import * as mutations from "./mutations";
import * as actions from "./actions";

import auth from "./modules/auth";
import user from "./modules/user";
import orders from "./modules/orders";
import items from "./modules/items";
import inventory from "./modules/inventory";
import purchases from "./modules/purchases";
import expenses from "./modules/expenses";

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules: {
        auth,
        user,
        orders,
        items,
        inventory,
        purchases,
        expenses
    }
});
