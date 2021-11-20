


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="members list" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">


                                      <div  class="datatable-vue m-0">


                                                <div class="table-responsive vue-smart">
                                                    <b-table
                                                        id="tablePrint"
                                                        show-empty
                                                        stacked="md"
                                                        :items="members"
                                                        :fields="tablefields1"
                                                        :current-page="currentPage"
                                                        :per-page="perPage"
                                                    >


                                                    <template #cell(id)="data">
                                                            {{ ++data.index }}
                                                    </template>

                                                    <template #cell(profile_picture)="data">
                                                           <img
                                                                style="width: 40px;height: 40px;border-radius: 50%;"


                                                                :src="data.item.profile_picture ? '../../profile_pictures/'+data.item.profile_picture :
                                                                '../../profile_pictures/DefaultProfile.jpg'"/>
                                                    </template>
                                                    <template #cell(Personal_uuid)="data">
                                                               <router-link  v-if="can('show-member-details')" :to="{name : 'showMemberDetails', params:{memberBaseId : data.item.id}}">
                                                                    {{ data.item.Personal_uuid}}
                                                                </router-link>

                                                                <div v-else>
                                                                    {{ data.item.Personal_uuid}}
                                                                </div>
                                                    </template>
                                                    <template #cell(qr_code)="data">

                                                                <img :src="'../../'+ data.item.qr_code" style="width:60px;height:60px"/>
                                                    </template>
                                                    <template #cell(action)="data">

                                                                      <div>
                                                    <b-button-group class="btn-group-pill" size="sm">

                                                         <b-button variant="outline-dark">
                                                            <router-link  :to="{name: 'editMember', params: {memberId : data.item.id}}"  v-if="can('edit-member-from-team')">
                                                               edit
                                                            </router-link>
                                                        </b-button>

                                                        <b-button

                                                            variant="outline-danger"

                                                            @click="DeleteAdminModal(data.item.id,data.index)"
                                                            v-if="can('delete-member-from-team')"
                                                        >

                                                           delete
                                                        </b-button>
                                                    </b-button-group>
                                                </div>
                                                    </template>


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




                            <b-modal id="bv-modal-example" hide-footer>
                                <template #modal-title>
                                   Delete  member
                                </template>
                                <div class="d-block text-center">
                                    <h5>are you sure to delete this member</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger"  @click.prevent="deletemember">delete</b-button>
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


            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            tablefields1: [
                'id',
                'profile_picture',
                'Personal_uuid',
                { key: 'name', label: 'name', sortable: false, },
                { key: 'group_relation.name', label: 'group', sortable: false, },
                { key: 'phone', label: 'phone', sortable: false, },
                { key: 'phone', label: 'phone', sortable: false, },
                'qr_code',
                { key: 'RF_code', label: 'RF code', sortable: false, },
                'action',


            ],
            members: [],
            filter: {
                currentPage: 1,
                totalPages: 0,
            },
            id:'',
            keyes:'',
            isLoadig:false,



        };

    },
    beforeMount() {


        axios.get('members')
        .then(res => {

            if(res.data.success == true){

                res.data.members.map((item,index) => {

                    this.members.push(item)
                })
                this.totalRows = this.members.length
                this.isLoadig = true

            }


        })
        .catch(err => {


        })

    },
    created() {



    },
    methods: {



        DeleteAdminModal(id,key){
             this.id = id
             this.keyes = key
           this.$bvModal.show('bv-modal-example')

       },
        deletemember(){


            axios.get(`deleteMember/${this.id}`)
            .then(res => {

                if(res.data.success){

                    this.members.splice(this.key,1)

                    this.id = ''
                    this.keyes = ''
                    this.$bvModal.hide('bv-modal-example')
                    this.totalRows = this.members.length


                    Toast.fire({
                        icon: 'success',
                        title: 'member deleted successfully'
                    })
                }
            })
            .catch(err => {

            })

        },



    },

    watch: {

        memersRow:function(members){
            this.totalRows = members.length
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


