import axios from "../../BaseUrl";

/////////////////////// Get Purchases List ///////////////////////
export const getAllPurchases = async ({
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
        const response = await axios.get(`/${role}/purchases`);
        commit("setPurchasesList", response.data.data.purchases);
        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setLoading", false);
    }
};

/////////////////////// Add new purchase item ///////////////////////
export const addNewPurchase = (
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
            .post(`/${role}/add-new-purchase`, data)
            .then(response => {
                commit("addToPurchaseList", response.data.data.purchase);
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setError", error.response.data.errors);
                reject();
            });
    });
};

/////////////////////// Delete Purchase Item ///////////////////////
export const deletePurchaseItem = (
    { state, commit, rootState, dispatch },
    id
) => {
    if (!rootState.auth.user) {
        return;
    }

    const { role } = rootState.auth.user;

    return new Promise((resolve, reject) => {
        axios
            .delete(`/${role}/delete-purchase/${id}`)
            .then(() => {
                commit("removeFromPurchasesList", id);
                resolve();
            })
            .catch(error => {
                console.log(error);
                reject();
            });
    });
};

/////////////////////// Update selectedPurchaseItem details ///////////////////////
export const updateSelectedPurchaseItemMethod = (
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
            .post(`/${role}/update-purchase/${data.id}`, data)
            .then(response => {
                commit("updatePurchasesList", response.data.data.purchase);
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setError", error.response.data.errors);
                reject();
            });
    });
};

/////////////////////// Select Purchase Item for updating ///////////////////////
export const selectPurchaseItemToUpdate = ({ state, commit }, id) => {
    commit("selectPurchaseItemToUpdate", id);
};

/////////////////////// Clear/remove errors ///////////////////////
export const clearErrors = ({ state, commit }) => {
    commit("clearErrors");
};

/////////////////////// Clear Selection ///////////////////////
export const clearselectedPurchase = ({ state, commit }) => {
    commit("clearselectedPurchase");
};
