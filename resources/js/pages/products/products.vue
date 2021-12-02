


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="products" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">


                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="products"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                        <th>ID</th>
                                        <th sortKey="name">product name</th>
                                        <th sortKey="name" >product price</th>
                                        <th sortKey="name" >product img	</th>
                                        <th sortKey="name" >Production Date</th>
                                        <th sortKey="name" >Expiry date</th>
                                        <th sortKey="name" >Product Quantity</th>
                                        <th sortKey="options" >options</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td></td>
                                            <td>{{row.product_name}}</td>
                                            <td>{{row.product_price}}</td>
                                            <td><img  style="width:70px;height:70px" :src="'../../public/product_img/'+row.product_img"/></td>
                                            <td>{{row.Production_Date}}</td>
                                            <td>{{row.Expiry_date}}</td>
                                            <td>{{row.Product_Quantity}}</td>
                                            <td >
                                                 <div>
                                                    <b-button-group class="btn-group-pill" size="sm">

                                                         <b-button
                                                          variant="outline-dark"
                                                          >
                                                            <router-link
                                                                :to="{name: 'updateProduct', params: {productId : row.id}}"
                                                                v-if="can('edit-product')"
                                                            >
                                                               edit
                                                            </router-link>
                                                        </b-button>

                                                        <b-button

                                                            variant="outline-danger"

                                                            @click="DeleteProductModal(row.id,index)"
                                                            v-if="can('delete-product')"
                                                        >

                                                           delete
                                                        </b-button>
                                                    </b-button-group>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </v-table>
                                </div>

                                <div >
                                    <smart-pagination

                                        :currentPage.sync="filter.currentPage"
                                        :totalPages="filter.totalPages"
                                    />
                                </div>


                            </div>




                            <b-modal id="bv-modal-example" hide-footer>
                                <template #modal-title>
                                    Delete product
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to delete this product</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger" @click.prevent="deleteProduct" >delete</b-button>
                            </b-modal>



                        </div>

                    </div>
                </div>
            </div>
        </div>



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


export default {
    data() {
        return {
            products:[],

            filter: {
                currentPage: 1,
                totalPages: 0,
            },

            id:'',
            elkey:'',
            isLoadig:false


        };
    },
    beforeMount() {

        axios.get('products')
            .then(res => {
                this.products = res.data.products
                this.isLoadig  = true
            })
            .then(err => {

            })





    },
    mounted() {


    },
    methods: {


        DeleteProductModal(id,key){
            this.id = id
            this.elkey  = key
            this.$bvModal.show('bv-modal-example')
        },

        deleteProduct(){

            axios.get(`deleteProduct/${this.id}`)
                .then(res => {

                    if(res.data.success){

                        this.products.splice(this.elkey,1)
                        this.id = ''
                        this.elkey = ''
                        Toast.fire({
                            icon: 'success',
                            title: 'product deleted successfully'
                        })

                        this.$bvModal.hide('bv-modal-example')
                    }


                })
                .catch(err => {

                })
        }

    }
}

</script>
<style lang="scss">
.btn-container {
    .btn-child {
        padding: 0.2rem 0.8rem !important;
    }
}
.custom-color {
    color: inherit;
    padding: 0;
    margin: 0;
    border-radius: 0;
    margin-left: -1px;
    &:hover {
        color: inherit;
    }
}
</style>
