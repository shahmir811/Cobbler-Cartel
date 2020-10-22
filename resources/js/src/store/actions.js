export const flashMessage = ({ commit }, alert) => {
    commit("setMessage", alert);

    setTimeout(() => {
        commit("clearMessage");
    }, 3000);
};
