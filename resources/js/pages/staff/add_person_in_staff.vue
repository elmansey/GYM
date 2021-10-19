<template>
    <div v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit person in  staff' : 'add person in staff'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="handelStaffFormSubmit" id="myform">

                                    <div class="row">

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">first name</div>

                                            <input name="firstName" :class="['form-control',error.firstName ? 'is-invalid' : '']"  v-model="StaffData.firstName"/>
                                            <small style="color: red" v-if="error.firstName">{{ error.firstName[0]}}</small>
                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">middle name</div>

                                            <input name="name" :class="['form-control',error.middleName ? 'is-invalid' : '']"  v-model="StaffData.middleName"/>
                                            <small style="color: red" v-if="error.middleName">{{ error.middleName[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">last name</div>

                                            <input name="lastName" :class="['form-control',error.lastName ? 'is-invalid' : '']"  v-model="StaffData.lastName"/>
                                            <small style="color: red" v-if="error.lastName">{{ error.lastName[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> email</div>

                                            <input name="email"  :class="['form-control',error.email ? 'is-invalid' : '']"  v-model="StaffData.email"/>
                                            <small style="color: red" v-if="error.email">{{ error.email[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> phone number</div>

                                            <input name="phone" :class="['form-control',error.phone ? 'is-invalid' : '']" v-model="StaffData.phone"/>
                                            <small style="color: red" v-if="error.phone">{{ error.phone[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> jop </div>

                                            <select name="jop" :class="['form-control',error.jop ? 'is-invalid' : '']" v-model="StaffData.jop">
                                                <option selected disabled readonly="">__choose__</option>
                                                <option value="worker">worker</option>
                                                <option value="Captain">Captain</option>
                                            </select>
                                            <small style="color: red" v-if="error.jop">{{ error.jop[0]}}</small>
                                        </div>


                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label"> notes </div>

                                            <textarea name="notes" :class="['form-control',error.notes ? 'is-invalid' : '']" v-model="StaffData.notes"></textarea>
                                            <small style="color: red" v-if="error.notes">{{ error.notes[0]}}</small>
                                        </div>
                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label"> Upload avatar </div>

                                                <vue-dropzone
                                                    name="avatar"
                                                    ref="myVueDropzone"
                                                    id="singledropzone"
                                                    :options="singledropzoneOptions"
                                                    :class="['dropzone digits',error.avatar ? 'is-invalid' : '']"
                                                    @vdropzone-file-added="handleFileAdded"
                                                    @vdropzone-removed-file="removed"

                                                >
                                                </vue-dropzone>

                                            <small style="color: red" v-if="error.avatar">{{ error.avatar[0]}}</small>
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


            StaffData:{
                firstName:'',
                middleName:'',
                lastName:'',
                email:'',
                phone:'',
                jop:'',
                notes:'',
                avatar:[]
            },
            isLoading:false,

            error:'',
            edit:true,


            singledropzoneOptions:{
                url:'http://127.0.0.1:8000/api/addInStaff',
                thumbnailWidth: 150,
                maxFiles:1,
                autoProcessQueue: false,
                maxFilesize: 2,
                acceptedFiles: ".jpg , .jpeg, .png",
                maxNumberOfFiles: 1,
                addRemoveLinks: true,
                dictDefaultMessage:
                    "<i class='icon-cloud-up'></i><br />Select avatar picture",
            },







        }
    },
    components: {

        vueDropzone: vue2Dropzone

    },

    beforeCreate() {

    },

    beforeMount() {

        if(this.$route.params.updateInStaffId){
            this.edit = true

            axios.get(`getItemFromStaffById/${this.$route.params.updateInStaffId}`)
            .then(res => {
                this.isLoading = true
                this.StaffData = res.data.staff
            })
            .catch(err => {

            })


        }else{
            this.edit = false
            this.isLoading = true
        }


    },



    methods: {


        handleFileAdded(file) {

            console.log(file);
            if (this.StaffData.avatar.length < 1) {
                this.StaffData.avatar = file;
            }

        },


        removed(files){

            if(files.name == this.StaffData.avatar.name){

                this.StaffData.avatar = []
            }
        },

        handelStaffFormSubmit(){

            let formData = new FormData()

            formData.append('firstName',this.StaffData.firstName)
            formData.append('middleName',this.StaffData.middleName)
            formData.append('lastName',this.StaffData.lastName)
            formData.append('email',this.StaffData.email)
            formData.append('phone',this.StaffData.phone)
            formData.append('jop',this.StaffData.jop)
            formData.append('notes',this.StaffData.notes)
            formData.append('avatar',this.StaffData.avatar)

            let config = {
                headers:{
                    "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                }
            }

            axios.post('addInStaff',formData,config)
            .then(res => {


                if(res.data.success == false){
                    this.error = res.data.message
                }

                if(res.data.success ){

                    Toast.fire({
                        icon: 'success',
                        title: 'new staff  created successfully'
                    })
                    this.$router.push({name:'staff'})

                }


                console.log(res)
            })
            .catch(err => {
                console.log(err)
            })





        }
    },

    watch:{


        $route(to,from){

            if(to.name == 'addInStaff'){
                this.edit = false
                this.isLoading = true

            }
        }


    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
