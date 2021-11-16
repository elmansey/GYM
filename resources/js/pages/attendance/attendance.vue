


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="attendance table" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">


                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="attendance"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                            <th>ID</th>
                                            <td>name</td>
                                            <td>attendance date</td>
                                            <td>attendance time</td>
                                            <td> status</td>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td>{{ ++index}}</td>
                                            <td>{{ row.userRelation.name }}</td>
                                            <td>{{  row.date }} </td>
                                            <td>{{ row.time }} </td>
                                            <td> <feather type="check-circle"></feather></td>

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
                                    Delete Role
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to delete this group</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger"  >delete</b-button>
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
            attendance:[],

            filter: {
                currentPage: 1,
                totalPages: 0,
            },


            isLoadig:true


        };
    },
    beforeMount() {



        axios.get('attendance')
        .then(res => {
            this.attendance = res.data.attendance
        })
        .catch(err => {
            console.error(err);
        })


    },
    mounted() {


    },
    methods: {




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
