// import axios from 'axios';
import axios from "../../BaseUrl";
import router from "../../../routes/router";
import localForage from "localforage";
import { isEmpty } from "lodash";
import { setHttpToken } from "../../../helpers/index";

/////////////////////// Login user ///////////////////////
export const loginUser = async (
    { state, commit, rootState, dispatch },
    user
) => {
    commit("startLoading");
    commit("clearErrors");

    try {
        const response = await axios.post(`auth/login`, user);

        // set token to localStorage and axios header
        await dispatch("setToken", response.data.access_token);

        // send request to fetch user
        await dispatch("fetchUser");

        commit("endLoading");

        dispatch(
            "flashMessage",
            {
                message: "Login successfully",
                type: "success"
            },
            { root: true }
        );

        // Below code redirects user to intended page after login
        localForage.getItem("intended").then(name => {
            if (isEmpty(name)) {
                router.push("/home");
                return;
            }

            router.push({ name });
        });
    } catch (error) {
        console.log("ERROR: ", error);
        if (error.response.status === 422) {
            commit("setError", error.response.data.errors);
        }
        if (error.response.status === 401) {
            dispatch(
                "flashMessage",
                {
                    message: "Could not sign you in with those credentials",
                    type: "danger"
                },
                { root: true }
            );
        }
        commit("endLoading");
    }
};

/////////////////////// Logout user //////////////////
export const logout = async ({ dispatch, rootState }) => {
    try {
        await axios.post(`auth/logout`);

        dispatch("clearAuth");

        dispatch(
            "flashMessage",
            {
                message: "Logout successfully",
                type: "success"
            },
            { root: true }
        );
        router.push({ name: "login" });
    } catch (error) {
        console.log(error);
    }
};

/////////////////////// fetch currently logged in user //////////////////
export const fetchUser = ({ commit, dispatch, rootState }) => {
    return axios.get(`auth/me`).then(response => {
        commit("setIsAuthenticated", true);
        commit("setUserData", response.data.data.user);
        commit("setUserRoleInLocalStorage", response.data.data.user.role);
    });
};

/////////////////////// set token to localStorage ///////////////////////
export const setToken = ({ commit, dispatch }, token) => {
    // if no token is passed
    if (isEmpty(token)) {
        // When application first starts we need to check whether there is a token in localStorage or not
        return dispatch("checkTokenExists").then(token => {
            setHttpToken(token);
        });
    }

    commit("setToken", token); // payload is token
    // set http token in axios header
    setHttpToken(token);
};

/////////////////////// check token exists in localStorage or not ///////////////////////
export const checkTokenExists = ({ commit }) => {
    return localForage.getItem("authtoken").then(token => {
        if (isEmpty(token)) {
            return Promise.reject("NO_LOCALSTORAGE_TOKEN");
        }
        return Promise.resolve(token);
    });
};

/////////////////////// fetch currently logged in user //////////////////
export const clearAuth = ({ commit }) => {
    commit("setIsAuthenticated", false);
    commit("setUserData", null);
    commit("setToken", null);
    commit("setUserRoleInLocalStorage", null);
    setHttpToken(null);
};

/////////////////////// Attempt function execute at first //////////////////
export const attempt = async (
    { commit, state, dispatch, rootState },
    token
) => {
    if (token) {
        commit("setToken", token);
        setHttpToken(token);
    }

    try {
        const response = await axios.get(`auth/me`);
        commit("setIsAuthenticated", true);
        commit("setUserData", response.data.data.user);
        commit("setUserRoleInLocalStorage", response.data.data.user.role);
    } catch (error) {
        dispatch("clearAuth");
    }
};

/////////////////////// Remove errors //////////////////
export const removeAllErrors = ({ commit }) => {
    commit("clearErrors");
};

/////////////////////// Clear AuthState //////////////////
export const clearAuthState = ({ state, commit }) => {
    commit("resetAuthState");
};
