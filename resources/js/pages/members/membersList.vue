


<template>

    <div v-if="isLoadig">

        <Breadcrumbs :main="$t('Dashboard')" :title="$t('members list')" />
        <button class="btn btn-primary btn-sm" style="margin-left: 30px;margin-bottom: 15px;"><i  class="icofont icofont-snow-alt"></i>
            <router-link style="color:#fff" :to="{name : 'freezeMemberAccountList'}">
                   {{ $t('freeze list')}}
            </router-link>
        </button>
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


                                                                :src="data.item.profile_picture ? '../../public/profile_pictures/'+data.item.profile_picture :
                                                                '../../public/profile_pictures/DefaultProfile.jpg'"/>
                                                    </template>
                                                    <template #cell(name)="data">
                                                               <router-link  v-if="can('show-member-details')" :to="{name : 'showMemberDetails', params:{memberBaseId : data.item.id}}">
                                                                    {{ data.item.name}}
                                                                </router-link>

                                                                <div v-else>
                                                                    {{ data.item.name}}
                                                                </div>
                                                    </template>
                                                    <template #cell(qr_code)="data">

                                                                <img :src="'../../public/'+ data.item.qr_code" style="width:60px;height:60px"/>
                                                    </template>



                                                    <template #cell(action)="data">


                                                                <b-dropdown text="" menu-class="dropdown-content" size="xs" variant="default">
                                                                    <b-dropdown-item @click.prevent="freezeAccountHandel(data.item.id,data.index)">
                                                                        <feather  style="width:15px" type="zap" ></feather> {{ $t('freeze account')}}

                                                                    </b-dropdown-item>
                                                                    <b-dropdown-item >
                                                                          <router-link  :to="{name: 'editMember', params: {memberId : data.item.id}}"  v-if="can('edit-member-from-team')">
                                                                            <feather style="width:15px" type="edit-2"></feather> {{ $t('edit')}}
                                                                            </router-link>
                                                                    </b-dropdown-item>
                                                                    <b-dropdown-item
                                                                    @click="DeleteAdminModal(data.item.id,data.index)"  v-if="can('delete-member-from-team')"
                                                                    ><feather style="width:15px" type="trash"></feather>{{ $t('delete')}}</b-dropdown-item>

                                                                </b-dropdown>







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
                                   {{$t('Delete member')}}
                                </template>
                                <div class="d-block text-center">

                                    <h5>{{$t('are you sure to delete this member')}}</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">{{ $t('Cancel')}}</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger"  @click.prevent="deletemember">{{ $t('delete')}}</b-button>
                            </b-modal>

                            <b-modal id="freeze" hide-footer>
                                <template #modal-title>
                                   {{ $t('freeze account')}}
                                </template>
                                <div class="d-block text-center">

                                    <h5> <i  class="icofont icofont-snow-alt"></i>   {{$t('are you sure to freeze this account')}}</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">{{ $t('Cancel')}}</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="primary"  @click.prevent="freezeAccount">{{ $t('freeze')}}</b-button>
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

            freezeAccountId:'',
            freezeAccountIndex:'',
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            tablefields1: [
                {'id' : this.$t('id')},
                { 'profile_picture' : this.$t('profile_picture')},
                {'name' : this.$t('name')},
                { key: 'phone', label: this.$t('phone'), sortable: false, },
                { key: 'phone', label: this.$t('phone'), sortable: false, },
                { key: 'start_date', label: this.$t('start date'), sortable: false, },
                { key: 'period_Expiry', label: this.$t('period Expiry'), sortable: false, },
                { key: 'member_ships_relation.name', label: this.$t('memberShip'), sortable: false, },
                {'qr_code' : this.$t('qr_code')},
                { key: 'RF_code', label: this.$t('RF code'), sortable: false, },
                {'action' : this.$t('action')},



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


        this.getMmebers()

    },
    created() {



    },
    methods: {

        freezeAccountHandel(id,key){
            this.freezeAccountId = id
            this.freezeAccountIndex = key
             this.$bvModal.show('freeze')

        },
        freezeAccount(){

            axios.get(`freezeThisAccount/${this.freezeAccountId}`)
            .then(res => {
                if(res.data.success){
                    this.members.splice(this.freezeAccountIndex,1)
                    this.$bvModal.hide('freeze')
                    this.freezeAccountIndex = ''
                    this.freezeAccountId = ''

                }
            })
            .catch(err => {
                console.error(err);
            })

        },

        getMmebers(){
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
                        title:  this.$t('member deleted successfully')
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


