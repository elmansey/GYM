<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="Activities logs" />
        <div class="card-body" style="overflow:scroll;width:600px;height:600px;margin: auto auto 70px ;background-color: #fff;box-shadow: 0 1px 15px  rgba(0 0 0 /4%), 0 1px 6px  rgba(0 0 0 /4%);">
            <div class=" border-bottom " style='margin-bottom: 10px;'>
                <h4 class="card-title">Activities list</h4>
            </div>


        <section class="ps-container scroll dashboard-list-with-user ps" v-for="(item,index) in history" :key="index" style="direction: ltr !important;" >

            <div class="d-flex flex-row mb-3 pb-3 border-bottom">

                    <img


                    :src="item.user_relation.profile_picture ? `../../profile_pictures/${item.user_relation.profile_picture }` :
                                             '../../profile_pictures/DefaultProfile.jpg'"


                    alt="" class=" " style="width:50px;height:50px;border-radius: 50%;">

                    <div class="pl-3 pr-2">

                        <p class="font-weight-medium mb-0">{{ item.user_relation.name }}</p>
                        <p class="text-muted mb-0 text-small">{{ item.user_relation.name + '  ' +   item.title }}</p>
                        <p class="text-muted mb-0 text-small">{{ item.date }}</p>

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
export default {
    data() {
        return{
            history:[],
            isLoadig:false

        }
    },


    beforeMount(){
        axios.get('history')
        .then(res => {

            this.history = res.data.history
            this.isLoadig = true
        })
        .catch(err => {
            console.error(err);
        })
    }
}
</script>

<style scoped>
::-webkit-scrollbar {
    width: 0px;
    background:transparent;
};



</style>
