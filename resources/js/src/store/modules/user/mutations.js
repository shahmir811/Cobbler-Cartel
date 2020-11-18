export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const setUsers = (state, users) => (state.users = users);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const getUserToUpdate = (state, comingId) => {
    const id = parseInt(comingId);
    state.updateUser = state.users.find(user => user.id === id);
};

export const removeUserRecord = (state, id) => {
    state.users = state.users.filter(user => user.id !== id);
};

export const resetUserState = state => {
    state.users = [];
    state.loading = false;
    state.errors = [];
    state.updateUser = null;
};

export const changeUserStatus = (state, id) => {
    const user = state.users.find(user => user.id === id);
    if (user.status === "Active") {
        user.status = "Deactive";
    } else {
        user.status = "Active";
    }
};
