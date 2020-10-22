import localForage from "localforage";

export const startLoading = state => (state.loading = true);

export const endLoading = state => (state.loading = false);

export const clearErrors = state => (state.errors = []);

export const setError = (state, payload) => (state.errors = payload);

export const errors = state => state.errors;

/////////////////////// check token exists in localStorage or not ///////////////////////
export const checkTokenExists = ({ commit }) => {
    return localForage.getItem("authtoken").then(token => {
        if (isEmpty(token)) {
            return Promise.reject("NO_LOCALSTORAGE_TOKEN");
        }
        return Promise.resolve(token);
    });
};
