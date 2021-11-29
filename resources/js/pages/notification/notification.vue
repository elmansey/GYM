
<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="notification" />

                <div
                style="
                max-width:600px;margin:auto;
                overflow:scroll;
                background-color:#fff;
                height:630px;
                margin-bottom: 35px;
                box-shadow: 0 1px 15px  rgba(0 0 0 /4%), 0 1px 6px  rgba(0 0 0 /4%);

                " class="card-body">

                    <div style="display:flex;" class=" border-bottom mb-10" >

                            <h4 class="card-title" >notifications</h4><feather style="margin-left: 10px;  margin-top: 5px;" type="bell"></feather >


                    </div>



                    <section class="ps-container scroll dashboard-list-with-user ps">

                        <div class="d-flex flex-row   border-bottom" v-for="(item,key) in notifications"   :key="key">

                            <div v-if="item.created_at != $route.params.notificationId"  style="padding: 15px 20px 15px 20px;">

                                <div style="display:flex" >
                                      <p class="font-weight-medium mb-0">{{  item.title }}</p>




                                    <b-dropdown style="display:inline" text="" menu-class="dropdown-content" size="xs" variant="default">
                                        <b-dropdown-item @click="deleteNotification(key)">
                                            <feather style="width:15px;margin-right: 5px;" type="trash"></feather>delete
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </div>

                                <p class="text-muted mb-0 text-small" style="margin-left:10px">{{ item.body }}</p>
                                <span class="text-muted mb-0 text-small  badge-light badge-pill" style="margin-left:10px">{{ handelTime(item.DateTime) }}</span>

                            </div>

                            <div v-if="item.created_at == $route.params.notificationId"  style="background-color: #EEEEEE;padding: 15px 20px 15px 20px">

                                 <div style="display:flex" >
                                      <p class="font-weight-medium mb-0">{{  item.title }}</p>


                                    <b-dropdown style="display:inline" text="" menu-class="dropdown-content" size="xs" variant="default">
                                        <b-dropdown-item @click="deleteNotification(key)">
                                            <feather style="width:15px;margin-right: 5px;" type="trash"></feather>delete
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </div>
                                <p class="text-muted mb-0 text-small" style="margin-left:10px">{{ item.body }}</p>
                                <span class="text-muted mb-0 text-small  badge-light badge-pill" style="margin-left:10px">{{ handelTime(item.DateTime) }}</span>

                            </div>

                        </div>




                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
                                </div>
                        </div>

                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;">
                                </div>
                        </div>

                    </section>
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
import moment from 'moment';

export default {
    data() {
        return {

            notifications:[],

            isLoadig:false,



        };

    },
    beforeMount() {

        this.getNotificationInFireBaseDatabase()





    },




    mounted() {



    },



    computed: {


    },

    methods: {



        deleteNotification(id){

                var path = firebase.database().ref("notification/"+id)
                path.remove().then(() => {

                    console.log('deleted')

                }).catch(() => {
                    console.log('deleted error')
                })

        },


        seen(){

            var path =    firebase.database().ref("notification")

                path.once('value',function(data) {

                    if(data.val() != null){
                        data.forEach((child) => {

                            child.ref.update({read:1})

                        })
                    }


                })
        },



        handelTime(time){
            const timeAgo =  moment(time).fromNow()

            return timeAgo
        },



        // listen eny changes
        getNotificationInFireBaseDatabase(){


        var path =    firebase.database().ref("notification")

            path.on('value',(data) => {
                if(data.val() != null){
                    var val =  data.val()

                        // val.sort(function(a,b){

                        //     return new Date(b.created_at) - new Date(a.created_at);

                        // });

                        console.log(Object.keys(data.val()).length)

                    if(this.$route.name == 'notification'){

                        this.seen()

                    }


                    this.notifications =  val
                }else{
                    this.notifications = []
                }

                })


                this.isLoadig = true


        },






    },

     watch: {






    }
}

</script>
<style scoped>
::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
};
</style>
