<template>
    <div v-if="isLoading">
        <Breadcrumbs main="dashboard" title="registeration a new member"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="" id="myform">

                                    <div class="row">


                                            <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">personal information</div><br/>
                                            <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <div class="col-form-label">first name</div>

                                                <input name="name" class="form-control"  />
                                                <small style="color: red" ></small>
                                            </div>

                                            <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <div class="col-form-label">middle name</div>

                                                <input name="name" class="form-control"  />
                                                <small style="color: red" ></small>
                                            </div>
                                            <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <div class="col-form-label">last name</div>

                                                <input name="name" class="form-control"  />
                                                <small style="color: red" ></small>
                                            </div>

                                            <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <div class="col-form-label"> Gender</div>

                                                <select name="gender"  class="form-control"  >
                                                    <option selected readonly disabled>__choose__</option>
                                                    <option value="Male">Male</option>
                                                    <option value="female">female </option>
                                                </select>
                                                <small style="color: red"></small>
                                            </div>

                                            <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <div class="col-form-label"> Date of birth </div>

                                                <input name="phone" type="date"  class="form-control" />
                                                <small style="color: red" ></small>
                                            </div>


                                            <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <div class="col-form-label"> Group</div>

                                                <select name="group"  class="form-control"  ></select>
                                                <small style="color: red" ></small>
                                            </div>



                                        <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">contact information</div><br/>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> address </div>

                                            <input name="confirm_password" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> City </div>

                                            <input name="city"  class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> phone number  </div>

                                            <input name="confirm_password" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">  email  </div>

                                            <input name="confirm_password" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>



                                        <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">login information</div><br/>

                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">  user name  </div>

                                            <input name="confirm_password" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>



                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">  password  </div>

                                            <input name="confirm_password" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label"> Confirm password  </div>

                                            <input name="confirm_password" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label"> Upload profile picture</div>

                                            <div class="card-body">
                                                <vue-dropzone
                                                    name="file"
                                                    ref="myVueDropzone"
                                                    id="singledropzone"
                                                    :options="singledropzoneOptions"
                                                    class="dropzone digits"

                                                >
                                                </vue-dropzone>
                                            </div>

                                            <small style="color: red" ></small>
                                        </div>


                                        <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">extra information</div><br/>



                                        <div class="mb-2 col-md-12 col-lg-6 col-sm-12">
                                            <div class="col-form-label">  interested area  </div>

                                           <textarea style="width: 100%"  class="form-control"></textarea>
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-12 col-lg-6 col-sm-12">
                                            <div class="col-form-label">  source </div>

                                            <textarea style="width: 100%" class="form-control"></textarea>
                                            <small style="color: red" ></small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   membership  </div>

                                            <select name="membership"  class="form-control"  ></select>
                                            <small style="color: red" ></small>
                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   start data  </div>

                                            <input name="" type="date" class="form-control"  />
                                            <small style="color: red" ></small>
                                        </div>





                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
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
    </div>
        <!-- Container-fluid Ends-->


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
            memberData:{

            },
            isLoading:true,

            options: [],
            error:'',
            edit:false,


            singledropzoneOptions:{
                url:'http://127.0.0.1:8000/api/',
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
        vueDropzone: vue2Dropzone

    },

    beforeCreate() {


    },

    beforeMount() {



    },



    methods: {




    },

    watch:{



    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
