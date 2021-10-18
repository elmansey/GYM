


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="groups" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">


                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="groups"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                        <th></th>
                                        <th sortKey="name">name</th>
                                        <th sortKey="name" >____</th>
                                        <th sortKey="options">options</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td></td>
                                            <td>{{row.name}}</td>
                                            <td></td>
                                            <td>
                                                <div>
                                                    <b-button-group class="btn-container ">


                                                        <router-link
                                                            squared
                                                            variant="outline-warning"
                                                            class="btn-sm btn-child"
                                                            :to="{name : 'updateGroup',params : {groupId : row.id}}"

                                                            v-if="can('edit-group')"

                                                        >
                                                            Edit
                                                        </router-link>


                                                        <b-button
                                                            squared
                                                            variant="outline-danger"

                                                            class="btn-sm btn-child"
                                                            @click="DeletegroupModal(row.id,index)"
                                                            v-if="can('delete-group')"
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
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger" @click="deletegroup" >delete</b-button>
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
            groups:[],

            filter: {
                currentPage: 1,
                totalPages: 0,
            },

            id:'',
            key:'',
            isLoadig:false


        };
    },
    beforeMount() {

        axios.get('groups')
            .then(res => {
                this.groups = res.data.groups
                this.isLoadig  = true
            })
            .then(err => {

            })

    },
    mounted() {


    },
    methods: {
        DeletegroupModal(id,key){
            this.id = id
            this.key  = key
            this.$bvModal.show('bv-modal-example')
        },

        deletegroup(){

            axios.get(`deleteGroup/${this.id}`)
                .then(res => {

                    if(res.data.success){

                        this.groups.splice(this.key,1)
                        this.id = ''
                        this.key = ''
                        Toast.fire({
                            icon: 'success',
                            title: 'group deleted successfully'
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
