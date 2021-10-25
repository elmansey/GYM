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
                      <div class="enterEmail"  v-if="emailForm">
                              <h4 >  FORGET PASSWORD </h4>
                            <p>  enter your email and we will send you instructions  on how to reset password  </p>
                            <form @submit.prevent="submitEmailResetForm">
                                <div class="form-group">
                                    <label class="col-form-label">email</label>
                                    <input :class="['form-control', ( click1 &&  !$v.user.data.email.required || !$v.user.data.email.email ||  error.email)  ? 'is-invalid' : '']" type="email" name="email"  v-model="user.data.email" >
                                    <b-form-invalid-feedback style="color:red" v-if="( click1 && !$v.user.data.email.required )" > the  email  faild   is required</b-form-invalid-feedback>
                                    <b-form-invalid-feedback style="color:red" v-if="(  click1 &&!$v.user.data.email.email )" > the  email  must be valid email </b-form-invalid-feedback>
                                </div>
                                  <button  class="btn btn-primary pull btn-sm" >send code to verify</button>

                            </form>

                      </div>

                     <div class="enterYourVerifyCode" v-if="codeForm">
                              <h4 >  ENTER YOUR VERIFY CODE </h4>
                                  <p>  </p>
                            <form @submit.prevent="submitcodeVerifyForm">
                                <div class="form-group">

                                    <label class="col-form-label">verify code </label>
                                    <input :class="['form-control', ( click2 &&  !$v.user.code.verifyCode.required  ||  error.code)  ? 'is-invalid' : '']"  name="code"  v-model="user.code.verifyCode" >
                                    <b-form-invalid-feedback style="color:red" v-if="( click2 && !$v.user.code.verifyCode.required )" > the  verify code   faild   is required</b-form-invalid-feedback>

                                </div>

                                <button type="submit" class="btn btn-primary pull btn-sm" >verify</button>

                            </form>


                      </div>

                    <div class="NewPasswordForm" v-if="NewPasswordForm" >
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
</template>
<script>
import {
     required,
     email,
      minLength,
      maxLength,
     sameAs
     } from 'vuelidate/lib/validators'
export default {

    data(){
      return{
        user:{

            data:{ email:''},

            code:{  verifyCode:'' },

            newPassword:{ password:'',  confirm_password:'',}


         },

        error:'',


        emailForm:true,
        codeForm:false,
        NewPasswordForm:false,


        enterYourEmailSubmit:false,
        enterYourVerifyCodeSubmit:false,
        NewPasswordSubmit:false,

        click1:false,
        click2:false,
        click3:false,


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

            code:{
                verifyCode:{
                    required,
                }
            },

            newPassword:{

                password:{
                    required,
                    maxLength:maxLength(30),
                    minLength:minLength(6),
                },

                confirm_password:{
                   sameAsPassword:sameAs("password"),
                },
            }
        }
    },



    methods:{
        submitEmailResetForm(){

            this.$v.user.$touch()

            if(!this.$v.user.data.$invalid){

                    //axios here
                this.click1 = true
                this.emailForm = false
                 this.codeForm = true


            }else{

                this.click1 = true

            }

        },
        submitcodeVerifyForm(){

            this.$v.user.$touch()
            if(!this.$v.user.code.$invalid){

                    //axios here
                this.click2 = true
                 this.codeForm = false
                this.NewPasswordForm = true



            }else{

                this.click2 = true
               this.codeForm = true

            }

        },
        submitNewPasswordForm(){

                 this.$v.user.$touch()
            if(!this.$v.user.newPassword.$invalid){

                    //axios here
                this.click3 = true

            }else{

                this.click3 = true


            }

        }
    }

}
</script>
