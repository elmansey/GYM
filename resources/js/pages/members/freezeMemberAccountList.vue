


<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="freeze account  list" />

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

                                                    <template #cell(freeze_in)="data">

                                                                <span class="badge badge-pill badge-primary"> {{ data.item.Account_freeze }} </span>
                                                    </template>

                                                    <template #cell(days_left_before_freezing)="data">

                                                                <span class="badge badge-pill badge-primary"> {{ data.item.days_left_before_freezing }} </span>
                                                    </template>

                                                    <template #cell(qr_code)="data">

                                                                <img :src="'../../public/'+ data.item.qr_code" style="width:60px;height:60px"/>
                                                    </template>

                                                    <template #cell(action)="data">

                                                                <b-dropdown text="" menu-class="dropdown-content" size="xs" variant="default">
                                                                    <b-dropdown-item  @click.prevent="unfreezeHandel(data.item.id,data.index)">
                                                                        <feather  style="width:15px" type="zap" ></feather> unfreeze account

                                                                    </b-dropdown-item>

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




                            <b-modal id="unfreeze" hide-footer>
                                <template #modal-title>
                                   unfreeze  account
                                </template>
                                <div class="d-block text-center">

                                    <h5> <i  class="icofont icofont-snow-alt"></i>    are you sure to unfreeze this account</h5>
                                </div>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
                                <b-button class="mt-3"  v-b-modal.modal-sm variant="dark"  @click.prevent="unfreezeThisAccount">unfreeze</b-button>
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

            unFreezeAccountId:'',
            unFreezeAccountIndex:'',
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            tablefields1: [
                'id',
                'profile_picture',
                'name',
                { key: 'phone', label: 'phone', sortable: false, },
                'freeze_in',
                'days_left_before_freezing',
                { key: 'member_ships_relation.name', label: 'memberShip', sortable: false, },
                'qr_code',
                { key: 'RF_code', label: 'RF code', sortable: false, },
                'action',



            ],
            members: [],
            filter: {
                currentPage: 1,
                totalPages: 0,
            },

            isLoadig:false,



        };

    },
    beforeMount() {


        axios.get('freezeAccountOnly')
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


        unfreezeThisAccount(){

            axios.get(`unFreezeThisAccount/${this.unFreezeAccountId}`)
            .then(res => {

                if(res.data.success){
                    this.members.splice(this.unFreezeAccountIndex,1);
                    this.$bvModal.hide('unfreeze');
                    this.unFreezeAccountId = ''
                    this.unFreezeAccountIndex = ''
                }
            })
            .catch(err => {

            })

        },
        unfreezeHandel(id,key){

            this.unFreezeAccountId = id
            this.unFreezeAccountIndex = key

            this.$bvModal.show('unfreeze')
        }







    },

    watch: {



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


