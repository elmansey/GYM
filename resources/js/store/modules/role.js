const state = {
    edit: false,
    roleDataToEdit: {},
    roleDataToShow: ''
}

const getters = {

    EDIT(state) {
        return state.edit
    },
    ROLEDATATOEDIT(state) {
        return state.roleDataToEdit
    },
    roleDataToShow(state) {
        return state.roleDataToShow
    }

}


const mutations = {

    EDIT(state, payload) {
        state.edit = payload
    },

    ROLEDATATOEDIT(state, payload) {
        state.roleDataToEdit = payload
    },
    roleDataToShow(state, payload) {
        state.roleDataToShow = payload
    }

}

const actions = {
    EDIT({
        commit
    }) {
        commit('EDIT', true)
    },
    ADD({
        commit
    }) {
        commit('EDIT', false)
    },
    ROLEDATATOEDIT({
        commit
    }, payload) {
        commit('ROLEDATATOEDIT', payload)
    },
    roleDataToShow({
        commit
    }, payload) {
        commit('roleDataToShow', payload)
    }

}

export default {
    state,
    getters,
    mutations,
    actions
}