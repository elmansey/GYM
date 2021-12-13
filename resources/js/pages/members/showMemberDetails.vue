<template>
     <div v-if="isLoadig">

        <Breadcrumbs :main="$t('Dashboard')" :title="$t('member details')" />
         <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header" style="padding: 0px" >
                            <img style="width:100px;height: 100px;    margin-left: 40px;    margin-right: 40px;margin-top: 10px;margin-bottom: 15px;"  :src="details.profile_picture ? '../../profile_pictures/'+details.profile_picture :
                                             '../../profile_pictures/DefaultProfile.jpg'" />
                        </div>


                          <div class="row">

                                <div class="col-lg-6 col-md-6">
                                    <div class="card-body">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('uuid')}}</th>
                                                    <td  >
                                                    {{ details.Personal_uuid }}
                                                    </td>


                                                </tr>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('name')}}</th>
                                                    <td  >
                                                    {{ details.name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('qr_code')}}</th>
                                                    <td  >
                                                    <img :src="'../../'+details.qr_code" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('phone')}}</th>
                                                    <td  >
                                                    {{ details.phone }}
                                                    </td>
                                                </tr>
                                                <tr v-if="details.member_ships_relation">
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('membership')}}</th>
                                                    <td  >
                                                    {{ details.member_ships_relation.name }}
                                                    </td>
                                                </tr>
                                                <tr v-if="details.class_relation">
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('class')}}</th>
                                                    <td  >
                                                    {{ 'from : ' + details.class_relation.startingTime + 'to: '+ details.class_relation.endingTime }}
                                                    </td>
                                                </tr>
                                                <tr v-if="details.group_id && details.group_id.length > 1">
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('group')}}</th>
                                                    <td  >
                                                        <span class="badge badge-pill badge-dark" v-for=" (val,ke) in  details.group_id" :key="ke">
                                                                {{  val.name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('Subscription period')}}</th>
                                                    <td  >
                                                    {{ details.Subscription_period }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('start date')}}</th>
                                                    <td  >
                                                    {{ details.start_date }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('period Expiry')}}</th>
                                                    <td  >
                                                    {{ details.period_Expiry }}
                                                    </td>
                                                </tr>

                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('subscription status')}}</th>
                                                    <td  >
                                                        <span v-if="details.subscription_status == 'paid'" class="badge badge-pill badge-success">{{details.subscription_status}}</span>
                                                        <span v-if="details.subscription_status == 'expired'" class="badge badge-pill badge-danger">{{details.subscription_status}}</span>
                                                   
                                                    </td>
                                                </tr>


                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('gender')}} </th>
                                                    <td  >
                                                    {{ details.gender }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('date of birth')}} </th>
                                                    <td  >
                                                    {{ details.date_of_birth }}
                                                    </td>
                                                </tr>


                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('address')}} </th>
                                                    <td  >
                                                    {{ details.address }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                <th width="50" style="font-size: 17px;font-weight">{{ $t('City')}} </th>
                                                    <td  >
                                                    {{ details.city }}
                                                    </td>
                                                </tr>






                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div style="overflow:scroll" class="col-lg-6 col-md-6">
                                    <div class="card-body">
                                        <div >
                                            <i  class="fa fa-link m-15" ></i>{{ $t('logs')}}
                                        </div>
                                        <div v-for="(item,index) in details.log" :key="index">

                                                <section class="ps-container scroll dashboard-list-with-user ps">
                                                    <div class="d-flex flex-row mb-3 pb-3 border-bottom">


                                                        <img
                                                        :src="details.profile_picture ? '../../profile_pictures/'+details.profile_picture :
                                                            '../../profile_pictures/DefaultProfile.jpg'"
                                                        alt=""  style="width:50px;height:50px" class="img-thumbnail  border-0 rounded-circle list-thumbnail align-self-center xsmall">

                                                            <div class="pl-3 pr-2">

                                                                <p class="font-weight-medium mb-0">{{ details.name }}</p>
                                                                <p class="text-muted mb-0 text-small">{{ item.key + " "+'account in'}}</p>
                                                                <p class="text-muted mb-0 text-small">{{ item.value }}</p>

                                                            </div>
                                                    </div>
                                                </section>

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


            details:'',
            isLoadig:true
        }
    },


    beforeMount() {

        if(this.$route.params.memberBaseId){

            axios.get(`getMemberById/${this.$route.params.memberBaseId}`)
            .then(res => {

              if(res.data.success){


                    this.details  = res.data.extraInformation



              }
            })
            .catch(err => {
                console.error(err);
            })
        }

    }
}
</script>

<style scoped>

::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
};

</style>
