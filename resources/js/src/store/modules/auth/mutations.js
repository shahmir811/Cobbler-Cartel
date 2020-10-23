import localForage from "localforage";
import { isEmpty } from "lodash";

export const startLoading = state => (state.loading = true);

export const endLoading = state => (state.loading = false);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const errors = state => state.errors;

export const setIsAuthenticated = (state, trueOrFalse) =>
    (state.isAuthenticated = trueOrFalse);

export const setUserData = (state, data) => (state.user = data);

export const setUserRoleInLocalStorage = (state, role) => {
    if (isEmpty(role)) {
        localForage.removeItem("userRole");
        return;
    }
    localForage.setItem("userRole", role);
};

export const setToken = (state, token) => {
    // check empty and remove token
    if (isEmpty(token)) {
        localForage.removeItem("authtoken");
        return;
    }
    localForage.setItem("authtoken", token);
};
