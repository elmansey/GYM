import axios from 'axios'
import router from '@/router/index'
//to save
const  state = {
    isAuth : false,
    user:null,
    errors:'',
    token:localStorage.getItem('token')
}

// to show item saved in state
const getters = {

    authentication(state){
        return state.isAuth
    },

    AllError(state){
        return state.errors
    },

    USER(state){
        return state.user
    },

    AUTH_TOKEN(state){
        return state.token
    },


}



// to chang value in state and do every thing
const  mutations = {

    setAuthentecation(state,status){
        state.isAuth = status
    },


    loginSuccess(state,token){

        localStorage.setItem('token',token)
        state.token = token
        state.isAuth = true
        state.errors = ''
        router.push({
            name:'dashboard'
        })
    },


    setToken(state,token){
        state.token = token
        state.isAuth = true
        localStorage.setItem('token',token)

    },


    SET_USER(state,user){
        state.user = user
    },


    loginFailed(state,error){
        state.token = ''
        state.isAuth = false
        state.errors = error
    },


    logOut(state){
        localStorage.removeItem('token')
        state.isAuth = false
        state.user = ''
        state.token = ''
        router.push({
            name:'login'
        })
    },


    USER_INFO_SUCCESS(state,data){
        state.isAuth = true
        state.user = data
        state.errors = ''
    },


    USER_INFO_FAILD(state) {
        localStorage.removeItem("token");
        state.isAuth = false;
        state.token = null;
        state.user = null;
    },


}



// do conection with api and call mutations
const actions = {

   loginUser({commit},payload){

       axios.post('login',{
           email:payload.email,
           password:payload.password
       }).then(res => {

           if(res.data.status == 400){

               commit('loginFailed',res.data.message)

           }else if (res.data.status == 401){

               Toast.fire({
                   icon: 'error',
                   title: '!! Wrong In Email Or Password'
               })

           }else{
               commit('loginSuccess',res.data.data.access_token)
               commit('SET_USER',res.data.data.user)
           }


       }).catch(err => {

           console.log(err.message)
       })


   },

    async  userLogout({commit}){
        await  axios.post('logout')
           .then(res =>{

                   commit('logOut')

           }).catch(err => {

               console.log(err.message)

       })
   },

    async userInfo({commit}) {

       try{
         const res =   await  axios.get('info')


           commit('USER_INFO_SUCCESS', res.data.data)

       }catch(err ){

            commit('USER_INFO_FAILD')
        }




    }

}




export default {
    state,
    getters,
    mutations,
    actions
}
