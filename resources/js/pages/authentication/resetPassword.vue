<template>
    <div>

      <div class="page-wrapper">
        <div class="container-fluid p-0">
            <div class="row">
            <div class="col-12">
                <div class="login-card">
                  <div>
                    <div class="login-main login-form-card">
                        <div  >

                              <div class="NewPasswordForm"  >
                              <h4 >  ENTER YOUR NEW PASSWORD </h4>
                                  <p>  </p>
                            <form @submit.prevent="submitNewPasswordForm">
                                    <div class="form-group">

                                        <label class="col-form-label"> password </label>
                                        <input :class="['form-control', ( click3 &&  !$v.user.newPassword.password.required  || !$v.user.newPassword.password.maxLength || !$v.user.newPassword.password.minLength || error.password)  ? 'is-invalid' : '']"  name="code"  v-model="user.newPassword.password" >
                                        <b-form-invalid-feedback style="color:red" v-if="( click3 && !$v.user.newPassword.password.required )" > the  password  faild   is required</b-form-invalid-feedback>
                                        <b-form-invalid-feedback style="color:red" v-if="(   !$v.user.newPassword.password.maxLength )" > the  max length character is {{ $v.user.newPassword.password.$params.maxLength.max }}</b-form-invalid-feedback>
                                        <b-form-invalid-feedback style="color:red" v-if="(  !$v.user.newPassword.password.minLength )" > the min lenght character is {{ $v.user.newPassword.password.$params.minLength.min }} </b-form-invalid-feedback>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-form-label"> confirm password </label>
                                        <input :class="['form-control', (   !$v.user.newPassword.confirm_password.sameAsPassword  ||  error.confirm_password)  ? 'is-invalid' : '']"  name="code"  v-model="user.newPassword.confirm_password" >
                                        <b-form-invalid-feedback style="color:red" v-if="( click3 && !$v.user.newPassword.confirm_password.sameAsPassword )" > the    confirm   faild   must same as password failde</b-form-invalid-feedback>

                                    </div>

                                  <button type="submit"  class="btn btn-primary pull btn-sm" >Reset Password</button>

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
                newPassword:{
                    password:'',
                    confirm_password:''
                }
            },

            click3:false,
            error:''
        }
    },

    validations:{
        user:{
            newPassword:{
              password:{
                  required:required,
                  maxLength:maxLength(25),
                  minLength:minLength(6),
              },

              confirm_password:{
                  sameAsPassword:sameAs("password")
              }
            },
        }
    },

    methods: {
        submitNewPasswordForm(){

        }
    }
}
</script>
