


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="class list" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">


                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="classes"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                        <th></th>
                                        <th sortKey="name">className</th>
                                        <th sortKey="name" >coachName</th>
                                        <th sortKey="name" >startingTime</th>
                                        <th sortKey="name" >endingTime</th>
                                        <th sortKey="name" >trainingLocation</th>
                                        <th sortKey="options">options</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div>
                                                    <b-button-group class="btn-container ">


                                                        <router-link
                                                            squared
                                                            variant="outline-warning"
                                                            class="btn-sm btn-child"
                                                            to=""
                                                            v-if="can('edit-class-schedule')"

                                                        >
                                                            Edit
                                                        </router-link>


                                                        <b-button
                                                            squared
                                                            variant="outline-danger"
                                                            class="btn-sm btn-child"
                                                            @click=""
                                                            v-if="can('delete-class-schedule')"
                                                        >

                                                            Delete
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
                                    Delete Role
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to delete this Role</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger" @click="" >delete</b-button>
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
            classes:[],

            filter: {
                currentPage: 1,
                totalPages: 0,
            },

            id:'',
            key:'',
            isLoadig:true


        };
    },
    beforeMount() {



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
