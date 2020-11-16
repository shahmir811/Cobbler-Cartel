import axios from "../../BaseUrl";

/////////////////////// Get expenses List ///////////////////////
export const getAllExpenses = async ({ state, commit }) => {
    commit("setLoading", true);
    try {
        const response = await axios.get(`/admin/daily-expense`);

        commit("setExpenseList", response.data.data.expenses);

        commit("setLoading", false);
    } catch (error) {
        console.log(error);
        commit("setError", error.response.data.errors);
        commit("setLoading", false);
    }
};

/////////////////////// Add Expense ///////////////////////
export const addExpense = async (
    { state, commit, rootState, dispatch },
    data
) => {
    return new Promise((resolve, reject) => {
        axios
            .post(`/admin/add-expense`, data)
            .then(response => {
                commit("addToExpenseList", response.data.data.expense);

                dispatch(
                    "flashMessage",
                    {
                        message: "New expense added",
                        type: "success"
                    },
                    { root: true }
                );
                resolve();
            })
            .catch(error => {
                console.log(error);
                commit("setError", error.response.data.errors);
                reject();
            });
    });
};

/////////////////////// Remove Expense ///////////////////////
export const removeExpense = async (
    { state, commit, rootState, dispatch },
    id
) => {
    try {
        const response = await axios.delete(`/admin/delete-expense/${id}`);

        commit("removeFromExpenseList", id);
    } catch (error) {
        console.log(error);
        commit("setError", error.response.data.errors);
    }
};

/////////////////////// Clear errors ///////////////////////
export const clearErrors = ({ state, commit }) => {
    commit("clearErrors");
};
