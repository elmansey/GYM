<template>
    <div class="container-fluid">
        <Breadcrumbs :main="$t('Dashboard')" :title="$t('add new Order')"/>

        <div class="card">
            <form>
                <div class="card-body">
                        <button  @click.prevent="addNewRecourd" class="btn btn-sm btn-dark" style="margin-bottom: 10px;">{{ $t("add record")}}</button>
                    <div class="row">

                        <div class="col-lg-12 col-sm-12"  v-for="(num,index) in count" :key="index" :id="`recourd${index}`">

                            <div class="form-row" >
                                <div class="form-group col-sm-3" >

                                    <label for="inputEmail4"> {{  $t('choose product')}}</label>
                                
                                            <b-form-group style="border:none;" class="has-float-label my-3 p-0">
                                                <v-select
                                                
                                                    v-model="itemTake.product_name[index]"
                                                    :options="options"
                                                    :searchable="true"
                                                    :clearable="true"
                                                    placeholder="Search"
                                                    label="name"
                                                   @input="getRecourdTotalAndUnitPrice(index)"
                                                    
                                                
                                                />
                                            </b-form-group>
                                
                                    <div  class="invalid-feedback"  ></div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="inputEmail4">{{  $t('product Quantity')}}</label>
                                    <input type="number" @input="getRecourdTotalAndUnitPrice(index)"  class="form-control"  style="margin-top: 12px;" v-model="itemTake.product_quantity[index]"/>
                                    <div  class="invalid-feedback"  ></div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="inputEmail4">{{ $t('unit price')}}</label>
                                    <input type="text" readonly class="form-control" style="margin-top: 12px;"  v-model="itemTake.unit_price[index]"/>
                                    <div  class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-sm-1">
                                    <label for="inputEmail4">{{ $t('Total')}}</label>
                                    <input type="text"  readonly class="form-control" style="margin-top: 12px;" v-model="itemTake.recourd_total[index]"/>
                                    <div  class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-sm-1">
                                
                                    
                                <feather v-if="index > 0" @click.prevent="deleteRecourd(index)" type="trash" style="cursor:pointer;margin-top: 45px;"></feather>
                                
                                </div>
                            </div>
                        </div>
                             


                            <div class="col-lg-12 col-sm-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="table-responsive invoice-table" id="table">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td class="item">
                                                                <h6 class="p-2 mb-0">{{ $t('product name')}} </h6>
                                                            </td>
                                                            <td>
                                                                <h6>{{ $t('unit price')}}</h6>
                                                            </td>
                                                             <td class="Hours">
                                                                 <h6 class="p-2 mb-0">{{ $t('product price')}}</h6>
                                                            </td>
                                                            <td class="Rate">
                                                                 <h6 class="p-2 mb-0">{{ $t('product quantity')}}</h6>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in  InvoiceAfterAdd.invoice_details" :key="index">
                                                            <td class="item">
                                                                 <h6 class="p-2 mb-0">{{ item.product_name }}</h6>
                                                            </td>

                                                            <td class="Hours">
                                                                <h6 class="p-2 mb-0">{{ (item.product_price / item.product_quantity) }}</h6>
                                                            </td>

                                                            <td class="Hours">
                                                                <h6 class="p-2 mb-0">{{ item.product_price }}</h6>
                                                            </td>

                                                            <td class="Rate">
                                                                <h6 class="p-2 mb-0">{{ item.product_quantity }}</h6>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="order-box">
                                                    <div class="title-box">
                                                         <div class="checkbox-title">

                                                    </div>

                                                </div>

                                                <ul class="sub-total">
                                                    <li>
                                                        {{ $t('Subtotal')}}
                                                        <span class="count">LE {{  InvoiceAfterAdd.invoice_total  }}</span>
                                                    </li>
                                                </ul>

                                                <ul class="sub-total">
                                                    <li>
                                                        {{ $t('Total')}}
                                                        <span class="count">LE {{  InvoiceAfterAdd.invoice_total  }}</span>
                                                    </li>
                                                </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>







            <!-- <div class="row" >
                <div class="col-lg-6">
                    <div class="card card-mb-faq">
                        <div class="card-header faq-header">

                        </div>
                            <div class="card-body faq-body"  style="height:500px;overflow: scroll;" >
                                        <div  class="row" >
                                            <div class="col-xl-6 col-md-6" style="height:85px"  v-for="(item,index) in products" :key="index" >
                                                <div class="prooduct-details-box"   >
                                                <div class="media" style="height: 80px">
                                                    <img  @click.prevent="takeItem(item)" class="align-self-center  " style="width: 60px!important; height: 60px;margin-left: 18px;" :src="'../../product_img/'+item.product_img" alt="#" />
                                                    <div class="media-body ml-3">
                                                    <div @click.prevent="takeItem(item)" class="product-name">
                                                        <h6><a href="#"> {{ $t('product name') }} :  {{ item.product_name }}</a></h6>
                                                    </div>
                                                    <div class="price d-flex">
                                                        <div @click.prevent="takeItem(item)" class="text-muted mr-2"></div> {{ $t('product price')}} :  {{ item.product_price }}
                                                    </div>

                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>



                                <b-modal id="bv-modal-example" size="lg"   hide-header hide-footer>
                                    <template #modal-title>

                                    </template>
                                <div class="d-block text-center" >

                                    <div class="invoice" id="invoice">
                                            <div>
                                            <div>
                                                <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="media">

                                                    <div class="media-body m-l-20">
                                                        <h4 class="media-heading" style="margin-top: 45px;">{{ $store.getters.SETTINGS.Gym_name }}</h4>

                                                        <p>
                                                            <span>
                                                            {{ $t('seller name :')}} {{  $store.getters.USER.name }} <br />
                                                            {{ $t('seller RF code :')}}  {{  $store.getters.USER.RF_code }}
                                                            </span>
                                                            </p>
                                                    </div>

                                                    </div>
                                                    <!-- End Info-->
                                                <!-- </div>
                                                <div class="col-sm-6">
                                                    <div class="text-md-right">
                                                    <h4>{{  $t('invoice number') }} </h4>
                                                    <P class="digits counter">{{ InvoiceAfterAdd.invoice_number}}</P>
                                                    <p>


                                                        {{  $t('date') }}:
                                                        <span class="digits"> <span class="digits">{{ InvoiceAfterAdd.date}}</span></span>
                                                        <br  />
                                                         {{ $t('time')}} :
                                                        <span class="digits"> <span class="digits">{{ InvoiceAfterAdd.time}}</span></span>
                                                    </p>
                                                    </div>
                                                    <!-- End Title-->
                                                <!-- </div>
                                                </div>
                                            </div>
                                            <hr /> -->
                                            <!-- End InvoiceTop-->

                                            <!-- End Invoice Mid-->
                                            <!-- <div>
                                            <div class="table-responsive invoice-table" id="table">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr >
                                                        <td class="item">
                                                        <h6 class="p-2 mb-0">{{ $t('product name')}} </h6>

                                                        </td>

                                                        <td>

                                                            <h6>{{ $t('unit price')}}</h6>

                                                        </td>
                                                        <td class="Hours">
                                                        <h6 class="p-2 mb-0">{{ $t('product price')}}</h6>
                                                        </td>
                                                        <td class="Rate">
                                                        <h6 class="p-2 mb-0">{{ $t('product quantity')}}</h6>
                                                        </td>


                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(item, index) in  InvoiceAfterAdd.invoice_details" :key="index">
                                                        <td class="item">
                                                        <h6 class="p-2 mb-0">{{ item.product_name }}</h6>

                                                        </td>
                                                        <td class="Hours">
                                                            <h6 class="p-2 mb-0">{{ (item.product_price / item.product_quantity) }}</h6>
                                                        </td>
                                                        <td class="Hours">
                                                        <h6 class="p-2 mb-0">{{ item.product_price }}</h6>
                                                        </td>
                                                        <td class="Rate">
                                                        <h6 class="p-2 mb-0">{{ item.product_quantity }}</h6>
                                                        </td>


                                                    </tr>

                                                    </tbody>
                                                </table>
                                                    <div class="order-box">
                                                    <div class="title-box">
                                                        <div class="checkbox-title">

                                                        </div>
                                                        </div>

                                                        <ul class="sub-total">
                                                            <li>
                                                            {{ $t('Subtotal')}}
                                                            <span class="count">LE {{  InvoiceAfterAdd.invoice_total  }}</span>
                                                            </li>
                                                        </ul>
                                                        <ul class="sub-total">
                                                            <li>
                                                            {{ $t('Total')}}
                                                            <span class="count">LE {{  InvoiceAfterAdd.invoice_total  }}</span>
                                                            </li>
                                                            </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- End InvoiceBot-->
                                            <!-- </div>
                                    </div>
                                </div>
                                    <b-button class="mt-3 " id="printPageButton"   v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">{{ $t('Cancel')}}</b-button>
                                    <b-button class="mt-3 "   id="printPageButton2" v-b-modal.modal-sm variant="primary"  @click.prevent="printWindow">{{ $t('print')}}</b-button>
                                </b-modal>
                            </div>
                </div>
                <div class="col-lg-6" >
                    <div class="card card-mb-faq">
                        <div class="card-header faq-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="media">

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                        </div>
                            <div class="card-body faq-body" style="height:500px;overflow: scroll;">


                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-row">

                                            <table class="table table-bordered table-striped" style="width:100%;margin-bottom: 145px;!important">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ $t('Product')}}</th>
                                                                    <th>{{ $t('unit price')}}</th>
                                                                    <th>{{ $t('Quantity')}}</th>
                                                                    <th>{{ $t('Total')}}</th>
                                                                    <th></th>
                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(item,index) in itemTake" :key="index">
                                                                    <td style="font-size:14px">{{  item.product_name }}</td>
                                                                    <td style="font-size:14px">{{    (item.product_price / item.product_quantity) }}</td>
                                                                    <td >
                                                                        <div style="text-align:center">
                                                                            <feather   type="chevron-left" @click.prevent="decrease(item)"  v-if=" item.product_quantity > 1" style="width: 13px;" ></feather>
                                                                            <i style="font-size:12px">{{  item.product_quantity }}</i>
                                                                            <feather  type="chevron-right"  @click.prevent="increase(item)"  style="width: 13px;"></feather>
                                                                        </div>



                                                                    </td>
                                                                    <td style="font-size:14px">{{  item.product_price }}</td>
                                                                    <td @click.prevent="removeItem(item,index)">
                                                                        <a href="javascript:void(0)" >
                                                                            <feather type="x-circle"></feather>
                                                                        </a>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                </table>

                                    </div>


                                </div>

                                <div class="col-lg-12 col-sm-12 " style="background-color:#F7F6F2;padding: 25px;">
                                    <div class="checkout-details">
                                        <div class="order-box">
                                            <div class="title-box">
                                                <div class="checkbox-title">

                                                </div>
                                                </div>

                                                <ul class="sub-total">
                                                    <li>
                                                    {{ $t('Subtotal')}}
                                                    <span class="count">LE {{  total }}</span>
                                                    </li>
                                                </ul>
                                                <ul class="sub-total">
                                                    <li>
                                                    {{ $t('Total')}}
                                                    <span class="count">LE {{  total }}</span>
                                                    </li>
                                                    </ul>
                                            </div>


                                    </div>
                                        <div>
                                        <button :disabled="CheckDiseble"  @click.prevent="handelSaveInvoice" class="btn btn-primary" >{{  $t('Save')}}</button>
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>
            </div>   -->



