const  state = {
    editAdmin : false,
    AdminInfoToEdit:''

}

const  getters = {

    editAdmin(state){
        return state.editAdmin
    },

    AdminInfoToEdit(state){
        return state.AdminInfoToEdit
    },


}


const  mutations = {

    editAdmin(state,payload){
         state.editAdmin = payload
    },

    AdminInfoToEdit(state,payload){
        state.AdminInfoToEdit = payload
    },


}

const  actions = {

    AdminInfoToEdit({commit},payload){
        commit('AdminInfoToEdit',payload)
        commit('editAdmin',true)
    },

}

export default {
    state,
    getters,
    mutations,
    actions
}
