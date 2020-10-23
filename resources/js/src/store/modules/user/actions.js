import axios from "../../BaseUrl";
// import router from "../../../routes/router";

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
