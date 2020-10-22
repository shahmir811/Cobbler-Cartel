// import axios from 'axios';
import axios from "../../BaseUrl";
import router from "../../../routes/router";
import localForage from "localforage";
import { isEmpty } from "lodash";

/////////////////////// check token exists in localStorage or not ///////////////////////
export const checkTokenExists = ({ commit }) => {
    return localForage.getItem("authtoken").then(token => {
        if (isEmpty(token)) {
            return Promise.reject("NO_LOCALSTORAGE_TOKEN");
        }
        return Promise.resolve(token);
    });
};

/////////////////////// Login user ///////////////////////
export const loginUser = async (
    { state, commit, rootState, dispatch },
    user
) => {
    commit("startLoading");
    commit("clearErrors");

    try {
        const response = await axios.post(`auth/login`, user);
        console.log("RESPONSE: ", response);
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
                // router.push("/home");
                return;
            }

            // router.push({ name });
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
