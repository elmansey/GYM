<template>
     <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="member details" />
        <div class="container-fluid">
            <div class="row">
          <div class="col-sm-12">
                  <div class="card">
                    <div class="profile-img-style">
                      <div class="row">
                        <div class="col-sm-8">
                          <div class="media">
                            <div class="media-body align-self-center">
                              <!-- <h5 class="mt-0 user-name">name</h5> -->
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 align-self-center">
                          <div class="float-sm-right"><small></small></div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-lg-12 col-xl-4">
                          <div id="aniimated-thumbnials-3" itemscope="">
                            <!-- <figure class="m-0"><a href="#"><img class="img-fluid rounded" src="../../assets/images/blog/img.png"></a>
                            </figure> -->
                            <img   style="width:80px;height: 80px;margin:30px" :src="loginInformation.profile_picture   ? '../../profile_pictures/'+loginInformation.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'" alt="" >
                          </div>
                        </div>

                        <div class="col-xl-11" style="margin:auto">
                                    <div style="margin:10px" class="datatable-vue m-0">
                                                <h3 >login information</h3>

                                                <div class="table-responsive vue-smart">
                                                    <b-table
                                                        id="tablePrint"
                                                        show-empty
                                                        stacked="md"
                                                        :items="loginInformation"
                                                        :fields="tablefields1"
                                                        :current-page="currentPage"
                                                        :per-page="perPage"
                                                    >


                                                    <template #cell(qr_code)="data">

                                                                <img :src="'../../'+ data.item.qr_code" style="width:60px;height:60px"/>
                                                    </template>


                                                </b-table>
                                            </div>

                                            <!-- <b-col md="6" class="my-1">
                                                    <b-pagination
                                                    v-model="currentPage"
                                                    :total-rows="totalRows"
                                                    :per-page="perPage"
                                                    class="my-0"
                                                    ></b-pagination>
                                            </b-col> -->
                                    </div>
                        </div>
                        <div class="col-xl-11" style="margin:auto">
                                    <div style="margin:10px" class="datatable-vue m-0">
                                                <h3 >login information</h3>

                                                <div class="table-responsive vue-smart">
                                                    <b-table
                                                        id="tablePrint"
                                                        show-empty
                                                        stacked="md"
                                                        :items="loginInformation"
                                                        :fields="tablefields1"
                                                        :current-page="currentPage"
                                                        :per-page="perPage"
                                                    >


                                                    <template #cell(qr_code)="data">

                                                                <img :src="'../../'+ data.item.qr_code" style="width:60px;height:60px"/>
                                                    </template>


                                                </b-table>
                                            </div>

                                            <!-- <b-col md="6" class="my-1">
                                                    <b-pagination
                                                    v-model="currentPage"
                                                    :total-rows="totalRows"
                                                    :per-page="perPage"
                                                    class="my-0"
                                                    ></b-pagination>
                                            </b-col> -->
                                    </div>
                        </div>

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
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            tablefields1: [

                { key: 'Personal_uuid', label: 'Personal uuid', sortable: false, },
                { key: 'name', label: 'name', sortable: false, },
                { key: 'email', label: 'email', sortable: false, },
                { key: 'user_name', label: 'phone', sortable: false, },
                'qr_code',
                { key: 'RF_code', label: 'RF code', sortable: false, },


            ],

                'personalInformation':[],
                'loginInformation':[],
                'contentInformation':[],
                'extraInformation':[],

            isLoadig:true
        }
    },


    beforeMount() {

        if(this.$route.params.memberBaseId){

            axios.get(`getMemberById/${this.$route.params.memberBaseId}`)
            .then(res => {

              if(res.data.success){

                    this.personalInformation  = res.data.personalInformation
                    this.loginInformation.push(res.data.loginInformation)
                    this.contentInformation  = res.data.contentInformation
                    this.extraInformation  = res.data.extraInformation



              }
            })
            .catch(err => {
                console.error(err);
            })
        }

    }
}
</script>
