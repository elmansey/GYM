<template>
    <div v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit person in staff' : 'add person in staff'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                          <form @submit.prevent="handelSubmitData" >

                                              <div class="row">

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> first name</div>

                                                      <input name="firstName" :class="['form-control', submited && !$v.staffData.firstName.required ||  error.firstName ? 'is-invalid' : '']"  v-model="staffData.firstName"/>
                                                      <small style="color: red" v-if="error.firstName">{{ error.firstName[0]}}</small>
                                                     <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.staffData.firstName.required)"> the first name faild is required</b-form-invalid-feedback>

                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label">middle name</div>

                                                      <input name="name" :class="['form-control', submited && !$v.staffData.middleName.required ||   error.middleName ? 'is-invalid' : '']"  v-model="staffData.middleName"/>
                                                      <small style="color: red" v-if="error.middleName">{{ error.middleName[0]}}</small>
                                                    <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.staffData.middleName.required)"> the middle name faild is required</b-form-invalid-feedback>

                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label">last name</div>

                                                      <input name="name" :class="['form-control', submited &&  !$v.staffData.lastName.required ||   error.lastName ? 'is-invalid' : '']"  v-model="staffData.lastName"/>
                                                      <small style="color: red" v-if="error.lastName">{{ error.lastName[0]}}</small>
                                                    <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.staffData.lastName.required)"> the last name faild is required</b-form-invalid-feedback>

                                                  </div>


                                                  <div class="mb-2 col-md-6 co1l-lg-6 col-sm-12">
                                                      <div class="col-form-label"> phone number</div>

                                                      <input name="phone" :class="['form-control', submited && !$v.staffData.phone.required ||   error.phone ? 'is-invalid' : '']" v-model="staffData.phone"/>
                                                      <small style="color: red" v-if="error.phone">{{ error.phone[0]}}</small>
                                                      <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.staffData.phone.required)"> the phone faild is required</b-form-invalid-feedback>

                                                  </div>

                                                  <div hidden class="mb-2 col-md-6 col-lg-6 col-sm-12">

                                                      <select  hidden  v-model="staffData.role">

                                                      </select>

                                                  </div>

                                                     <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                      <div class="col-form-label"> notes</div>

                                                      <textarea name="phone" :class="['form-control',  error.notes ? 'is-invalid' : '']" v-model="staffData.notes"></textarea>
                                                      <small style="color: red" v-if="error.notes">{{ error.notes[0]}}</small>

                                                  </div>

                                              <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                  <div class="col-form-label"> Upload profile picture</div>


                                                      <vue-dropzone
                                                          name="file"
                                                          ref="myVueDropzone"
                                                          id="singledropzone"
                                                          :options="singledropzoneOptions"
                                                          :class="['dropzone digits',error.password ? 'is-invalid' : '']"
                                                          @vdropzone-file-added="handleFileAdded"
                                                          @vdropzone-removed-file="removed"

                                                      >
                                                      </vue-dropzone>


                                                  <small style="color: red" v-if="error.profile_picture">{{ error.profile_picture[0]}}</small>
                                              </div>


                                                <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                        <input  type="checkbox" v-model="allowLogin"/>
                                                        <span class="col-form-label">alow login</span>

                                                  </div>

                                                    <div class="login data row" v-if="allowLogin">

                                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> email</div>

                                                        <input name="email" type="email" :class="['form-control',error.email || submited && !$v.staffData.loginData.email.requiredIf ? 'is-invalid' : '']"  v-model="staffData.loginData.email"/>
                                                        <small style="color: red" v-if="error.email">{{ error.email[0]}}</small>
                                                        <b-form-invalid-feedback style="color:red" v-if="( !$v.staffData.loginData.email.requiredIf)"> the email faild is required</b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="( !$v.staffData.loginData.email.email)"> the email  must vaild email </b-form-invalid-feedback>

                                                    </div>
                                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> user name</div>

                                                        <input name="userName" type="text" :class="['form-control', submited && !$v.staffData.loginData.userName.requiredIf || error.userName ? 'is-invalid' : '']"  v-model="staffData.loginData.userName"/>
                                                        <small style="color: red" v-if="error.userName">{{ error.userName[0]}}</small>
                                                        <b-form-invalid-feedback style="color:red" v-if="( !$v.staffData.loginData.userName.requiredIf)"> the user name failde is required   </b-form-invalid-feedback>
                                                    </div>
                                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> password</div>

                                                        <input name="password" type="password" :class="['form-control' , submited && !$v.staffData.loginData.password.requiredIf || !$v.staffData.loginData.password.maxLength || !$v.staffData.loginData.password.minLength || error.password ? 'is-invalid' : '']"  v-model="staffData.loginData.password"/>
                                                        <small style="color: red" v-if="error.password">{{ error.password[0]}}</small>
                                                        <b-form-invalid-feedback style="color:red" v-if="( !$v.staffData.loginData.password.requiredIf)"> the  password failde is required   </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="( !$v.staffData.loginData.password.maxLength)"> the max character allow is {{  $v.staffData.loginData.password.$params.maxLength.max }}   </b-form-invalid-feedback>
                                                        <b-form-invalid-feedback style="color:red" v-if="( !$v.staffData.loginData.password.minLength)">  the min character allow is {{  $v.staffData.loginData.password.$params.minLength.min }}    </b-form-invalid-feedback>

                                                    </div>
                                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> confirm password</div>

                                                        <input name="password" type="password" :class="['form-control', submited &&   !$v.staffData.loginData.confirm_Password.requiredIf ||  error.confirm_Password ? 'is-invalid' : '']"  v-model="staffData.loginData.confirm_Password"/>
                                                        <small style="color: red" v-if="error.confirm_Password">{{ error.confirm_Password}}</small>
                                                        <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.staffData.loginData.confirm_Password.requiredIf)"> the confirm  password failde is required   </b-form-invalid-feedback>

                                                    </div>
                                                    <div class="mb-2 col-md-12 col-lg-12 col-sm-12 mt-3">
                                                             <div class="media">
                                                                <label class="col-form-label m-r-10">active</label>
                                                                <div class="media-body text-right switch-lg icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox" checked="" v-model="staffData.loginData.isActive"><span class="switch-state"></span>
                                                                </label>
                                                                </div>
                                                            </div>
                                                    </div>

                                                    </div>
                                                <div class="mb-2 col-md-12 col-lg-12 col-sm-12">

                                                        <button type="submit" class="btn btn-primary mt-3"  v-if="!edit" >
                                                            Save
                                                        </button>

                                                        <button  type="submit" class="btn btn-success mt-3"   v-if="edit" >
                                                            update
                                                        </button>
                                                </div>
                                              </div>

                                          </form>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

    <div v-else class="col-md-3" style="margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);">
        <h6 class="sub-title mb-0 text-center"></h6>
        <div class="loader-box" >
            <div class="loader-3"></div>
        </div>
    </div>


