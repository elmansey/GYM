<template>
	<div>
		<div class="container-fluid p-0">
      <div class="row" >
        <div class="col-xl-12 p-0">
          <div class="login-card">
            <div>
              <!-- <div>
				  <a class="logo">
                  <img
                    class="img-fluid for-light"
                    src="@/assets/images/logo/login.png"
                    alt="looginpage"
                  />
                  <img
                    class="img-fluid for-dark"
                    src="@/assets/images/logo/logo_dark.png"
                    alt="looginpage"
                  />
                </a>
			 </div> -->



                    <div class="login-main login-form-card">


                            <form-wizard  ref="wizard" @on-complete="sendDataToApiBeforeSubmit" color="#4466f2"  :start-index="0" title="Create your account" subtitle="Enter your personal details to create account" back-button-text="back!" next-button-text="next!" finish-button-text="register">
                                <tab-content :before-change="personalDataValidation" title="Personal details" >
                                    <div class="setup-contentn" id="step-1">
                                        <div class="col-xs-12 personal details">

                                            <div class="form-group">
                                                <label class="col-form-label pt-0">Your Name</label>
                                                <div class="form-row">
                                                    <div class="col-12 m">
                                                        <input :class="['form-control', (step1  &&  !$v.memberData.personalData.first_name.required || step1 && !$v.memberData.personalData.first_name.maxLength || !$v.memberData.personalData.first_name.minLength || error.first_name) ? 'is-invalid' : '']" type="text" required="" placeholder="First name" v-model="memberData.personalData.first_name">
                                                        <b-form-invalid-feedback style="color:red" v-if="(step1 && !$v.memberData.personalData.first_name.required)" > the first name faild is required</b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.first_name.maxLength )" > the max Length character in first name  is {{ $v.memberData.personalData.first_name.$params.maxLength.max }} </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.first_name.minLength )" > the min Length character in first name  is  {{ $v.memberData.personalData.first_name.$params.minLength.min }} </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="error.first_name" >   {{ error.first_name[0] }} </b-form-invalid-feedback>
                                                    </div>
                                                    <div class="col-12  mt-4">

                                                        <input :class="['form-control', (step1  &&  !$v.memberData.personalData.middle_name.required || step1 && !$v.memberData.personalData.middle_name.maxLength || !$v.memberData.personalData.middle_name.minLength || error.middle_name) ? 'is-invalid' : '']" type="text" required="" placeholder="middle name" v-model="memberData.personalData.middle_name">
                                                        <b-form-invalid-feedback style="color:red" v-if="(step1 && !$v.memberData.personalData.middle_name.required)" > the middle name faild is required</b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.middle_name.maxLength )" > the max Length character in middle name  is {{ $v.memberData.personalData.middle_name.$params.maxLength.max }} </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.middle_name.minLength )" > the min Length character in middle name  is  {{ $v.memberData.personalData.middle_name.$params.minLength.min }} </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="error.middle_name" >   {{ error.middle_name[0] }} </b-form-invalid-feedback>

                                                    </div>
                                                    <div class="col-12 mt-4" >
                                                        <input :class="['form-control', (step1  &&  !$v.memberData.personalData.last_name.required || step1 && !$v.memberData.personalData.last_name.maxLength || !$v.memberData.personalData.last_name.minLength || error.last_name) ? 'is-invalid' : '']" type="text" required="" placeholder="Last name" v-model="memberData.personalData.last_name">
                                                        <b-form-invalid-feedback style="color:red" v-if="(step1 && !$v.memberData.personalData.last_name.required)" > the last name faild is required</b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.last_name.maxLength )" > the max Length character in last name  is {{ $v.memberData.personalData.last_name.$params.maxLength.max }} </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.last_name.minLength )" > the min Length character in last name  is  {{ $v.memberData.personalData.last_name.$params.minLength.min }} </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="error.last_name" >   {{ error.last_name[0] }} </b-form-invalid-feedback>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-form-label">gender</label>
                                                <select :class="['form-control', (step1  &&  !$v.memberData.personalData.gender.required || error.gender) ? 'is-invalid' : '']"  required="" v-model="memberData.personalData.gender">
                                                        <option >male</option>
                                                        <option >famele</option>
                                                </select>
                                                   <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.gender.required )" > the gender failed  is required </b-form-invalid-feedback>
                                                   <b-form-invalid-feedback style="color:red" v-if="error.gender" >   {{ error.gender[0] }} </b-form-invalid-feedback>

                                            </div>


                                            <div class="form-group">
                                                <label class="col-form-label">date of birth</label>
                                                <input :class="['form-control', (step1  &&  !$v.memberData.personalData.data_of_birth.required || error.data_of_birth) ? 'is-invalid' : '']" type="date" required="" v-model="memberData.personalData.data_of_birth">
                                                   <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.personalData.data_of_birth.required )" > the data of birth failed  is required </b-form-invalid-feedback>
                                                   <b-form-invalid-feedback style="color:red" v-if="error.data_of_birth" >   {{ error.data_of_birth[0] }} </b-form-invalid-feedback>

                                            </div>



                                        </div>
                                    </div>
                                </tab-content>


                                <tab-content :before-change="contactDataValidation" title="contact details">
                                    <div class="setup-content" id="step-2">
                                    <div class="col-xs-12">


                                                <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                    <div class="col-form-label"> address </div>

                                                    <input name="address"  :class="['form-control', (step2  &&  !$v.memberData.contactData.address.required || error.address) ? 'is-invalid' : '']" v-model="memberData.contactData.address"  placeholder="address"/>
                                                    <b-form-invalid-feedback style="color: red" v-if="error.address">{{ error.address[0] }}</b-form-invalid-feedback >
                                                   <b-form-invalid-feedback style="color:red" v-if="(step2 && !$v.memberData.contactData.address.required)" > the  address faild is required</b-form-invalid-feedback>

                                                </div>

                                                <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                    <div class="col-form-label"> City </div>

                                                    <input name="city"  :class="['form-control', (step2  &&  !$v.memberData.contactData.city.required || error.city) ? 'is-invalid' : '']"  v-model="memberData.contactData.city" placeholder="your city"/>
                                                    <b-form-invalid-feedback style="color: red" v-if="error.city">{{ error.city[0] }}</b-form-invalid-feedback >
                                                   <b-form-invalid-feedback style="color:red" v-if="(step2 && !$v.memberData.contactData.city.required)" > the  city faild is required</b-form-invalid-feedback>
                                                </div>

                                                <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                    <div class="col-form-label"> phone number  </div>

                                                    <input name="phone" :class="['form-control', (step2  &&  !$v.memberData.contactData.phone_number.required || error.phone_number) ? 'is-invalid' : '']" v-model="memberData.contactData.phone_number" placeholder="phone number"/>
                                                  <b-form-invalid-feedback style="color: red" v-if="error.phone_number">{{ error.phone_number[0] }}</b-form-invalid-feedback >
                                                   <b-form-invalid-feedback style="color:red" v-if="(step2 && !$v.memberData.contactData.phone_number.required)" > the  phone number faild is required</b-form-invalid-feedback>
                                                </div>


                                        </div>

                                    </div>
                                </tab-content>

                                <tab-content :before-change="loginDatavalidation" title="login details">
                                    <div class="setup-content" id="step-3">
                                    <div class="col-xs-12">


                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">  user name  </div>

                                            <input name="" :class="['form-control', (step3  &&  !$v.memberData.loginData.user_name.required  || step3 && !$v.memberData.loginData.user_name.maxLength || !$v.memberData.loginData.user_name.minLength || error.user_name) ? 'is-invalid' : '']"  v-model="memberData.loginData.user_name"  placeholder="user name">
                                                   <b-form-invalid-feedback style="color: red" v-if="error.user_name">{{ error.user_name[0] }}</b-form-invalid-feedback >
                                                   <b-form-invalid-feedback style="color:red" v-if="(step3 && !$v.memberData.loginData.user_name.required)" > the  user name  faild is required</b-form-invalid-feedback>
                                                   <b-form-invalid-feedback style="color:red" v-if="( !$v.memberData.loginData.user_name.maxLength )" > the  user name  faild must  lessthan {{$v.memberData.loginData.user_name.$params.maxLength.max}}</b-form-invalid-feedback>
                                                   <b-form-invalid-feedback style="color:red" v-if="( !$v.memberData.loginData.user_name.minLength )" > the  user name  faild must  longerthan {{$v.memberData.loginData.user_name.$params.minLength.min}}</b-form-invalid-feedback>
                                            </div>

                                          <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                    <div class="col-form-label">  email  </div>

                                                    <input name="" :class="['form-control', (step3  &&  !$v.memberData.loginData.email.required || step2 && !$v.memberData.loginData.email.email || error.email) ? 'is-invalid' : '']"  v-model="memberData.loginData.email"  placeholder="email"/>
                                                   <b-form-invalid-feedback style="color: red" v-if="error.email">{{ error.email[0] }}</b-form-invalid-feedback >
                                                   <b-form-invalid-feedback style="color:red" v-if="(step3 && !$v.memberData.loginData.email.required)" > the  email  faild is required</b-form-invalid-feedback>
                                                   <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.loginData.email.email)" > the  email  faild is must valide email</b-form-invalid-feedback>
                                                </div>

                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">  password  </div>

                                            <input name="" :class="['form-control', (step3  &&  !$v.memberData.loginData.password.required || step3 && !$v.memberData.loginData.password.maxLength || !$v.memberData.loginData.password.minLength || error.password) ? 'is-invalid' : '']"   v-model="memberData.loginData.password" placeholder="password" />
                                                   <b-form-invalid-feedback style="color: red" v-if="error.password">{{ error.password[0] }}</b-form-invalid-feedback >
                                                   <b-form-invalid-feedback style="color:red" v-if="(step3 && !$v.memberData.loginData.password.required)" > the  password  faild is required</b-form-invalid-feedback>
                                                    <b-form-invalid-feedback style="color:red" v-if="( !$v.memberData.loginData.password.maxLength )" > the password  faild must  lessthan {{$v.memberData.loginData.password.$params.maxLength.max}}</b-form-invalid-feedback>
                                                   <b-form-invalid-feedback style="color:red" v-if="( !$v.memberData.loginData.password.minLength )" > the  password  faild must  longerthan {{$v.memberData.loginData.password.$params.minLength.min}}</b-form-invalid-feedback>
                                    </div>


                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label"> Confirm password  </div>

                                            <input name="" :class="['form-control', (step3  &&  !$v.memberData.loginData.confirm_password.sameAsPassword || error.confirm_password) ? 'is-invalid' : '']" v-model="memberData.loginData.confirm_password" placeholder="confirm password" />
                                              <b-form-invalid-feedback style="color: red" v-if="error.confirm_password">{{ error.confirm_password[0] }}</b-form-invalid-feedback >
                                            <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.loginData.confirm_password.sameAsPassword)" > the  confirm password  must same the failde password</b-form-invalid-feedback>
                                           </div>

                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">

                                                <div class="col-form-label"> Upload profile picture (optional)</div>

                                                <vue-dropzone
                                                    name="file"
                                                    ref="myVueDropzone"
                                                    id="singledropzone"
                                                    :options="singledropzoneOptions"
                                                    class="dropzone digits"
                                                    @vdropzone-file-added="handleFileAdded"
                                                    @vdropzone-removed-file="removed"

                                                >
                                                </vue-dropzone>

                                             <small style="color: red" v-if="error.profile_picture">{{ error.profile_picture[0] }}</small >
                                        </div>

                                    </div>
                                    </div>
                                </tab-content>
                                  <tab-content  :before-change="extraDatavalidation" title="extra details">
                                    <div class="setup-content" id="step-3">
                                    <div class="col-xs-12">


                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">  interested area (optional)  </div>

                                           <textarea style="width: 100%"  :class="['form-control',error.interested_area? 'is-invalid' : '']"   v-model="memberData.extraData.interested_area"></textarea>
                                             <small style="color: red" v-if="error.interested_area">{{ error.interested_area[0] }}</small >
                                        </div>


                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">  source (optional) </div>

                                            <textarea style="width: 100%" :class="['form-control',error.source? 'is-invalid' : '']"  v-model="memberData.extraData.source"></textarea>
                                             <small style="color: red" v-if="error.source">{{ error.source[0] }}</small >
                                        </div>


                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">   class  </div>

                                            <select name="class" :class="['form-control', (step4  &&  !$v.memberData.extraData.class_id.required || error.class_id) ? 'is-invalid' : '']"   v-model="memberData.extraData.class_id">
                                                  <option :value="item.id" v-for="(item,index) in classes"  :key="index">
                                                        {{ item.className }}
                                                </option>
                                            </select>
                                              <b-form-invalid-feedback style="color: red" v-if="error.class_id">{{ error.class_id[0] }}</b-form-invalid-feedback >
                                            <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.extraData.class_id.requried)" > the  class failde is required</b-form-invalid-feedback>
                                        </div>


                                       <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">   membership  </div>

                                            <select name="membership"  :class="['form-control', (step4  &&  !$v.memberData.extraData.membership_id.required || error.membership_id) ? 'is-invalid' : '']"  v-model="memberData.extraData.membership_id" >
                                                <option :value="item.id" v-for="(item,index) in memberships"  :key="index">
                                                        {{ item.name }}
                                                </option>
                                            </select>
                                              <b-form-invalid-feedback style="color: red" v-if="error.membership_id">{{ error.membership_id[0] }}</b-form-invalid-feedback >
                                            <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.extraData.membership_id.requried)" > the  membership  failde is required</b-form-invalid-feedback>
                                      </div>



                                            <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                <div class="col-form-label"> Group</div>

                                                <select name="group" :class="['form-control', (step4  &&  !$v.memberData.extraData.group_id.required || error.group_id) ? 'is-invalid' : '']" v-model="memberData.extraData.group_id"  >
                                                      <option :value="item.id" v-for="(item,index) in groups"  :key="index">
                                                        {{ item.name }}
                                                      </option>
                                                </select>
                                            <b-form-invalid-feedback style="color: red" v-if="error.group_id">{{ error.group_id[0] }}</b-form-invalid-feedback >
                                            <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.extraData.group_id.requried)" > the  group failde is required</b-form-invalid-feedback>
                                            </div>



                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">   start data  </div>

                                            <input name="" type="date"    :class="['form-control', (step4  &&  !$v.memberData.extraData.start_date.required || error.start_date) ? 'is-invalid' : '']"  v-model="memberData.extraData.start_date" />
                                                                                         <b-form-invalid-feedback style="color: red" v-if="error.start_date">{{ error.start_date[0] }}</b-form-invalid-feedback >
                                            <b-form-invalid-feedback style="color:red" v-if="(!$v.memberData.extraData.start_date.requried)" > the  start date failde is required</b-form-invalid-feedback>
                                        </div>

                                    </div>
                                    </div>
                                </tab-content>

                            </form-wizard>




                            <p class="mt-4 mb-0">Already have an account?
                                <router-link class="ml-2" tag="a" to="/auth/login" >
                                        Login
                                    </router-link>
                            </p>

                    </div>



            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</template>


