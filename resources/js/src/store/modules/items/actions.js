import axios from "../../BaseUrl";

/////////////////////// Get Items List ///////////////////////
export const getItemsList = async ({ state, commit, rootState, dispatch }) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("setLoading", true);

    try {
        const response = await axios.get(`/${role}/items`);

        commit("setItems", response.data.data.items);
        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setLoading", false);
    }
};

/////////////////////// Add Item ///////////////////////
export const addNewItem = ({ state, commit, rootState, dispatch }, data) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("clearErrors");

    return new Promise((resolve, reject) => {
        axios
            .post(`/${role}/add-item`, data)
            .then(response => {
                commit("addItem", response.data.data.item);
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setError", error.response.data.errors);
                commit("setLoading", false);
                reject();
            });
    });
};

/////////////////////// Update Item ///////////////////////
export const updateItem = ({ state, commit, rootState, dispatch }, data) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("clearErrors");

    return new Promise((resolve, reject) => {
        axios
            .post(`/${role}/update-item/${data.id}`, data)
            .then(response => {
                commit("updateItem", response.data.data.item);
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setError", error.response.data.errors);
                reject(error.response.data.errors);
            });
    });
};

/////////////////////// Update Item ///////////////////////
export const deleteItem = ({ state, commit, rootState, dispatch }, id) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    return new Promise((resolve, reject) => {
        axios
            .delete(`/${role}/delete-item/${id}`)
            .then(() => {
                commit("removeItemFromList", id);
                resolve();
            })
            .catch(error => {
                console.log(error);
                reject(error.response.data.errors);
            });
    });
};

/////////////////////// select Item to update ///////////////////////
export const selectItemToUpdate = ({ state, commit }, id) => {
    commit("getSelectedItems", id);
};

/////////////////////// clear item selection ///////////////////////
export const clearItemSelection = ({ state, commit }) => {
    commit("clearSelectedItems");
};

/////////////////////// clear errors ///////////////////////
export const clearErrors = ({ state, commit }) => {
    commit("clearErrors");
};
