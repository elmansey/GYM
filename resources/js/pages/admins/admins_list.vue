


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="Team member list" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">


                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="admins"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                        <th></th>
                                        <th sortKey="name">name</th>
                                        <th sortKey="name" >email</th>
                                        <th sortKey="options">phone number</th>
                                        <th sortKey="options">roles</th>
                                        <th sortKey="options">actions</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td></td>
                                            <td>{{ row.name}}</td>
                                            <td>{{ row.email}}</td>
                                            <td>{{ row.phone}}</td>
                                            <td >
                                                <span class="badge badge-success" v-for="(v,k) in row.roles">
                                                    {{v.name}}
                                                </span>

                                            </td>
                                            <td>
                                                <div>
                                                    <b-button-group class="btn-container ">


                                                            <router-link
                                                                squared
                                                                variant="outline-warning"
                                                                class="btn-sm btn-child"
                                                                :to="{name: 'updateAdmin', params: {adminId : row.id}}"
                                                                v-if="can('edit-member-from-team')"
                                                            >
                                                               Edit
                                                            </router-link>


                                                        <b-button
                                                            squared
                                                            variant="outline-danger"

                                                            class="btn-sm btn-child"
                                                            @click="DeleteAdminModal(row.id,index)"
                                                            v-if="can('delete-member-from-team')"
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
                                   Delete Team member
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to delete this Admin</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger"  @click.prevent="deleteAdmin">delete</b-button>
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
            admins: null,
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

        axios.get('users')
        .then(res => {

            if(res.data.success == true){

                this.admins = res.data.admins
                this.isLoadig = true

            }


        })
        .catch(err => {


        })

    },
    created() {



    },
    methods: {

        // async addAdmin(){
        //
        //    await this.$store.dispatch('addAdmin')
        //        this.$router.push('addAdmin')
        // },
      async EditAdmin(admin){

           // await this.$store.dispatch('AdminInfoToEdit',admin)
          this.$router.push({name: 'updateAdmin', params: {admin}})
        },
        DeleteAdminModal(id,key){
             this.id = id
             this.key = key
           this.$bvModal.show('bv-modal-example')

       },
        deleteAdmin(){


            axios.get('userDelete/'+this.id)
            .then(res => {

                if(res.data.success == true){
                    this.id = ''
                    this.key = ''
                    this.admins.splice(this.key,1)
                    Toast.fire({
                        icon: 'success',
                        title: 'admin deleted successfully'
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
