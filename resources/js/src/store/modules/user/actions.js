import axios from "../../BaseUrl";
import router from "../../../routes/router";

/////////////////////// Fetch All Users ///////////////////////
export const fetchUsers = async ({ state, commit, rootState, dispatch }) => {
    commit("setLoading", true);

    try {
        const response = await axios.get("/admin/users");

        commit("setUsers", response.data.data);

        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setLoading", false);
    }
};

/////////////////////// Add User ///////////////////////
export const addNewUser = async (
    { state, commit, rootState, dispatch },
    data
) => {
    commit("setLoading", true);
    commit("clearErrors");

    try {
        const response = await axios.post("/admin/add-user", data);

        dispatch(
            "flashMessage",
            {
                message: "New user added successfully",
                type: "success"
            },
            { root: true }
        );

        commit("setLoading", false);

        router.push("/users");
    } catch (error) {
        console.log(error);
        commit("setError", error.response.data.errors);
        commit("setLoading", false);
    }
};

/////////////////////// Add User ///////////////////////
export const selectUserToUpdate = (
    { state, commit, rootState, dispatch },
    id
) => {
    commit("getUserToUpdate", id);
};

/////////////////////// Update User ///////////////////////
export const UpdateUserDetails = async (
    { state, commit, rootState, dispatch },
    data
) => {
    commit("setLoading", true);
    commit("clearErrors");

    try {
        await axios.post(`/admin/update-user/${data.id}`, data);

        dispatch(
            "flashMessage",
            {
                message: "User details updated successfully",
                type: "success"
            },
            { root: true }
        );

        commit("setLoading", false);

        router.push("/users");
    } catch (error) {
        console.log(error);
        commit("setError", error.response.data.errors);
        commit("setLoading", false);
    }
};

/////////////////////// Update User ///////////////////////
export const UpdateUserPassword = async (
    { state, commit, rootState, dispatch },
    data
) => {
    commit("setLoading", true);
    commit("clearErrors");

    try {
        await axios.post(`/admin/update-password/${data.id}`, data);

        dispatch(
            "flashMessage",
            {
                message: "Password updated successfully",
                type: "success"
            },
            { root: true }
        );

        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setError", error.response.data.errors);
        commit("setLoading", false);
    }
};

/////////////////////// Delete User ///////////////////////

export const deleteUser = ({ commit, dispatch, rootState }, userId) => {
    return axios
        .delete(`admin/delete-user/${userId}`)
        .then(() => {
            commit("removeUserRecord", userId);
        })
        .catch(error => console.log(error));
};

/////////////////////// Clear all users state ///////////////////////
export const clearUserState = ({ state, commit }) => {
    commit("resetUserState");
};
