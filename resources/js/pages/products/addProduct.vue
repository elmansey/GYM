<template>
    <div  v-if="isLoading">
        <Breadcrumbs :main="$t('Dashboard')" :title="edit ?  $t('edit product') :  $t('add product')"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">


                                <form @submit.prevent="handelSubmitProductForm" id="form">

                                    <div class="row">
                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">{{ $t('product name')}}</div>

                                            <input name="name" v-model="product_info.product_name" :class="['form-control',error.product_name ? 'is-invalid' : '']"  :placeholder=" $t('product name')"/>
                                            <small style="color: red"  v-if="error.product_name">{{ $t(error.product_name[0])}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">{{ $t('product price')}}</div>

                                            <input name="product_price" type="number" v-model="product_info.product_price" :class="['form-control',error.product_price ? 'is-invalid' : '']"  :placeholder=" $t('product price')"/>
                                            <small style="color: red"  v-if="error.product_price">{{ $t(error.product_price[0])}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                            <div class="col-form-label">{{ $t('Product Quantity')}}</div>

                                            <input name="product_quantity" type="number"  v-model="product_info.product_quantity" :class="['form-control',error.Product_Quantity ? 'is-invalid' : '']"  :placeholder=" $t('Product Quantity')"/>
                                            <small style="color: red"  v-if="error.Product_Quantity">{{$t(error.Product_Quantity[0])}}</small>
                                        </div>

                                             <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                  <div class="col-form-label"> {{ $t('Upload product img')}}</div>


                                                      <vue-dropzone
                                                          name="file"
                                                          ref="myVueDropzone"
                                                          id="singledropzone"
                                                          :options="singledropzoneOptions"
                                                          :class="['dropzone digits',error.product_img ? 'is-invalid' : '']"
                                                          @vdropzone-file-added="handleFileAdded"
                                                          @vdropzone-removed-file="removed"

                                                      >
                                                      </vue-dropzone>


                                                  <small style="color: red" v-if="error.product_img">{{  $t(error.product_img[0])}}</small>
                                              </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">{{ $t('Production Date')}}</div>

                                            <input name="Production_Date" type="date" v-model="product_info.Production_Date" :class="['form-control',error.Production_Date ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.Production_Date">{{$t(error.Production_Date[0])}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">{{ $t('Expiry date')}}</div>
                                            <input name="Expiry_date" type="date"  v-model="product_info.Expiry_date" :class="['form-control',error.Expiry_date ? 'is-invalid' : '']"  />
                                            <small style="color: red"  v-if="error.Expiry_date">{{ $t(error.Expiry_date[0])}}</small>
                                        </div>




                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3" v-if="!edit" >
                                        {{ $t('Save')}}
                                    </button>
                                    <button type="submit" class="btn btn-success mt-3" v-if="edit" >
                                        {{ $t('update')}}
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
                    product_img:[]
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
            edit:true,
            isLoading : true


        }
    },

    beforeCreate(){



    },


    beforeMount() {

        if(this.$route.params.productId){

            this.edit = true

            axios.get(`getProductById/${this.$route.params.productId}`)
            .then(res => {

               if(res.data.success){

                     this.product_info.product_name = res.data.product.product_name ,
                     this.product_info.product_price  =  res.data.product.product_price,
                     this.product_info.product_quantity  =  res.data.product.Product_Quantity,
                     this.product_info.Production_Date  =  res.data.product.Production_Date,
                     this.product_info.Expiry_date  =  res.data.product.Expiry_date

               }

            })
            .catch(err => {
                console.error(err);
            })

        }else{
            this.edit = false
        }


    },
     components: {

        vueDropzone: vue2Dropzone

    },


    methods: {



        handelSubmitProductForm(){


            if(this.edit == false){

                      let formData = new FormData();


                        formData.append('product_name' , this.product_info.product_name)
                        formData.append('product_price' , this.product_info.product_price)
                        formData.append('Product_Quantity' , this.product_info.product_quantity)
                        formData.append('Production_Date' , this.product_info.Production_Date)
                        formData.append('Expiry_date' , this.product_info.Expiry_date)
                        formData.append('product_img' , this.product_info.product_img)


                        let config = {
                            headers:{
                                "Content-Type":"multipart/form-data; charset=utf-8; boundary="
                                + Math.random().toString().substr(2),
                            }
                        }


                        axios.post('add_product',formData,config)
                        .then(res => {

                            if(res.data.success){
                                this.error = ''
                                this.product_info = {
                                product_name:'',
                                product_price:'',
                                product_quantity:'',
                                Production_Date:'',
                                Expiry_date:'',
                                product_img:[]
                            },
                                Toast.fire({
                                    icon: 'success',
                                    title: this.$t('product added successfully')
                                })
                                this.$router.push({name : 'products'})

                            }else if(res.data.success == false){

                                this.error = res.data.message
                            }
                        })
                        .catch(err => {
                            console.error(err);
                        })
            }else if(this.edit){

                    let formData = new FormData();

                    formData.append('product_name' , this.product_info.product_name)
                    formData.append('product_price' , this.product_info.product_price)
                    formData.append('Product_Quantity' , this.product_info.product_quantity)
                    formData.append('Production_Date' , this.product_info.Production_Date)
                    formData.append('Expiry_date' , this.product_info.Expiry_date)
                    formData.append('product_img' , this.product_info.product_img)


                    let config = {
                        headers:{
                            "Content-Type":"multipart/form-data; charset=utf-8; boundary="
                            + Math.random().toString().substr(2),
                        }
                    }


                    axios.post(`edit_product/${this.$route.params.productId}`,formData,config)
                    .then(res => {

                        if(res.data.success){
                            this.error = ''
                            Toast.fire({
                                icon: 'success',
                                title: this.$t('product updated successfully')
                            })
                                this.$router.push({name : 'products'})

                        }else if(res.data.success == false){

                            this.error = res.data.message
                        }
                    })
                    .catch(err => {
                        console.error(err);
                    })

            }


        },

        handleFileAdded(file) {

            console.log(file);
            if (this.product_info.product_img.length < 1) {
                this.product_info.product_img = file;
            }

        },
        removed(files){

            if(files.name == this.product_info.product_img.name){

                this.product_info.product_img = []
            }
        },



    },
    watch:{

        $route(to,from){

            if(to.name == 'addProduct'){
                this.edit =false
                 this.product_info = {
                    product_name:'',
                    product_price:'',
                    product_quantity:'',
                    Production_Date:'',
                    Expiry_date:'',
                    product_img:[]
                }
            }
        }

    }
}
</script>
<style>

</style>