</template>

<script>
import Multiselect from 'vue-multiselect'
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
            staffData:{
                'firstName':'',
                'middleName':'',
                'lastName':'',
                'phone':'',
                loginData:{
                    'email':'',
                    'userName':'',
                    'password':'',
                    'confirm_Password':'',
                    'isActive':true,

                },
                'profile_picture':'',
                'role':{id: 1, name: "staff"},
                'notes':''
            },
            isLoading:false,
            allowLogin:false,
            submited:false,

            options: [],
            error:'',
            edit:true,


            singledropzoneOptions:{
                url:'http://127.0.0.1:8000/api/addPersonInStaff',
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
    components: {
        Multiselect,
        vueDropzone: vue2Dropzone

    },

    beforeMount() {

        if(this.$route.params.staffPersonId){
            this.edit = true

            axios.get(`getItemFromStaffById/${this.$route.params.staffPersonId}`)
            .then(res => {

                console.log(res);

                if(res.data.success){
                      this.staffData.firstName       = res.data.staff.firstName
                        this.staffData.middleName     = res.data.staff.middleName
                        this.staffData.lastName     = res.data.staff.lastName
                        this.staffData.phone         = res.data.staff.phone
                        this.staffData.role           = res.data.staff.roles
                        this.staffData.loginData.email     = res.data.staff.email
                        this.staffData.loginData.userName     = res.data.staff.userName
                        this.staffData.loginData.isActive     = res.data.staff.isActive
                        this.staffData.notes     = res.data.staff.notes
                        this.isLoading = true

                        this.allowLogin = (res.data.staff.email)
                }

                if(res.data.status == 404){
                    this.$router.push({name : 'staffList'})
                }


            })
            .catch(err => {

            })



        }else{
            this.edit = false
            this.isLoading = true
        }
    },

    beforeCreate(){

        axios.get('getStaffRole')
        .then(res => {
            this.options = res.data.staffRole
        })
        .catch(err => {

        })







    },

    validations:{

        staffData:{
                'firstName':{
                    required:required,
                },
                'middleName':{
                    required:required,
                },
                'lastName':{
                    required:required,
                },
                'phone':{
                    required:required,
                },

                loginData:{
                    'email':{
                        requiredIf:requiredIf( function(){
                            return this.allowLogin
                        }),
                        email,
                    },
                    'userName':{
                            requiredIf:requiredIf( function(){
                            return this.allowLogin
                        }),
                    },
                    'password':{
                            requiredIf:requiredIf( function(){
                            return this.allowLogin  && this.edit == false
                        }),
                           maxLength:maxLength(25),
                          minLength:minLength(6)

                    },
                    'confirm_Password':{
                            requiredIf:requiredIf( function(){
                            return this.allowLogin && this.edit == false
                        }),
                    },
                },
                'role':{
                    required:required,
                },

            },

    },

    methods: {

         handelSubmitData(){

                this.$v.staffData.$touch();
                this.submited = true

                if(!this.$v.staffData.$invalid){


                if(this.edit == false){

                    let formData = new FormData();

                    formData.append('firstName',this.staffData.firstName)
                    formData.append('middleName',this.staffData.middleName)
                    formData.append('lastName',this.staffData.lastName)
                    formData.append('phone',this.staffData.phone)
                    formData.append('userName',this.staffData.loginData.userName)
                    formData.append('email',this.staffData.loginData.email)
                    formData.append('password',this.staffData.loginData.password)
                    formData.append('isActive',this.staffData.loginData.isActive)
                    formData.append('confirm_Password',this.staffData.loginData.confirm_Password)
                    formData.append('profile_picture',this.staffData.profile_picture)
                    formData.append('role',JSON.stringify(this.staffData.role))
                    formData.append('notes',this.staffData.notes)




                    let config = {
                        headers:{
                            "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                        }
                    }

                    axios.post('addInStaff',formData,config)
                        .then(res => {

                            if(res.data.success == true){
                                this.error = ''
                                this.submited = false

                                   this.staffData.firstName  = ''
                                    this.staffData.middleName = ''
                                    this.staffData.lastName = ''
                                    this.staffData.phone = ''

                                    this.staffData.loginData.email = ''
                                    this.staffData.loginData.userName = ''
                                    this.staffData.loginData.password = ''
                                    this.staffData.loginData.isActive = true
                                    this.staffData.loginData.confirm_Password = ''
                                    this.staffData.profile_picture   = ''
                                    this.staffData.role = {id: 1, name: "staff"},
                                    this.staffData.notes = ''

                                this.$router.push('staffList')
                                Toast.fire({
                                    icon: 'success',
                                    title: 'person added in staff successfully'
                                })

                                console.log(res.data)

                            }else if(res.data.success == false) {

                                this.error = res.data.message
                            }

                        })
                        .catch(err => {
                            console.log(err)
                        })
                }

                if(this.edit){

                    let formData = new FormData();

                    formData.append('firstName',this.staffData.firstName)
                    formData.append('middleName',this.staffData.middleName)
                    formData.append('lastName',this.staffData.lastName)
                    formData.append('phone',this.staffData.phone)
                    formData.append('userName',this.staffData.loginData.userName)
                    formData.append('email',this.staffData.loginData.email)
                    formData.append('password',this.staffData.loginData.password)
                    formData.append('isActive',this.staffData.loginData.isActive)
                    formData.append('confirm_Password',this.staffData.loginData.confirm_Password)
                    formData.append('profile_picture',this.staffData.profile_picture)
                    formData.append('role',JSON.stringify(this.staffData.role))
                    formData.append('notes',this.staffData.notes)




                    let config = {
                        headers:{
                            "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                        }
                    }

                    axios.post(`updateInStaff/${this.$route.params.staffPersonId}`,formData,config)
                        .then(res => {

                            if(res.data.success == true){
                                this.error = ''
                                this.submited = false

                                   this.staffData.firstName  = ''
                                    this.staffData.middleName = ''
                                    this.staffData.lastName = ''
                                    this.staffData.phone = ''

                                    this.staffData.loginData.email = ''
                                    this.staffData.loginData.userName = ''
                                    this.staffData.loginData.password = ''
                                    this.staffData.loginData.isActive = true
                                    this.staffData.loginData.confirm_Password = ''
                                    this.staffData.profile_picture   = ''
                                    this.staffData.role = {id: 1, name: "staff"},
                                    this.staffData.notes = ''
                                    this.$router.push({name : 'staffList'})

                                Toast.fire({
                                    icon: 'success',
                                    title: 'staff person updated  successfully'
                                   })
                                console.log(res.data)

                            }else if(res.data.success == false) {

                                this.error = res.data.message
                            }

                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
            }




        },

        handleFileAdded(file) {

            console.log(file);
            if (this.staffData.profile_picture.length < 1) {
                this.staffData.profile_picture = file;
            }

        },
        removed(files){

            if(files.name == this.staffData.profile_picture.name){

                this.staffData.profile_picture = []
            }
        },

        asyncFind (query) {
            this.options = findService(query)
        },

        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.taggingOptions.push(tag)
            this.taggingSelected.push(tag)
        },


        // editAdmin(){

        //     axios.post('userUpdate',this.staffData)
        //         .then(res => {

        //             if(res.data.success == true){
        //                 Toast.fire({
        //                     icon: 'success',
        //                     title: 'admin updated successfully'
        //                 })
        //                 this.$router.push({name : 'adminsList'})

        //             }else if(res.data.success == false) {

        //                 this.error = res.data.message
        //             }

        //         })
        //         .catch(err => {
        //             console.log(err)
        //         })

        // }
    },

    watch:{


        $route(to,from){

            if(to.name == 'addPersonInStaff'){
                    this.edit = false
                    this.staffData.firstName   = '',
                    this.staffData.middleName   = '',
                    this.staffData.lastName   = '',
                    this.staffData.phone   = '',
                    this.staffData.loginData.email   = '',
                    this.staffData.loginData.userName   = '',
                    this.staffData.loginData.password   = '',
                    this.staffData.loginData.password   = '',
                    this.staffData.loginData.isActive   = true,
                    this.staffData.profile_picture   = '',
                    this.staffData.role   = '',
                    this.staffData.notes   = '',
                    this.allowLogin     = false


            }

        }

    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
