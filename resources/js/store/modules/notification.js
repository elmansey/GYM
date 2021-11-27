const state = {
    unreadNotificationNumber: '',
    unSeenNotification: []
}

const getters = {
    unreadNotificationNumber(state) {
        return state.unreadNotificationNumber
    },

    unSeenNotification(state) {
        return state.unSeenNotification
    }


}

const mutations = {

    unreadNotificationNumber(state, payload) {
        state.unreadNotificationNumber = payload
    },

    unSeenNotification(state, payload) {

        state.unSeenNotification = payload
    }

}


const actions = {

    unreadNotificationNumber({ commit }, payload) {

        commit('unreadNotificationNumber', payload)
    },


    unSeenNotification({ commit }, payload) {
        commit('unSeenNotification', payload)
    }

}



export default {
    state,
    getters,
    mutations,
    actions
}
