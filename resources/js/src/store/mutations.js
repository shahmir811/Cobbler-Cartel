export const setMessage = (state, { message, type }) => {
    state.message = message;
    state.type = type;
};

export const clearMessage = state => {
    state.message = null;
    state.type = null;
};
