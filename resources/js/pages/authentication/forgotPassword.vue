<template>
	<div>
		<div class="page-wrapper">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">
            <div class="login-card">
              <div>
                <div>
					<!-- <a class="logo">
                        <img
                        class="img-fluid for-light"
                        src=""
                        alt="looginpage"
                        />
                        <img
                        class="img-fluid for-dark"
                        src=""
                        alt="looginpage"
                        />
                  </a> -->
				</div>
                <div class="login-main login-form-card">
                      <div class="enterEmail" >
                              <h4 >  FORGET PASSWORD </h4>
                            <p>  enter your email and we will send you instructions  on how to reset password  </p>
                            <form @submit.prevent="submitEmailResetForm">
                                <div class="form-group">
                                    <label class="col-form-label">email</label>
                                    <input :class="['form-control', ( click1 &&  !$v.user.data.email.required || !$v.user.data.email.email  || error.email)  ? 'is-invalid' : '']" type="email" name="email"  v-model="user.data.email" >
                                    <b-form-invalid-feedback style="color:red" v-if="( click1 && !$v.user.data.email.required )" > the  email  faild   is required</b-form-invalid-feedback>
                                    <b-form-invalid-feedback style="color:red" v-if="(  click1 &&!$v.user.data.email.email )" > the  email  must be valid email </b-form-invalid-feedback>
                                    <b-form-invalid-feedback style="color:red" v-if="error.email" > {{ error.email[0] }}  </b-form-invalid-feedback>
                                </div>
                                  <button  class="btn btn-primary pull btn-sm" >reset password</button>

                            </form>

                      </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</template>
<script>
import {
     required,
     email,
      minLength,
      maxLength,
     sameAs
     } from 'vuelidate/lib/validators'

     import axios from 'axios'
import { mapActions } from 'vuex'

export default {

    data(){
      return{
        user:{

            data:{ email:''},

         },

        error:'',

        click1:false,



      }
    },

    validations:{
        user:{
            data:{
                email:{
                    required,
                    email,
                }
            },
        }
    },



    methods:{

        ...mapActions({
            'emailToReset':'emailToReset'
        }),


        submitEmailResetForm(){

            this.$v.user.$touch()

            if(!this.$v.user.data.$invalid){

                    //axios here
                    axios.post('forgetPassword',this.user.data)
                    .then(res => {

                        if(res.data.success){

                            this.click1 = true
                              Toast.fire({
                                icon: "success",
                                title: "check your email  send  details successfully"
                            });

                            this.user.data.email = ''
                            this.click1 = false



                        }
                        if(res.data.success == false){
                            this.error = res.data.message
                        }
                    })
                    .catch(err  =>  {

                    })



            }else{

                this.click1 = true

            }

        },

    }

}
</script>
