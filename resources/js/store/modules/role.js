const  state = {
    edit : false,
    roleDataToEdit:{},
}

const  getters = {

    EDIT(state){
        return state.edit
    },
    ROLEDATATOEDIT(state){
        return state.roleDataToEdit
    },

}


const  mutations = {

    EDIT(state,payload){
         state.edit = payload
    },

    ROLEDATATOEDIT(state,payload){
        state.roleDataToEdit = payload
    },

}

const  actions = {
    EDIT({commit}){
        commit('EDIT',true)
    },
    ADD({commit}){
        commit('EDIT',false)
    },
    ROLEDATATOEDIT({commit},payload){
        commit('ROLEDATATOEDIT',payload)
    },

}

export default {
    state,
    getters,
    mutations,
    actions
}
