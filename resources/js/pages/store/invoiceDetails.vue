<template>
  <div v-if="isLoading">
    <Breadcrumbs main="Dashboard" title="Invoice details" />
    <!-- Container-fluid starts-->
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="invoice">
                <div>
                  <div>
                    <div class="row">
                      <div class="col-sm-6">

                          <h3>  seller # </h3>
                            <p>
                            <span>
                             name : {{ invoice.seller_relation.name }} <br />
                            RF code :  {{ invoice.seller_relation.RF_code }}
                            </span>
                            </p>

                      </div>
                      <div class="col-sm-6">
                        <div class="text-md-right">
                          <h2> Invoice number #  </h2>
                           <h4 class="digits counter">{{ invoice.invoice_number  }}</h4>

                          <p>
                            date:
                            <span class="digits">{{ invoice.date }}</span>
                            <br />time:
                            <span class="digits">{{  invoice.time }}</span>
                          </p>


                        </div>
                        <!-- End Title-->
                      </div>
                    </div>
                  </div>
                  <hr />
                  <!-- End InvoiceTop-->
                  <div class="row">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-8">

                    </div>
                  </div>
                  <!-- End Invoice Mid-->
                  <div>
                    <div class="table-responsive invoice-table" id="table">
                      <table class="table table-bordered table-striped">
                        <tbody>

                          <tr>
                            <td class="Hours">
                              <h6 class="p-2 mb-0">product name</h6>
                            </td>
                            <td class="Rate">
                              <h6 class="p-2 mb-0">unit price </h6>
                            </td>

                            <td class="Rate">
                              <h6 class="p-2 mb-0">product quantity </h6>
                            </td>
                            <td class="subtotal">
                              <h6 class="p-2 mb-0">products price</h6>
                            </td>
                          </tr>

                          <tr v-for="(item,index) in invoice.invoice_details" :key="index">

                            <td>
                              <p class="m-0" >
                                  {{ item.product_name }}
                              </p>
                            </td>

                            <td>
                              <p class="m-0" >
                                  {{ Number(item.product_price) /  Number(item.product_quantity)}}
                              </p>
                            </td>

                            <td>
                              <p class="itemtext digits">{{ item.product_quantity}}</p>
                            </td>
                             <td>
                              <p class="itemtext digits">{{ item.product_price}}</p>
                            </td>

                          </tr>





                          <tr>
                            <td></td>
                            <td></td>
                            <td class="Rate">
                              <h6 class="mb-0 p-2"><b>Total</b></h6>
                            </td>
                            <td class="payment digits">
                              <h6 class="mb-0 p-2"><b>{{ invoice.invoice_total }}</b></h6>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>
                  <!-- End InvoiceBot-->
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

import axios from "axios"

export default {
    data() {

        return{

            invoice:[],
            isLoading:false

        }
    },

    beforeMount(){
        if(this.$route.params.invoiceId){

            axios.get(`getInvoiceById/${this.$route.params.invoiceId}`)
            .then(res => {

                this.invoice = res.data.invoice
                this.isLoading = true

            }).catch(err => {


            })

        }
    }
}
</script>
