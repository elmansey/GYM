const  state = {
    edit : false,
    roleDataToEdit:{},
    deleteId:null
}

const  getters = {

    EDIT(state){
        return state.edit
    },
    ROLEDATATOEDIT(state){
        return state.roleDataToEdit
    },
    DELETEID(state){
        return state.deleteId
    }
}


const  mutations = {

    EDIT(state,payload){
         state.edit = payload
    },

    ROLEDATATOEDIT(state,payload){
        state.roleDataToEdit = payload
    },
    DELETEID(state,payload){
        state.deleteId = payload
    }
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
    DELETEID({commit},payload){
        commit('DELETEID',payload)
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
