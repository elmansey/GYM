
<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="notification" />

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
                                                        :items="notifications"
                                                        :fields="tablefields1"
                                                        :current-page="currentPage"
                                                        :per-page="perPage"
                                                    >

                                                <template #cell(id)="data">
                                                            {{ ++data.index }}
                                                </template>

                                                <template #cell(action)="data">
                                                           <i  style="font-size: 20px;cursor: pointer;" class="icofont icofont-eye-alt"></i>
                                                           <i  style="font-size: 20px;cursor: pointer;" class="icofont icofont-delete-alt"></i>
                                                </template>

                                                <template #cell(body)="data">

                                                           {{data.item.body.substring(0,40) + '.....' }}

                                                </template>

                                                <template #cell(read)="data">

                                                    <span v-if="data.item.read == 0" class="badge badge-pill badge-dark"> not seen </span>
                                                    <span v-if="data.item.read == 1" class="badge badge-pill badge-success"> seen </span>

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

            notifications:[],
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            tablefields1: [
                'id',
                { key: 'title', label: 'title', sortable: false, },
                'body',
                'read',
                'action'
            ],



            isLoadig:false,



        };

    },
    beforeMount() {

        this.getNotificationInFireBaseDatabase()


    },
    computed: {


    },
    methods: {


        // listen eny changes
        getNotificationInFireBaseDatabase(){


          var path =    firebase.database().ref("notification")

            path.on('value',(data) => {
                if(data.val() != null){
                    this.notifications =  Object.values(data.val())
                    this.totalRows = this.notifications.length
                }

                })

                this.isLoadig = true


        },






    },

     watch: {

        notificationsRow:function(notifications){
            this.totalRows = notifications.length

        }

    }
}

</script>
