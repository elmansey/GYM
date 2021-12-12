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

                                                    v-model="product_name[index]"
                                                    :options="options"
                                                    :searchable="true"
                                                    :clearable="true"
                                                    :placeholder="$t('Search')"
                                                    label="name"
                                                    @input="getRecourdTotalAndUnitPrice(index)"
                                                   
                                                >
                                                <template v-slot:option="option"   >

                                                    <option  :disabled="IsSet(option.id)">{{ option.name }}</option>
                                                </template>
                                                </v-select>
                                            </b-form-group>

                                    <div  class="invalid-feedback"  ></div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="inputEmail4">{{  $t('product quantity')}}</label>
                                    <input   type="number" @input="getRecourdTotalAndUnitPrice(index)"  class="form-control"  style="margin-top: 12px;" v-model="product_quantity[index]"/>
                                    <div  class="invalid-feedback"  ></div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="inputEmail4">{{ $t('unit price')}}</label>
                                    <input type="text" readonly class="form-control" style="margin-top: 12px;"  v-model="unit_price[index]"/>
                                    <div  class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="inputEmail4">{{ $t('Total')}}</label>
                                    <input type="text"  readonly class="form-control" style="margin-top: 12px;" v-model="recourd_total[index]"/>
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


                                                <div class="order-box">
                                                    <div class="title-box">
                                                         <div class="checkbox-title">

                                                    </div>

                                                </div>

                                                <ul class="sub-total">
                                                    <li>
                                                        {{ $t('Subtotal')}}
                                                        <span class="count">LE {{  total  }}</span>
                                                    </li>
                                                </ul>

                                                <ul class="sub-total">
                                                    <li>
                                                        {{ $t('Total')}}
                                                        <span class="count">LE {{  total  }}</span>
                                                    </li>
                                                </ul>
                                        </div>
                                        <div>
                                            <button   @click.prevent="handelSaveInvoice" class="btn btn-primary" >{{  $t('Save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

                            </div>

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

                            </div>

                        </div>

                    </div>

                    <hr />

                    <div>
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

                                        <td class="Rate">
                                            <h6 class="p-2 mb-0">{{ $t('product quantity')}}</h6>
                                        </td>

                                        <td class="Rate">
                                            <h6 class="p-2 mb-0">{{ $t('total')}}</h6>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in  InvoiceAfterAdd.invoice_details" :key="index">
                                        <td class="item">
                                            <h6 class="p-2 mb-0">{{ item.product_name.name }}</h6>
                                        </td>
                                        <td class="Hours">
                                            <h6 class="p-2 mb-0">{{ (item.unit_price) }}</h6>
                                        </td>
                                        <td class="Hours">
                                            <h6 class="p-2 mb-0">{{ item.product_quantity }}</h6>
                                        </td>
                                        <td class="Rate">
                                            <h6 class="p-2 mb-0">{{ item.recourd_total }}</h6>
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

        <b-button class="mt-3 " id="printPageButton"   v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">{{ $t('Cancel')}}</b-button>
        <b-button class="mt-3 "   id="printPageButton2" v-b-modal.modal-sm variant="primary"  @click.prevent="printWindow">{{ $t('print')}}</b-button>
    </b-modal>




    </div>
</template>

<script>
import axios from 'axios'
import {required} from 'vuelidate/lib/validators'
  export default {

    data(){
      return {

          count:1,
          products:[],
          options:[],

          total:0,
        product_nameLength:'',
        product_name : [],
        product_quantity : [],
        unit_price : [],
        recourd_total : [],


          invoice:[],

          product_invoice:{
              saler:'',
              invoice_number:''

          },
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


    },
    computed: {
    
    },
    mounted() {

    },



    methods:{

        IsSet(id){

            if(this.product_name.length > 0){
                    
                    var ides = []

                    this.product_name.map((v,k) => {
                        if(v.id && v.id  != null){
                             ides.push(v.id)
                        }else{
                            return false
                        }


                    })
                    return  (ides.includes(id))
            }else{
                return false
            }
        },

        getRecourdTotalAndUnitPrice(index){

            // to dont write quitity < 1
            if(this.product_quantity[index] == '' || !this.product_quantity[index] || this.product_quantity[index] < 1){
                this.product_quantity[index]   = 1

            }

            if(this.product_name[index] == '' || this.product_name[index] == null || this.product_name[index] == undefined || !this.product_name[index]){
            
                 this.product_name.map((v,k) => {

                    if(k == index){
                       this.product_name.splice(k,1)
                    }     
                })

                this.product_quantity.map((v,k) => {

                    if(k == index){
                       this.product_quantity.splice(k,1)
                    }     
                })
                 this.recourd_total.map((v,k) => {

                    if(k == index){
                       this.recourd_total.splice(k,1)
                    }     
                })
                 this.unit_price.map((v,k) => {

                    if(k == index){
                       this.unit_price.splice(k,1)
                    }     
                })

                this.invoice.map((v,k) => {

                   
                    if(v.index == index){
                       this.invoice.splice(k,1)
                    }     
                })

                this.total = this.recourd_total.reduce(calcFunc)
                function calcFunc(a,b){
                            return a+b
                }


            }

            if(this.product_name[index]){

                var product_id  = this.product_name[index].id
                this.products.filter((item,key) => {

                    if(item.id == product_id){
                            var product_price =  item.product_price
                            this.unit_price[index] = product_price
                            if(this.product_quantity[index] == '' || !this.product_quantity[index] || this.product_quantity[index] < 1){
                               this.product_quantity[index]   = 1
                            }
                        }
                    })
            }

            if(this.product_quantity[index]){

                this.recourd_total[index] = (Number(this.unit_price[index]) * Number(this.product_quantity[index]))

            }

            if(this.product_quantity[index] && this.product_name[index]){

                    var recourd  = {'index':index,'product_name' : this.product_name[index] , 'unit_price' : this.unit_price[index] , 'product_quantity' : this.product_quantity[index],'recourd_total' : this.recourd_total[index]}
                    
                    
                        let indexes = []
                        this.invoice.map((v,k) => {
                           indexes.push(v.index)
                        })

                        let check = indexes.includes(index)
                        
                        if(check){
                            this.invoice.map((v,k) => {

                                if(v.index == index){
                                    v.product_quantity = Number(this.product_quantity[index])
                                    v.recourd_total = Number(this.recourd_total[index])   
                                }     
                            })
                             

                        }else{
                            this.invoice.push(recourd)
                        }
                
                             
            }        

                    this.total = this.recourd_total.reduce(calcFunc)
                    function calcFunc(a,b){
                            return a+b
                    }
                
            

        },

        handelRecourdData(){
            console.log(this.itemTake)
        },

        deleteRecourd(index){

                 var elem = document.getElementById(`recourd${index}`)
                elem.remove()

              
                this.product_name.map((v,k) => {

                    if(k == index){
                       this.product_name.splice(k,1)
                    }     
                })

                this.product_quantity.map((v,k) => {

                    if(k == index){
                       this.product_quantity.splice(k,1)
                    }     
                })
                 this.recourd_total.map((v,k) => {

                    if(k == index){
                       this.recourd_total.splice(k,1)
                    }     
                })
                 this.unit_price.map((v,k) => {

                    if(k == index){
                       this.unit_price.splice(k,1)
                    }     
                })

                this.invoice.map((v,k) => {

                   
                    if(v.index == index){
                       this.invoice.splice(k,1)
                    }     
                })
              
                this.total = this.recourd_total.reduce(calcFunc)
                    function calcFunc(a,b){
                            return a+b
                    }


        },
        addNewRecourd(){
            if(this.count >= 1 ){
                this.count++
            }
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

                if(this.product_name.length > 0){

                    let formData = new FormData();


                        formData.append('invoice_number',this.product_invoice.invoice_number)
                        formData.append('seller',this.product_invoice.saler)
                        formData.append('invoice_details',JSON.stringify(this.invoice))
                        formData.append('invoice_total',this.total)

                        axios.post('add_product_invoice',formData)
                        .then(res => {

                            if(res.data.success){
                                
                            this.InvoiceAfterAdd = res.data.product_invoice
                            this.$bvModal.show('bv-modal-example')

                            this.total = ''
                            this.product_invoice = {
                                saler:'',
                                invoice_number:''
                            }
                                this.product_name = []
                                this.product_quantity = []
                                this.unit_price = []
                                this.recourd_total = []
                                this.count = 1
                                this.invoice = []

                            this.product_invoice.saler = this.$store.getters.USER.id
                            var invoice_number = 'G'+ (Date.now());
                            this.product_invoice.invoice_number =  invoice_number

                            }



                        }).catch(err => {

                        })
                }else{
                    Toast.fire({
                          'title' : this.$t('There are empty fields'),
                          'icon' : 'error'
                    })
                }

            },

  },

  watch: {
       
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

