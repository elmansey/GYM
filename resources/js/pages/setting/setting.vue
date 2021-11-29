<template>
    <div  v-if="isLoading">
        <Breadcrumbs main="dashboard" title="setting"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                        <form @submit.prevent="handeleSettingFormSubmit">
                                            <div class="row">
                                                    <div class="col-lg-6">
                                                                <label class="card-title">Gym name</label>
                                                                <input class="form-control"  style="background-color:#F6F6F6;width:100%;border: none;" v-model="setting.Gym_name"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                                <label class="card-title">Gym title</label>
                                                                <input class="form-control"  style="background-color:#F6F6F6;width:100%;border: none;" v-model="setting.Gym_title"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                                <label class="card-title">owner name</label>
                                                                <input class="form-control"  style="background-color:#F6F6F6;width:100%;border: none;" v-model="setting.owner_name"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                                <label class="card-title">email</label>
                                                                <input class="form-control"  style="background-color:#F6F6F6;width:100%;border: none;" v-model="setting.email"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                                <label class="card-title">phone</label>
                                                                <input class="form-control"  style="background-color:#F6F6F6;width:100%;border: none;" v-model="setting.phone"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                                <label class="card-title">address</label>
                                                                <input class="form-control"  style="background-color:#F6F6F6;width:100%;border: none;" v-model="setting.address"/>
                                                    </div>
                                                    <div class="col-lg-6" style="width: 100px;height: 100px;">
                                                        <label class="card-title">logo</label>

                                                                <img  style="width: 120px;height: 120px;margin-top:5px" :src="'../../app_setting/'+setting.logo" />

                                                    </div>

                                                    <div class="mb-2 col-md-12 col-lg-12 col-sm-12" style="margin-top: 50px;">

                                                                <vue-dropzone
                                                                    name="file"
                                                                    ref="myVueDropzone"
                                                                    id="singledropzone"
                                                                    :options="singledropzoneOptions"
                                                                    :class="['dropzone digits']"
                                                                    @vdropzone-file-added="handleFileAdded"
                                                                    @vdropzone-removed-file="removed"

                                                                >
                                                                </vue-dropzone>

                                                    </div>


                                                    <div class="col-md-12">

                                                            <label class="card-title">about us</label>
                                                            <vue-editor v-model="setting.about_us" ></vue-editor>

                                                    </div>


                                                    <div style="margin: 30px;">
                                                        <button class="btn btn-primary" type="submit"  >save</button>
                                                    </div>


                                            </div>
                                        </form>
                                </div>
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
import axios from 'axios'
import { VueEditor } from "vue2-editor";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
    data(){
        return{

            setting:{
                Gym_name:'',
                Gym_title:'',
                owner_name:'',
                email:'',
                phone:'',
                address:'',
                about_us:'',
                logo:'',
                file:[]
            },

            error:'',
            edit:true,
            isLoading : false,
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
                    "<i class='icon-cloud-up'></i><br />Select application logo",
            },


        }
    },

    beforeCreate(){

        axios.get('allSetting')
        .then(res => {
            if(res.data.success){
                     this.setting.Gym_name = res.data.setting.setting.Gym_name
                     this.setting.Gym_title = res.data.setting.setting.Gym_title
                     this.setting.owner_name = res.data.setting.setting.owner_name
                     this.setting.email = res.data.setting.setting.email
                     this.setting.phone = res.data.setting.setting.phone
                     this.setting.address = res.data.setting.setting.address
                     this.setting.logo = res.data.setting.setting.logo
                     this.setting.about_us = res.data.setting.setting.about_us
                     this.isLoading = true
            }

        })
        .catch(err => {

        })

    },

      components: {
            VueEditor,
             vueDropzone: vue2Dropzone
        },


    beforeMount() {




    },


    methods: {

        handleFileAdded(file) {


            if (this.setting.file.length < 1) {
                this.setting.file = file;
            }

        },
        removed(files){

            if(files.name == this.setting.file.name){

                this.setting.file = []
            }
        },




        handeleSettingFormSubmit(){

            let formData = new FormData();

            formData.append('Gym_name',this.setting.Gym_name)
            formData.append('Gym_title',this.setting.Gym_title)
            formData.append('owner_name',this.setting.owner_name)
            formData.append('email',this.setting.email)
            formData.append('phone',this.setting.phone)
            formData.append('address',this.setting.address)
            formData.append('about_us',this.setting.about_us)
            formData.append('logo',this.setting.file)




            axios.post('editSetting',formData)
            .then(res => {
                if(res.data.success){

                        axios.get('allSetting')
                            .then(res => {
                                if(res.data.success){
                                        this.setting.Gym_name = res.data.setting.setting.Gym_name
                                        this.setting.Gym_title = res.data.setting.setting.Gym_title
                                        this.setting.owner_name = res.data.setting.setting.owner_name
                                        this.setting.email = res.data.setting.setting.email
                                        this.setting.phone = res.data.setting.setting.phone
                                        this.setting.address = res.data.setting.setting.address
                                        this.setting.logo = res.data.setting.setting.logo
                                        this.setting.about_us = res.data.setting.setting.about_us

                                        this.$store.dispatch('SETTINGS',res.data.setting.setting)

                                        this.isLoading = true
                                }

                            })
                            .catch(err => {

                            })

                        Toast.fire({
                            icon: 'success',
                            title: 'setting updated successfully'
                        })
                }
            })
            .catch(err => {
                console.error(err);
            })


        }




    },
    watch:{



    }
}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>





