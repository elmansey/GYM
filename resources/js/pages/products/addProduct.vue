<template>
    <div  v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit product' : 'add product'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">


                                <form @submit.prevent="" id="form">

                                    <div class="row">
                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">product name</div>

                                            <input name="name" v-model="product_info.product_name" :class="['form-control',error.product_name ? 'is-invalid' : '']"  placeholder="product name"/>
                                            <small style="color: red"  v-if="error.product_name">{{error.product_name[0]}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">product price</div>

                                            <input name="product_price" type="number" v-model="product_info.product_price" :class="['form-control',error.product_price ? 'is-invalid' : '']"  placeholder="product price"/>
                                            <small style="color: red"  v-if="error.product_price">{{error.product_price[0]}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">Product Quantity</div>

                                            <input name="product_quantity" type="number"  v-model="product_info.product_quantity" :class="['form-control',error.product_quantity ? 'is-invalid' : '']"  placeholder="product Quantity"/>
                                            <small style="color: red"  v-if="error.name">{{error.product_quantity[0]}}</small>
                                        </div>

                                             <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                  <div class="col-form-label"> Upload product img</div>


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


                                                  <small style="color: red" v-if="error.product_img">{{ error.product_img[0]}}</small>
                                              </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">Production Date</div>

                                            <input name="Production_Date" type="date" v-model="product_info.Production_Date" :class="['form-control',error.Production_Date ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.Production_Date">{{error.Production_Date[0]}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">Expiry date</div>
                                            <input name="Expiry_date" type="date"  v-model="product_info.Expiry_date" :class="['form-control',error.Expiry_date ? 'is-invalid' : '']"  />
                                            <small style="color: red"  v-if="error.Expiry_date">{{error.Expiry_date[0]}}</small>
                                        </div>




                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3" v-if="!edit" >
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-success mt-3" v-if="edit" >
                                        update
                                    </button>

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
import axios from 'axios'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
    data(){
        return{

                product_info:{
                    product_name:'',
                    product_price:'',
                    product_quantity:'',
                    Production_Date:'',
                    Expiry_date:'',
                    img:[]
                },

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

            error:'',
            edit:false,
            isLoading : true


        }
    },

    beforeCreate(){



    },


    beforeMount() {



    },
     components: {

        vueDropzone: vue2Dropzone

    },


    methods: {

        handleFileAdded(file) {

            console.log(file);
            if (this.product_info.img.length < 1) {
                this.product_info.img = file;
            }

        },
        removed(files){

            if(files.name == this.product_info.img.name){

                this.product_info.img = []
            }
        },



    },
    watch:{



    }
}
</script>
<style>

</style>




