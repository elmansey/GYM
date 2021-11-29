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
                  <div class="media align-items-center">
                    <div class="hospital-small-chart">
                      <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                         <i class="icofont icofont-gym-alt-3" ></i>
                      </div>
                    </div>
                    <div class="media-body">
                      <div class="right-chart-content">
                        <h4>1001</h4>
                        <span>Attendees today</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                  <div class="media align-items-center">
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
                  <div class="media align-items-center">
                    <div class="hospital-small-chart">
                    <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                         <i class="icofont icofont-ui-cart" ></i>
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
                  <div class="media border-none align-items-center">
                    <div class="hospital-small-chart">

                     <div class="small-bar" style="margin-top: -30px;font-size: 50px;">
                         <i class="icofont icofont-users-alt-6"></i>
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

        <!-- <div class="col-sm-12 col-xl-6">
                <div class="card">
                  <div class="card-header">
                    <h5>FF </h5>
                  </div>
                  <div class="card-body" style="height:478px">

                       <chartist
                            class="ct-11 flot-chart-container"
                            ratio="ct-major-second"
                            type="Bar"
                            :data="chart8.data"
                            :options="chart8.options">
                        </chartist>
                  </div>
                </div>
        </div> -->



           <!-- <div class="col-xl-12 col-md-12 col-sm-12">
              <px-card title="Simple line chart">
                    <div slot="headerAction" ></div>
                    <div slot="with-padding" >
                      <chartist
                          class="ct-1 flot-chart-container"
                          ratio="ct-major-second"
                          type="Line"
                          :data="chart10.data"
                          :options="chart10.options">
                  </chartist>
                    </div>
                </px-card>
            </div> -->








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


        <!-- <div class="col-xl-12 col-lg-12 ">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <div class="best-seller-table responsive-tbl">
                    <div class="item">
                      <div class="table-responsive product-list">
                        <table class="table table-bordernone">
                          <thead>
                            <tr>
                              <th class="f-22">Subscriptions to be paid</th>
                              <th>Date</th>
                              <th>Product</th>
                              <th>Country</th>
                              <th>Total</th>
                              <th class="text-right">Status</th>
                            </tr>
                          </thead>

                          <tbody>
                            <tr>
                              <td>
                                <div class="d-inline-block align-middle">
                                  <img
                                    class="img-40 m-r-15 rounded-circle align-top"
                                    src=""
                                    alt
                                  />
                                  <div class="status-circle bg-primary"></div>
                                  <div class="d-inline-block">
                                    <span>John keter</span>
                                    <p class="font-roboto">2019</p>
                                  </div>
                                </div>
                              </td>
                              <td>06 August</td>
                              <td>CAP</td>
                              <td>
                                <i class="flag-icon flag-icon-gb"></i>
                              </td>
                              <td>
                                <span class="label">$5,08,652</span>
                              </td>
                              <td class="text-right">
                                <i class="fa fa-check-circle"></i>Done
                              </td>
                            </tr>


                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div> -->









    </div>
    <!-- Container-fluid Ends-->
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

import { GChart } from 'vue-google-charts'


export default {




    data() {
        return {
            isLoadig:false,
            membersNumbers:'',
            staffNumber:'',
            productsNumber:'',

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
                title: 'My Daily Activities',
                width:'100%',
                height: 400,
                colors: ["#7366ff", "#f73164", "#51bb25", "#007bff", "#FF5370"]
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
                return res.data.MembershipsStatistics.map((item,index) => {

                    // var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
                    Object.entries(item).map((val,k) => {

                        this.bar_chart.chartData_1.push([val[0],val[1],'#007bff']);

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
