<template>
    <div>
        <Breadcrumbs main="Dashboard" title="permissions" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">

                                <button id="default-outline-primary-sm" @click.prevent="add"  class="btn btn-pull btn-outline-primary btn-outline-primary btn-sm mb-3">add Role  </button>

                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="roles"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                        <th></th>
                                        <th sortKey="name">name</th>
                                        <th sortKey="name">permission</th>
                                        <th sortKey="options">options</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td></td>
                                            <td>{{ row.role }}</td>
                                            <td><span class="badge badge-success" style="cursor:pointer"  @click="showPermission" >{{ row.role }}</span></td>
                                            <td>
                                                <div>
                                                    <b-button-group class="btn-container ">


                                                            <b-button
                                                                squared
                                                                variant="outline-warning"
                                                                class="btn-sm btn-child"
                                                                @click.prevent="edit(row)"
                                                            >
                                                               Edit
                                                            </b-button>


                                                        <b-button
                                                            squared
                                                            variant="outline-danger"

                                                            class="btn-sm btn-child"
                                                            @click="twoEvent(row.id)" >

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
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cansel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger"  @click="destroy">delete</b-button>
                            </b-modal>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";


export default {
    data() {
        return {
            roles: [],

            filter: {
                currentPage: 1,
                totalPages: 0,
            },
            id:''

        };
    },
    beforeMount() {
        axios.get("roles")
            .then((res) => {
                this.roles = res.data.RoleAndPermission;

            })
            .catch((err) => {
                console.log(err);
            });
    },
    methods: {
        async edit(roleData) {
            await this.$store.dispatch('EDIT')
            await this.$store.dispatch('ROLEDATATOEDIT', roleData)
            this.$router.push('role')
        },
        async add() {
            await this.$store.dispatch('ADD')
            this.$router.push('role')
        },


        showPermission() {

        },
        async twoEvent(id){
            await this.$store.dispatch('DELETEID',id)
            this.id = this.$store.getters.DELETEID
            this.$bvModal.show('bv-modal-example')

        },


        destroy(){


                axios.post('roleDelete',this.id)
                .then(res => {

                    if(res.data.success == true){

                        Toast.fire({
                            icon: 'success',
                            title: 'Role deleted successfully'
                        })
                        this.$store.dispatch('DELETEID','')
                        this.$bvModal.hide('bv-modal-example')

                    }


                })
                .catch(err => {
                    console.log(err.message)
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
