const state = {
    settings: []
};

const getters = {
    SETTINGS(state) {
        return state.settings;
    }
};

const mutations = {
    SETTINGS(state, payload) {
        state.settings = payload;
    }
};

const actions = {
    SETTINGS({ commit }, payload) {
        commit("SETTINGS", payload);
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
