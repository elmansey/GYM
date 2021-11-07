<template>
    <div v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit admin' : 'add admin'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                          <form @submit.prevent="handelSubmitData" id="myform">

                                              <div class="row">

                                                  <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                      <div class="col-form-label">name</div>

                                                      <input name="name" :class="['form-control',error.name ? 'is-invalid' : '']"  v-model="adminData.name"/>
                                                      <small style="color: red" v-if="error.name">{{ error.name[0]}}</small>
                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label">user name</div>

                                                      <input name="name" :class="['form-control',error.user_name ? 'is-invalid' : '']"  v-model="adminData.user_name"/>
                                                      <small style="color: red" v-if="error.user_name">{{ error.user_name[0]}}</small>
                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> email</div>

                                                      <input name="email" type="email" :class="['form-control',error.email ? 'is-invalid' : '']"  v-model="adminData.email"/>
                                                      <small style="color: red" v-if="error.email">{{ error.email[0]}}</small>
                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> phone number</div>

                                                      <input name="phone" :class="['form-control',error.phone ? 'is-invalid' : '']" v-model="adminData.phone"/>
                                                      <small style="color: red" v-if="error.phone">{{ error.phone[0]}}</small>
                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label">Choose the  Roles</div>

                                                      <multiselect name="role" v-model="adminData.roles" tag-placeholder="Add this as new tag" placeholder="Search or add a tag"
                                                                    :class="[error.role ? 'is-invalid' : '']"     label="name" track-by="id"   @search-change="asyncFind" :options="options"  :multiple="true"   :taggable="true" @tag="addTag"  >

                                                      </multiselect>
                                                      <small  style="color: red" v-if="error.role">{{ error.role[0]}}</small>

                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> password</div>

                                                      <input name="password"  :class="['form-control',error.password ? 'is-invalid' : '']"  v-model="adminData.password"/>
                                                      <small style="color: red" v-if="error.password">{{ error.password[0]}}</small>
                                                  </div>

                                                  <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                      <div class="col-form-label"> confirm password</div>

                                                      <input name="confirm_password" :class="['form-control',error.confirm_password ? 'is-invalid' : '']"  v-model="adminData.confirm_password"/>
                                                      <small style="color: red" v-if="error.confirm_password">{{ error.confirm_password[0]}}</small>
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

                                                  <div class="mb-2 col-md-12 col-lg-12 col-sm-12 mt-3">
                                                             <div class="media">
                                                                <label class="col-form-label m-r-10">active</label>
                                                                <div class="media-body text-right switch-lg icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox" checked=""   v-model="adminData.isActive"><span class="switch-state"></span>
                                                                </label>
                                                                </div>
                                                            </div>
                                                    </div>

                                              <button type="submit" class="btn btn-primary mt-3"  v-if="!edit" >
                                                  Save
                                              </button>

                                              <button  type="submit" class="btn btn-success mt-3"   v-if="edit" >
                                                  update
                                              </button>

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

export default {
    data(){
        return{
            adminData:{
                id:'',
                user_name:'',
                name:'',
                email:'',
                phone:'',
                password:'',
                confirm_password:'',
                roles: [],
                file:[],
                isActive: ''
            },
            isLoading:false,

            options: [],
            error:'',
            edit:true,


            singledropzoneOptions:{
                url:'http://127.0.0.1:8000/api/admin/adminAdd',
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

    beforeCreate() {
    axios.get('createUser')
        .then(res => {

            if(res.data.success == true){
                this.options = res.data.roles
                this.isLoading = true
            }

        })
        .catch(err => {

            console.log(err)
        });

    },

    beforeMount() {

        if(this.$route.params.adminId){
            this.edit = true
            axios.get(`getUserById/${this.$route.params.adminId}` )

             .then(res => {

                     this.adminData.id  = res.data.data.id,
                     this.adminData.name  = res.data.data.name,
                     this.adminData.user_name  = res.data.data.user_name,
                     this.adminData.email  = res.data.data.email,
                     this.adminData.phone  = res.data.data.phone,
                     this.adminData.isActive  = res.data.data.isActive,
                  this.adminData.roles = res.data.role
                 this.isLoading = true

            })
            .catch(err => {
                console.log(err.message)

            })
        }else{
            this.edit = false
        }

    },



    methods: {

        handelSubmitData(){

            if(this.edit == false){

                let formData = new FormData();


                formData.append('name',this.adminData.name);
                formData.append('user_name',this.adminData.user_name);
                formData.append('email',this.adminData.email);
                formData.append('phone',this.adminData.phone);
                formData.append('password',this.adminData.password);
                formData.append('confirm_password',this.adminData.confirm_password);
                formData.append('role', JSON.stringify(this.adminData.roles));
                formData.append('profile_picture',this.adminData.file);
                formData.append('isActive',this.adminData.isActive);



                let config = {
                    headers:{
                        "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                    }
                }

                axios.post('adminAdd',formData,config)
                    .then(res => {

                        if(res.data.success == true){
                            Toast.fire({
                                icon: 'success',
                                title: 'admin added successfully'
                            })
                            this.$router.push('adminsList')

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


                formData.append('name',this.adminData.name);
                formData.append('user_name',this.adminData.user_name);
                formData.append('email',this.adminData.email);
                formData.append('phone',this.adminData.phone);
                formData.append('password',this.adminData.password);
                formData.append('confirm_password',this.adminData.confirm_password);
                formData.append('role', JSON.stringify(this.adminData.roles));
                formData.append('profile_picture',this.adminData.file);
                formData.append('isActive',this.adminData.isActive);



                let config = {
                    headers:{
                        "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                    }
                }

                axios.post(`userUpdate/${this.$route.params.adminId}`,formData,config)
                    .then(res => {

                        if(res.data.success == true){

                            this.$store.dispatch('userInfo')

                            Toast.fire({
                                icon: 'success',
                                title: 'admin updated successfully'
                            })
                            this.$router.push({name:'adminsList'})

                        }else if(res.data.success == false) {

                            this.error = res.data.message
                        }

                    })
                    .catch(err => {
                        console.log(err)
                    })


            }

        },
        handleFileAdded(file) {

            console.log(file);
            if (this.adminData.file.length < 1) {
                this.adminData.file = file;
            }

        },
        removed(files){

            if(files.name == this.adminData.file.name){

                this.adminData.file = []
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


        editAdmin(){

            axios.post('userUpdate',this.adminData)
                .then(res => {

                    if(res.data.success == true){
                        Toast.fire({
                            icon: 'success',
                            title: 'admin updated successfully'
                        })
                        this.$router.push({name : 'adminsList'})

                    }else if(res.data.success == false) {

                        this.error = res.data.message
                    }

                })
                .catch(err => {
                    console.log(err)
                })

        }
    },

    watch:{


        $route(to,from){

            if(to.name == 'addAdmin'){
                   this.edit = false
                    this.adminData.id  =  ''
                    this.adminData.name  =  ''
                    this.adminData.user_name  =  ''
                    this.adminData.email  =  ''
                    this.adminData.phone  =  ''
                    this.adminData.password  =  ''
                    this.adminData.confirm_password  =  ''
                    this.adminData.roles  =   []
                   this.adminData.file  =   []
                   this.adminData.isActive  =   ''
            }

        }

    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
