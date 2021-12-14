<template>

    <div v-if="isLoadig">
        <Breadcrumbs :main="$t('Dashboard')" :title="$t('statistics')" />


        <div class="row mb-4">


            <div class="mb-4 col-md-12 col-lg-6 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $t('Membership stats')}}</h4>
                        <div class="dashboard-line-chart">
                            <!-- <chartist
                                    class="ct-4 flot-chart-container"
                                    ratio="ct-major-second"
                                    type="Line"
                                    :data="chart5.data"
                                    :options="chart5.options">
                            </chartist> -->

                                <GChart
                                    class="chart-overflow" 
                                    id="bar-chart1"
                                    type="ColumnChart"
                                    :data="bar_chart.chartData_1"
                                    :options="bar_chart.options_1"
                                    />
                                        

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12 col-lg-6 col-xs-12">
                <div class="row">

                    <div class="mb-4 col col-6">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <div>
                                    <div  class="col-12">
                                        <p class="lead color-theme-1 mb-1 value">{{ attendanceToday }}</p>
                                    </div>

                                    <div class="row" >
                                        <div class="col-6" >
                                            <p class="">{{$t('Attendees today')}}</p>
                                        </div>

                                        <div class="col-6" style="margin-top: -30px;font-size: 50px;">
                                                <i class="icofont icofont-gym-alt-3" ></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col col-6">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <div>
                                    <div  class="col-12">
                                        <p class="lead color-theme-1 mb-1 value">{{ membersNumbers  }}</p>
                                    </div>

                                    <div class="row" >
                                        <div class="col-6" >
                                            <p class="">{{ $t('members number')}}</p>
                                        </div>

                                        <div class="col-6" style="margin-top: -30px;font-size: 50px;">
                                                <i class="icofont icofont-users" ></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col col-6">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <div>
                                    <div  class="col-12">
                                        <p class="lead color-theme-1 mb-1 value">{{ productsNumber }}</p>
                                    </div>

                                    <div class="row" >
                                        <div class="col-6" >
                                            <p class="">{{$t('products')}}</p>
                                        </div>

                                        <div class="col-6" style="margin-top: -30px;font-size: 50px;">
                                                <i class="fa fa-th-large"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col col-6">
                        <div class="card dashboard-small-chart-analytics">
                            <div class="card-body">
                                <div>
                                    <div  class="col-12">
                                        <p class="lead color-theme-1 mb-1 value">{{ staffNumber }}</p>
                                    </div>

                                    <div class="row" >
                                        <div class="col-6" >
                                            <p class="">{{$t('staff team')}}</p>
                                        </div>

                                        <div class="col-6" style="margin-top: -30px;font-size: 50px;">
                                                <i class="icofont icofont-gym-alt-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

            </div>

            <div class="mb-4 col-md-12 col-lg-6 col-xs-12" >
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $t('gender stats')}}</h4>
                        <div class="dashboard-line-chart">
                            <GChart
                                class="chart-overflow"
                                id="pie-chart2"
                                type="PieChart"
                                :data="pie_chart.chartData_2"
                                :options="pie_chart.options_2"
                                />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-md-12 col-lg-6 col-xs-12 ">

                <div slot="with-padding" class="chat-box" style="width:100%!important">

                    <div class="setting-dot">
                        <div class="setting-bg-primary date-picker-setting position-set pull-right">
                            <i class="fa fa-spin fa-cog"></i>
                        </div>
                    </div>

                </div>

                <functional-calendar :is-date-range='true' :change-month-function='true' :change-year-function='true' :is-dark='false'></functional-calendar>
            </div>



            <div class="mb-4 col-md-12 col-lg-6 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$t('latest events')}}</h4>
                        <section  style="height:250px;overflow:scroll" class="ps-container dashboard-logs scroll ps ps--active-y">
                            <table class="table table-sm table-borderless" >
                                <tbody >
                                    <tr v-for="(item,index) in lastLogs" :key="index">
                                        <td> <feather style="width:16px;color: #544179;" type="alert-circle"></feather></td>
                                        <td style="padding:0px"> <span class="font-weight-medium" ><router-link :to="{name : 'history'}">{{ (item.user_relation.name +' '+ item.title).substring(0,30)}}</router-link></span> </td>
                                        <td style="padding:0px" class="text-right">  <span class="text-muted">{{ item.date}}</span> </td> 
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-md-12 col-lg-6 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $t('Subscription has expired')}}</h4>
                        <section style="height:250px;overflow:scroll" class="ps-container dashboard-logs scroll ps ps--active-y">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr v-for="(item,index) in Subscription_Expiry_Members" :key="index">
                                        <td style="padding:0px" > <span class="log-indicator align-middle border-theme-1"></span></td>
                                        <td style="padding:0px" > <img style="width: 20px;height: 20px;border-radius: 50%;"  :src="item.profile_picture ? '../../profile_pictures/'+item.profile_picture :'../../profile_pictures/DefaultProfile.jpg'"/></td>
                                        <td style="padding:0px" > <span class="font-weight-medium"><router-link :to="{name : 'showMemberDetails' ,params : {memberBaseId : item.id}}">{{item.name}}</router-link></span> </td>
                                        <td style="padding:0px"  class="text-right">{{ $t('expiry at')}} <span class="text-muted">{{item.period_Expiry}}</span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
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
var primary = localStorage.getItem("primary_color") || "#7366ff";
import axios from 'axios'