</template>

<script>
import axios from 'axios'

  export default {

    data(){
      return {

          count:1,
          products:[],
          options:[],
          total:'',
          itemTake:{
                product_name : [],
                product_quantity : [],
                unit_price : [],
                recourd_total : []
          },
          product_invoice:{
              saler:'',
              invoice_number:''

          },


          CheckDiseble:true,

          InvoiceAfterAdd:[]

      }
    },


    beforeMount() {



        axios.get('products')
        .then(res => {
            this.products = res.data.products
            res.data.products.map((item,index) => {
                this.options.push({'id':item.id,'name':item.product_name})
            })
        })
        .catch(err => {
            console.error(err);
        })



        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        this.product_invoice.date = date

        this.product_invoice.saler = this.$store.getters.USER.id

        var invoice_number = 'G'+ Date.now();
        this.product_invoice.invoice_number =  invoice_number

        this.CheckDiseble = (this.itemTake.length < 1)

    },
    computed: {

    },
    mounted() {

    },
    methods:{

        getRecourdTotalAndUnitPrice(index){

            
            if(this.itemTake.product_name[index]){

                var product_id  = this.itemTake.product_name[index].id
                this.products.filter((item,key) => {

                        if(item.id == product_id){
                            var product_price =  item.product_price
                            this.itemTake.unit_price[index] = product_price
                        }
                    })
               }

                if(this.itemTake.product_quantity[index]){

                   this.itemTake.recourd_total[index] = (Number(this.itemTake.unit_price[index]) * Number(this.itemTake.product_quantity[index]))

               }
        },



        handelRecourdData(){
            console.log(this.itemTake)
        },

        deleteRecourd(index){
            
                 var elem = document.getElementById(`recourd${index}`)
                elem.remove()
            
        },
        addNewRecourd(){
            if(this.count >= 1 ){
                this.count++
            }
        },

        removeItem(item,index){

            let ProductTotal = item.product_price
            this.itemTake.splice(index,1)

            this.total = this.total - ProductTotal
            this.CheckDiseble = (this.itemTake.length < 1)


        },

        printWindow() {


            printJS(
                    {
                        printable : 'invoice',
                        type : 'html',
                        honorColor: true,
                        targetStyles: ['*'],
                    }
                )

            this.InvoiceAfterAdd = []
            this.$bvModal.hide('bv-modal-example')


        },


            handelSaveInvoice(){


                let formData = new FormData();




                formData.append('invoice_number',this.product_invoice.invoice_number)
                formData.append('seller',this.product_invoice.saler)
                formData.append('invoice_details',JSON.stringify(this.itemTake))
                formData.append('invoice_total',this.total)

                axios.post('add_product_invoice',formData)
                .then(res => {

                    this.InvoiceAfterAdd = res.data.product_invoice
                    this.$bvModal.show('bv-modal-example')
                     this.itemTake = []
                     this.total = ''
                    this.product_invoice = {
                        saler:'',
                        invoice_number:''
                    }

                    this.product_invoice.saler = this.$store.getters.USER.id
                    var invoice_number = 'G'+ Date.now();
                    this.product_invoice.invoice_number =  invoice_number
                    this.CheckDiseble = (this.itemTake.length < 1)



                }).catch(err => {

                })




            },

              decrease(product){

                  let res = this.itemTake.map((element,index) => {

                       if(element.product_name == product.product_name){

                           element.product_price =  element.product_price -  (element.product_price / element.product_quantity)
                           element.product_quantity = element.product_quantity - 1


                         let total  = this.itemTake.map((element,index) => {return Number(element.product_price) })

                        let sum = 0;
                        for(var  i = 0 ; i < total.length ; i++){
                            sum += total[i]
                        }

                        this.total = sum

                       }

                      })
            },


              increase(product){

                  let res = this.itemTake.map((element,index) => {

                       if(element.product_name == product.product_name){

                           element.product_price =  Number(element.product_price) +  (element.product_price / element.product_quantity)
                           element.product_quantity = element.product_quantity + 1




                       }

                       let total  = this.itemTake.map((element,index) => {return Number(element.product_price) })

                        let sum = 0;
                        for(var  i = 0 ; i < total.length ; i++){
                            sum += total[i]
                        }

                        this.total = sum

                      })
            },

            takeItem(item){


                let res = this.itemTake.map((element,index) => {return element.product_name })
                let index =  res.indexOf(item.product_name)



                    // console.log(item)

                if(index > -1 ){

                    this.itemTake[index].product_quantity = this.itemTake[index].product_quantity + 1
                    this.itemTake[index].product_price = Number(this.itemTake[index].product_price) + Number(item.product_price)

                }else{


                    this.itemTake.push({
                        product_name : item.product_name ,
                        product_quantity : 1 ,
                        product_price : item.product_price,
                        product_id : item.id

                    })

                }

                this.CheckDiseble = (this.itemTake.length < 1)
                 let total  = this.itemTake.map((element,index) => {return Number(element.product_price) })

                let sum = 0;
                for(var  i = 0 ; i < total.length ; i++){
                    sum += total[i]
                }

                this.total = sum


            }
  },

  watch: {

       disable() {

            this.CheckDiseble = (this.itemTake.length < 1)
       }
  }

  }
</script>

<style >


@media print {
  #printPageButton {
    display: none!important;
  }

  #printPageButton2 {
    display: none!important;
  }


}
::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
};
</style>

