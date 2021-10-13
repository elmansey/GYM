


<template>

    <div v-if="isLoadig">

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
                                        <th sortKey="name" >permission</th>
                                        <th sortKey="options">options</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td></td>
                                            <td>{{ row.role }}</td>
                                            <td><span class="badge badge-success" style="cursor:pointer" @click.prevent="showRole(row)" >{{ row.role }}</span></td>
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
                                                            @click="twoEvent(row.id,index)" >

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
            roles: [],

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
        axios.get("roles")
            .then((res) => {
                this.roles = res.data.RoleAndPermission;
                this.isLoadig = true
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
         twoEvent(id,key){
             this.id = id
             this.key = key
            this.$bvModal.show('bv-modal-example')

        },


        destroy(){


                axios.get('roleDelete/'+this.id)
                .then(res => {

                    if(res.data.success == true){

                        this.id = ''
                        this.key = ''
                       this.roles.splice(this.key,1)
                        Toast.fire({
                            icon: 'success',
                            title: 'Role deleted successfully'
                        })

                        this.$bvModal.hide('bv-modal-example')

                    }


                })
                .catch(err => {
                    console.log(err.message)
                })


        },

       async showRole(data){
           await this.$store.dispatch('roleDataToShow',data)
            this.$router.push('showRole')
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
