import axios from "../../BaseUrl";

/////////////////////// Get Inventory Items List ///////////////////////
export const getInventoryItemsList = async ({
    state,
    commit,
    rootState,
    dispatch
}) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("setLoading", true);
    try {
        const response = await axios.get(`/${role}/inventory-list`);
        commit("setInventoryList", response.data.data.inventory);
        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setLoading", false);
    }
};

/////////////////////// Add Inventory Item ///////////////////////
export const addInventory = ({ state, commit, rootState, dispatch }, data) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("clearErrors");

    return new Promise((resolve, reject) => {
        axios
            .post(`/${role}/add-inventory`, data)
            .then(response => {
                commit("addToInventoryList", response.data.data.inventory);
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

/////////////////////// Update Inventory Item ///////////////////////
export const updateInventoryItem = (
    { state, commit, rootState, dispatch },
    data
) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;
    commit("clearErrors");

    return new Promise((resolve, reject) => {
        axios
            .post(`/${role}/update-inventory/${data.id}`, data)
            .then(response => {
                commit(
                    "updateSelectedInventoryItem",
                    response.data.data.inventory
                );
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setError", error.response.data.errors);
                reject(error.response.data.errors);
            });
    });
};

/////////////////////// Delete Inventory Item ///////////////////////
export const deleteInventoryItem = async (
    { state, commit, rootState, dispatch },
    id
) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    return new Promise((resolve, reject) => {
        axios
            .delete(`/${role}/delete-inventory/${id}`)
            .then(() => {
                commit("removeInventoryItem", id);
                resolve();
            })
            .catch(error => {
                console.log(error);
                reject(error.response.data.errors);
            });
    });
};

/////////////////////// select inventory item to update ///////////////////////
export const selectInventoryItemToUpdate = ({ state, commit }, id) => {
    commit("selectInventoryItem", id);
};

/////////////////////// clear item selection ///////////////////////
export const clearInventoryItemSelection = ({ state, commit }) => {
    commit("clearSelectedInventroyItems");
};

/////////////////////// clear errors ///////////////////////
export const clearErrors = ({ state, commit }) => {
    commit("clearErrors");
};
