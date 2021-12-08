<template>

    <div v-if="isLoadig">

        <Breadcrumbs :main="$t('Dashboard')" :title="$t('Invoice Archive')" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">


                                <div class="datatable-vue m-0">
                                                    <div class="table-responsive vue-smart">
                                                        <b-table
                                                            id="tablePrint"
                                                            show-empty
                                                            stacked="md"
                                                            :items="product_invoices_archived"
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

                                                        <template #cell(archived_at)="data">

                                                                <span  class="badge-dark badge-pill" >{{    handelDate(data.item.deleted_at) }}</span>
                                                        </template>

                                                        <template #cell(action)="data">
                                                               <div class="col-xl-4 col-md-6 col-sm-12">
                                                                    <b-button-group  size="sm" class="btn-group-pill">
                                                                        <b-button variant="outline-danger"  @click="deleteInvoiceModel(data.item.id,data.index)">{{ $t('delete')}}</b-button>
                                                                        <b-button variant="outline-success"  @click="restoreInvoiceInvoiceModel(data.item.id,data.index)">{{ $t('restore')}}</b-button>
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





                            <b-modal id="invoiceModel2" hide-footer>
                                <template #modal-title>
                                    {{ $t('Delete invoice')}}
                                </template>
                                <div class="d-block text-center">
                                    <h5>{{ $t('are you sure to delete this invoice') }}</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('invoiceModel2')">{{  $t('Cancel')}}</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger" @click="deletInvoice()"  >{{  $t('delete')}}</b-button>
                            </b-modal>

                            <b-modal id="restoreModel" hide-footer>
                                <template #modal-title>
                                    {{  $t('restore invoice')}}
                                </template>
                                <div class="d-block text-center">
                                    <h5>{{  $t('are you sure to restore this invoice ')}}</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('invoiceModel')">{{  $t('Cancel')}}</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="success" @click="restoreInvoice()"  >{{  $t('restore')}}</b-button>
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
            id2:'',
            key2:'',
            product_invoices_archived:[],
            isLoadig:false,
            tablefields: [

            
                {'id' : this.$t('id')},
                { key: 'invoice_number', label: this.$t('invoice number'), sortable: false, },
                { key: 'seller_relation.name', label: this.$t('seller'), sortable: false, },
                {'invoice_details' : this.$t('invoice details')},
                { key: 'invoice_total', label: this.$t('invoice total'), sortable: false, },
                { key: 'date', label: this.$t('date'), sortable: false, },
                { key: 'time', label: this.$t('time'), sortable: false, },
                {'actiarchived_at' : this.$t("archived at")},
                {'action' : this.$t("action")}



            ],
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [5, 10, 15],

        }
    },



    beforeMount() {

        axios.get('product_invoicesOnlyArchived')
            .then(res => {
                this.product_invoices_archived = res.data.product_invoices_archived
                this.totalRows = this.product_invoices_archived.length
                this.isLoadig = true
            })
            .catch(err => {

            })
    },


    methods: {


        handelDate(date){

            var da = new Date(date)
            return da.getFullYear() +'-'+(da.getMonth()+1) + '-' + da.getDate()


        },
        restoreInvoice(){

             axios.get(`restoreInvoiceInvoice/${this.id2}`)
            .then(res => {

                if(res.data.success){

                    this.product_invoices_archived.splice(this.key2,1)
                    this.id2 = ''
                    this.key2 = ''
                    this.$bvModal.hide('restoreModel')
                    Toast.fire({
                        'title' : this.$t('invoice restored successfully'),
                          'icon' : 'success'
                    })
                }
            })
            .catch(err => {

            })

        },

        deleteInvoiceModel(id,index){
            this.id2 = id
            this.key2 = index
            this.$bvModal.show('invoiceModel2')

        },

        restoreInvoiceInvoiceModel(id,index){
            this.id2 = id
            this.key2 = index
            this.$bvModal.show('restoreModel')

        },

        deletInvoice(){
            axios.get(`deleteThisInvoice/${this.id2}`)
            .then(res => {

                if(res.data.success){

                    this.product_invoices_archived.splice(this.key2,1)
                    this.id2 = ''
                    this.key2 = ''
                    this.$bvModal.hide('invoiceModel2')
                    Toast.fire({
                        'title' : this.$t('invoice delete successfully'),
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