<script>

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

import axios from 'axios'
import {
    required,
     minLength,
      maxLength,
      between,
      sameAs,
      requiredIf,
      email

      } from 'vuelidate/lib/validators'




export default {

    data(){
        return{

            memberData:{

                    personalData:{

                         first_name:'',
                        middle_name:'',
                        last_name:'',
                        gender:'',
                        data_of_birth:'',

                    },

                    contactData:{

                        address:'',
                        city:'',
                        phone_number:'',
                        email:'',

                    },


                   loginData:{

                        user_name:'',
                        password:'',
                        confirm_password:'',
                        profile_picture:[],
                        isActive:true,

                   },

                   extraData:{

                         interested_area:'',
                        source:'',
                        membership_id:'',
                        group_id:'',
                        class_id:'',
                        start_date:'',
                   }

                    },
             classes: [],
             groups: [],
             memberships: [],

            error:[],
            step1:false,
            step2:false,
            step3:false,
            step4:false,

                singledropzoneOptions:{
                url:'http://127.0.0.1:8000/api/addMember',
                thumbnailWidth: 150,
                maxFiles:1,
                autoProcessQueue: false,
                maxFilesize: 2,
                acceptedFiles: ".jpg , .jpeg, .png",
                maxNumberOfFiles: 1,
                addRemoveLinks: true,
                dictDefaultMessage:
                    "<i class='icon-cloud-up'></i><br />Select Profile Picture",
            },


           }
    },

    validations:{

        memberData:{

            personalData:{

                    first_name:{
                        required,
                        maxLength:maxLength(25),
                        minLength:minLength(3)
                    },
                    middle_name:{
                        required,
                        maxLength:maxLength(25),
                        minLength:minLength(3)
                    },
                    last_name:{
                        required,
                        maxLength:maxLength(25),
                        minLength:minLength(3)
                    },
                    gender:{
                    required,

                    },
                    data_of_birth:{
                        required,
                    },
                },


                contactData:{

                        address:{
                                required,
                        },
                        city:{
                            required,
                        },
                        phone_number:{
                            required,
                        },


                    },


                    loginData:{

                      user_name:{
                          required,
                            maxLength:maxLength(20),
                             minLength:minLength(3)
                      },
                        password:{
                            required,
                             maxLength:maxLength(20),
                             minLength:minLength(6)
                        },
                        confirm_password:{
                            sameAsPassword:sameAs("password")
                        },
                         email:{
                            required,
                            email
                        }

                    },

                    extraData:{

                          group_id:{
                              required,
                          },
                          membership_id:{
                              required,
                          },
                          class_id:{
                              required,
                          },
                          start_date:{
                              required,
                          },

                    }



         },
    },

    components: {
        vueDropzone: vue2Dropzone

    },

    beforeMount(){


         axios.get('memberships')
            .then(res => {

                if(res.data.success){
                    this.memberships = res.data.memberships
                }
            })
            .catch(err => {

               console.log(err.message)
            })

            axios.get('groups')
            .then(res => {

                 if(res.data.success){
                    this.groups = res.data.groups
                }

            })
            .catch(err => {
                console.log(err.message)
            })

            axios.get('getClassToSelect')
            .then(res => {


                  if(res.data.success){
                    this.classes = res.data.classes
                }

            })
            .catch(err => {
               console.log(err.message)
            })

    },

    methods:{

         sendDataToApiBeforeSubmit(){




                let formData = new FormData()
                formData.append('first_name'         , this.memberData.personalData.first_name)
                formData.append('middle_name'        , this.memberData.personalData.middle_name)
                formData.append('last_name'          , this.memberData.personalData.last_name)
                formData.append('gender'             , this.memberData.personalData.gender)
                formData.append('data_of_birth'      , this.memberData.personalData.data_of_birth)
                formData.append('group_id'           , this.memberData.extraData.group_id)
                formData.append('address'            , this.memberData.contactData.address)
                formData.append('city'               , this.memberData.contactData.city)
                formData.append('phone_number'       , this.memberData.contactData.phone_number)
                formData.append('email'              , this.memberData.loginData.email)
                formData.append('user_name'          , this.memberData.loginData.user_name)
                formData.append('password'           , this.memberData.loginData.password)
                formData.append('confirm_password'   , this.memberData.loginData.confirm_password)
                formData.append('profile_picture'    , this.memberData.loginData.profile_picture)
                formData.append('interested_area'    , this.memberData.extraData.interested_area)
                formData.append('source'             , this.memberData.extraData.source)
                formData.append('membership_id'      , this.memberData.extraData.membership_id)
                formData.append('class_id'           , this.memberData.extraData.class_id)
                formData.append('start_date'         , this.memberData.extraData.start_date)
                formData.append('isActive'           , this.memberData.loginData.isActive)




            let config = {
                    headers: {
                        "Content-Type":
                            "multipart/form-data; charset=utf-8 ; boundary=" +
                            Math.random()
                                .toString()
                                .substr(2)
                    }
                };




                axios.post('addMember',formData,config)
                .then(res => {

                    if(res.data.success == false){

                             this.error = res.data.message
                             console.log(this.$refs.wizard)
                    }

                    if(res.data.success){
                        this.$router.push({name:'login'})
                        this.error = []
                        Toast.fire({
                            icon: 'success',
                            title: 'registeration success  login into profile now'
                        })

                    }

                    console.log(res)
                })
                .catch(err => {

                    console.log(err)

                })

        },


        extraDatavalidation(){

            this.$v.memberData.$touch();

            if(this.$v.memberData.extraData.$invalid){

              this.step4 = true
               return false

            }else{

                   this.step4 = true
                   return true
            }

        },
        loginDatavalidation(){
              this.$v.memberData.$touch();

            if(this.$v.memberData.loginData.$invalid){

              this.step3 = true
               return false

            }else{

                   this.step3 = true
                   return true
            }

        },
        personalDataValidation(){

           this.$v.memberData.$touch();

           if(this.$v.memberData.personalData.$invalid){

              this.step1 = true
               return false

           }else{

             this.step1 = true
               return true
           }

        },
        contactDataValidation(){

             this.$v.memberData.$touch();

           if(this.$v.memberData.contactData.$invalid){

              this.step2 = true
               return false

           }else{

             this.step2 = true
               return true
           }

        },
          handleFileAdded(file) {


            if (this.memberData.loginData.profile_picture.length < 1) {
                this.memberData.loginData.profile_picture = file;
            }

        },
        removed(files){

            if(files.name == this.memberData.loginData.profile_picture.name){

                this.memberData.loginData.profile_picture = []
            }
        },

    }


}
</script>