import * as Chartist from 'chartist';
import { GChart } from 'vue-google-charts'
 import moment from "moment";


export default {
    
    data() {
        return {

            isLoadig:false,
            membersNumbers:'',
            staffNumber:'',
            productsNumber:'',
            attendanceToday:'',

            lastLogs:[],
            Subscription_Expiry_Members : [],



            pie_chart: {
                    chartData_2: [
                        ['gender', 'number'],

                    ],
                    options_2: {
                    title: this.$t('gender stats'),
                    width:'80%',
                    height: 200,
                    colors: ["#191919", '#2D4263']
                },
            },


            chart5 : {
                data: {
                    labels: [],
                    series: []
                },

                options: {
                fullWidth: true,
                chartPadding: {
                    right: 10
                },
                lineSmooth: Chartist.Interpolation.cardinal({
                    fillHoles: true
                }),
                low: 0
                }
                
            },


        bar_chart: {
            chartData_1: [  
                [this.$t("membership"), this.$t("number"), { role: "style" } ],
               
            ],
            options_1:  {
            width:'100%',
            height: 250,
            bar: {groupWidth: "30%"},
            // legend: { position: "none" },
            }
      },


    
    


   


    }
},







    components:{
        GChart:GChart,
    },


    beforeMount() {

        axios.get('statistics')
        .then(res => {

            if(res.data.success){

                this.membersNumbers = res.data.membersNumbers
                this.staffNumber = res.data.staffNumber
                this.productsNumber = res.data.products
                this.attendanceToday = res.data.attendanceToday

                res.data.gender.map((item,index) => {
                    Object.entries(item).map((val,k) => {
                       this.pie_chart.chartData_2.push(val);
                    })
                })
                 res.data.MembershipsStatistics.map((item,index) => {

                    // var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
                    Object.entries(item).map((val,k) => {
                         
                        this.bar_chart.chartData_1.push([val[0],val[1],'#212121']);
                        
                    })
                      this.isLoadig = true
                })
            }
        })
        .catch(err => {
            console.error(err);
        })


        axios.get('lastLogs')
        .then(res => {
            this.lastLogs = res.data.lastLogs
        }).catch(err => {

        })

        axios.get('Subscription_Expiry')
        .then(res => {
           this.Subscription_Expiry_Members = res.data.members
        }).catch(err => {

        })

    },

    methods:{
       
        handelTime(time) {

        const timeAgo = moment(time).fromNow();

        return timeAgo;
        },
    }
};
</script>
