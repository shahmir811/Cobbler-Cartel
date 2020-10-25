export const setMessage = (state, { message, type }) => {
    state.message = message;
    state.type = type;
};

export const clearMessage = state => {
    state.message = null;
    state.type = null;
};

export const setLoading = (state, trueOrFalse) => (state.loading = trueOrFalse);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);
