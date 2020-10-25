export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const setUsers = (state, users) => (state.users = users);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const getUserToUpdate = (state, id) => {
    state.updateUser = state.users.find(user => user.id === id);
};

export const removeUserRecord = (state, id) => {
    state.users = state.users.filter(user => user.id !== id);
};
