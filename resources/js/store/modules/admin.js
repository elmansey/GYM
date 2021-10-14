const  state = {
    editAdmin : false,
    AdminInfoToEdit: '',


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

    addAdmin(state,payload){
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

    addAdmin({commit}){
        commit('AdminInfoToEdit','')
        commit('addAdmin',false)
    },



}

export default {
    state,
    getters,
    mutations,
    actions
}
