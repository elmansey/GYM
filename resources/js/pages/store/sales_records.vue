<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="product invoices" />
            <div class="" style="display:flex;margin-left: 100px;margin-bottom: 30px;">
                <div class="">
                    <export-excel class="btn btn-light btn-sm  border-1"  :data   = "json_data" :fields = "json_fields" worksheet = "My Worksheet"   name = "test.xls" >
                         excel
                    </export-excel>
                </div>
                <div class="">
                        <button class="btn btn-light btn-sm border-1 " @click="printNow">print</button>
                </div>
            </div>



        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="datatable-vue m-0">
                                                    <div class="table-responsive vue-smart">
                                                        <b-table
                                                            id="invoiceTable"
                                                            show-empty
                                                            stacked="md"
                                                            :items="product_invoices"
                                                            :fields="tablefields"
                                                            :current-page="currentPage"
                                                            :per-page="perPage"


                                                        >



                                                        <template #cell(ID)="data">
                                                                {{ ++data.index }}
                                                        </template>

                                                        <template #cell(invoice_details)="data">

                                                                <span style="cursor: pointer" class="badge-primary badge-pill" @click="showDetails(data.item.id)">details</span>
                                                        </template>

                                                        <template #cell(action)="data" >
                                                               <div class="col-xl-4 col-md-6 col-sm-12 " >
                                                                    <b-button-group  size="sm" class="btn-group-pill">
                                                                        <b-button variant="outline-danger" id="PageButton1"  @click="deleteInvoiceModel(data.item.id,data.index)">delete</b-button>
                                                                        <b-button variant="outline-dark"  id="PageButton2" @click="archiveInvoiceModel(data.item.id,data.index)">archive</b-button>
                                                                    </b-button-group>
                                                                </div>
                                                        </template>

                                                        <!-- <template #cell(check)="data">
                                                                <input  type="checkbox" :value="data.item.id" v-model="selected" />
                                                        </template> -->


                                                        </b-table>
                                                    </div>

                                                <b-col md="6" class="my-1">
                                                        <b-pagination
                                                        v-model="currentPage"
                                                        :total-rows="totalRows"
                                                        :per-page="perPage"
                                                        class="my-0"
                                                        ></b-pagination>
                                                    </b-col>


                                </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>





                            <b-modal id="invoiceModel" hide-footer>
                                <template #modal-title>
                                    Delete invoice
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to delete this invoice</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('invoiceModel')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger" @click="deletInvoice()"  >delete</b-button>
                            </b-modal>

                            <b-modal id="archiveModel" hide-footer>
                                <template #modal-title>
                                    archive invoice
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to archive this invoice</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('invoiceModel')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="primary" @click="archiveInvoice()"  >archive</b-button>
                            </b-modal>






    </div>

     <div v-else class="col-md-3" style="margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);">
        <h6 class="sub-title mb-0 text-center"></h6>
        <div class="loader-box" >
            <div class="loader-3"></div>
        </div>
    </div>




</template>

<script>
import axios from "axios";


export default{
    data() {

        return{


            json_fields: {
                'invoice_number': 'invoice_number',
                'invoice_total': 'invoice_total',
                'date': 'date',
                'time': 'time',
                'seller': 'seller_relation.name',
             },

            json_data: [],
            json_meta: [
                [
                    {
                        'key': 'charset',
                        'value': 'utf-8'
                    }
                ]
            ],


            id:'',
            key:'',
            product_invoices:[],
            isLoadig:false,
            tablefields: [

                'ID',
                { key: 'invoice_number', label: 'invoice_number', sortable: false, },
                { key: 'seller_relation.name', label: 'seller', sortable: false, },
                'invoice_details',
                { key: 'invoice_total', label: 'invoice total', sortable: false, },
                { key: 'date', label: 'date', sortable: false, },
                { key: 'time', label: 'time', sortable: false, },
                'action'


            ],
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [5, 10, 15],

        }
    },



    beforeMount() {

        axios.get('product_invoices')
            .then(res => {
                this.product_invoices = res.data.product_invoices
                this.json_data = res.data.product_invoices
                this.totalRows = this.product_invoices.length
                this.isLoadig = true
            })
            .catch(err => {

            })

    },





    methods: {

        printNow(){

             printJS(
                     {
                        printable : 'invoiceTable',
                        type : 'html',
                        
                            honorColor: true,
                            targetStyles: ['*'],
                            ignoreElements:['PageButton1','PageButton2']
                    }
                )
        },


        archiveInvoice(){

             axios.get(`archivedThisInvoice/${this.id}`)
            .then(res => {

                if(res.data.success){

                    this.product_invoices.splice(this.key,1)
                    this.id = ''
                    this.key = ''
                    this.$bvModal.hide('archiveModel')
                    Toast.fire({
                        'title' : 'invoice archived successfully ',
                          'icon' : 'success'
                    })
                }
            })
            .catch(err => {

            })

        },

        deleteInvoiceModel(id,index){
            this.id = id
            this.key = index
            this.$bvModal.show('invoiceModel')

        },

        archiveInvoiceModel(id,index){
            this.id = id
            this.key = index
            this.$bvModal.show('archiveModel')

        },

        deletInvoice(){
            axios.get(`deleteThisInvoice/${this.id}`)
            .then(res => {

                if(res.data.success){

                    this.product_invoices.splice(this.key,1)
                    this.id = ''
                    this.key = ''
                    this.$bvModal.hide('invoiceModel')
                    Toast.fire({
                        'title' : 'invoice delete successfully ',
                          'icon' : 'success'
                    })
                }
            })
            .catch(err => {

            })
        },



        showDetails(id){


            this.$router.push({name : 'invoiceDetails' , params : {invoiceId : id}})


        }
    }
}
</script>

<style >


@media print {
  #PageButton {
    display: none!important;
  }



}

</style>

