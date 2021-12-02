<template>
  <div v-if="isLoadig">


    <Breadcrumbs main="Dashboard" title="statistics" />
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row second-chart-list third-news-update">




        <div class="col-xl-9 xl-100 chart_data_left box-col-12">
          <px-card>
            <div class="row m-0 chart-main">
                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                  <div class="media align-items-center"  style="padding:80px 40px">
                    <div class="hospital-small-chart">
                      <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                         <i class="icofont icofont-gym-alt-3" ></i>
                      </div>
                    </div>
                    <div class="media-body">
                      <div class="right-chart-content">
                        <h4>{{ attendanceToday }}</h4>
                        <span>Attendees today</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                  <div class="media align-items-center"  style="padding:80px 40px">
                    <div class="hospital-small-chart">
                    <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                         <i class="icofont icofont-users" ></i>
                    </div>
                    </div>
                    <div class="media-body">
                      <div class="right-chart-content">
                        <h4>{{ membersNumbers  }}</h4>
                        <span>members number</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                  <div class="media align-items-center"  style="padding:80px 40px">
                    <div class="hospital-small-chart">
                    <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                        <i class="fa fa-th-large"></i>
                    </div>
                    </div>
                    <div class="media-body">
                      <div class="right-chart-content">
                        <h4>{{ productsNumber  }}</h4>
                        <span>products</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                  <div class="media border-none align-items-center"  style="padding:80px 40px">
                    <div class="hospital-small-chart">

                     <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                        <i class="icofont icofont-gym-alt-2"></i>
                    </div>

                    </div>
                    <div class="media-body">
                      <div class="right-chart-content">
                        <h4>{{ staffNumber }}</h4>
                        <span>staff team </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </px-card>
        </div>

        <div class="col-xl-12">
            <b-card no-body>



                           <div style="display:flex;justify-content: center;">
                                <router-link  :to="{ name : 'addMember' }"><feather    style="width:35px;cursor: pointer;margin:15px;color:#222222" type="user-plus"></feather>  </router-link>
                                <router-link  :to="{ name : 'classSchedule' }"><feather   style="width:35px;cursor: pointer;margin:15px;color:#222222"  type="calendar"></feather>  </router-link>
                                <router-link  :to="{ name : 'tackAttendance' }"><feather    style="width:35px;cursor: pointer;margin:15px;color:#222222" type="clipboard"></feather>  </router-link>
                                <router-link  :to="{ name : 'TeamChat'}"><feather    style="width:35px;cursor: pointer;margin:15px;color:#222222" type="message-circle"></feather>  </router-link>
                                <router-link  :to="{ name : 'product_store' }"><feather    style="width:35px;cursor: pointer;margin:15px;color:#222222" type="layout"></feather>  </router-link>
                           </div>



            </b-card>
        </div>







        <div class="col-sm-12 col-xl-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Membership stats </h5>
                  </div>
                  <div class="card-body chart-block">

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

        <div class="col-sm-12 col-xl-6">
                <div class="card">
                  <div class="card-header">
                    <h5>gender  stats</h5>
                  </div>
                  <div class="card-body chart-block">
                    <GChart
                      class="chart-overflow"
                      id="pie-chart1"
                      type="PieChart"
                      :data="pie_chart.chartData_1"
                      :options="pie_chart.options_1"
                    />
                  </div>
                </div>
        </div>



        </div>

      </div>

        <div class="col-xl-12 col-lg-12  calendar-sec box-col-6">
          <px-card>
            <div slot="with-padding" class="chat-box" style="width:100%!important">
                <div class="setting-dot">
                <div class="setting-bg-primary date-picker-setting position-set pull-right">
                  <i class="fa fa-spin fa-cog"></i>
                </div>
              </div>
              <functional-calendar></functional-calendar>
            </div>
          </px-card>
        </div>










    </div>
    <!-- Container-fluid Ends-->


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

import { GChart } from 'vue-google-charts'


export default {




    data() {
        return {
            isLoadig:false,
            membersNumbers:'',
            staffNumber:'',
            productsNumber:'',
            attendanceToday:'',

            bar_chart: {
                chartData_1: [
                    ["type", "member", { role: "style" } ],

                ],

                options_1:  {
                title: "Membership stats",
                width:'100%',
                height: 400,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
                }
            },


            pie_chart: {
                chartData_1: [
                    ['gender', 'number'],

                ],
                options_1: {
                title: 'gender stats',
                width:'100%',
                height: 400,
                colors: ["#7366ff", '#160040']
            },
        },








            chart8 : {
                data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                series: [
                    [5, 4, 3, 7, 5, 10, 3],
                    [3, 2, 9, 5, 4, 6, 4]
                ]
                },
                options: {
                seriesBarDistance: 10,
                reverseData: true,
                horizontalBars: true,
                axisY: {
                    offset: 70
                },
                },
            },



        chart10 : {
            data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            series: [
                [12, 9, 7, 8, 5],
                [2, 1, 3.5, 7, 3],
                [1, 3, 4, 5, 6]
            ]
            },
            options: {
            fullWidth: true,
            chartPadding: {
                right: 40
            }
            },
      },


















        };
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

                       this.pie_chart.chartData_1.push(val)

                    })
                })

                 res.data.MembershipsStatistics.map((item,index) => {

                    // var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
                    Object.entries(item).map((val,k) => {

                        this.bar_chart.chartData_1.push([val[0],val[1],'#2b2b2b']);

                    })

                      this.isLoadig = true

                })




            }

        })
        .catch(err => {
            console.error(err);
        })
    },
    components:{
      GChart:GChart,

    },







};
</script>
