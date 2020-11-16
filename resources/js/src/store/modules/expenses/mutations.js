export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const setExpenseList = (state, payload) => (state.expenseList = payload);

export const removeFromExpenseList = (state, id) => {
    state.expenseList = state.expenseList.filter(exp => exp.id !== id);
};

export const addToExpenseList = (state, payload) => {
    // Adding new record at the start of array
    state.expenseList.unshift(payload);
};
