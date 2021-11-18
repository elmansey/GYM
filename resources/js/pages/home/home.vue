<template>
  <div>
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
                        <h4>1005</h4>
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
                        <h4>100</h4>
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
                        <h4>101</h4>
                        <span>staff team </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </px-card>
        </div>



        <!-- <div class="col-xl-3 xl-50 chart_data_right box-col-12">
          <px-card>
            <div slot="with-padding">
              <div class="media align-items-center">
                <div class="media-body right-chart-content">
                  <h4>
                    $95,900
                    <span class="new-box">Hot</span>
                  </h4>
                  <span>Purchase Order Value</span>
                </div>
                <div class="knob-block text-center" id="ordervalue"></div>
              </div>
            </div>
          </px-card>
        </div> -->


        <!-- <div class="col-xl-3 xl-50 chart_data_right second d-none">
          <px-card>
            <div slot="with-padding">
              <div class="media align-items-center">
                <div class="media-body right-chart-content">
                  <h4>
                    $95,000
                    <span class="new-box">New</span>
                  </h4>
                  <span>Product Order Value</span>
                </div>
                <div class="knob-block text-center" id="productvalue"></div>
              </div>
            </div>
          </px-card>
        </div> -->

<!--
         <div class="col-xl-5 col-lg-12 box-col-12">
          <px-card>
            <div slot="headerCustom">
              <div class="row">
                <div class="col-9">
                  <h5>Finance</h5>
                </div>
                <div class="col-3 text-right">
                  <i class="text-muted" data-feather="navigation"></i>
                </div>
              </div>
            </div>
            <div slot="with-padding">
              <div class="chart-container">
                <div id="columnchart">
                  <apexchart
                    height="350"
                    type="bar"
                    :options="chart7.options"
                    :series="chart7.series"
                  ></apexchart>
                </div>
              </div>
            </div>
          </px-card>
        </div> -->

        <div class="col-sm-12 col-xl-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Membership stats </h5>
                  </div>
                  <div class="card-body chart-block">
                    <div class="chart-overflow" id="bar-chart1"></div>
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
                    <h5>Pie Chart <span class="digits">1</span></h5>
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
  </div>
</template>
<script>
var primary = localStorage.getItem("primary_color") || "#7366ff";
import axios from 'axios'

import { GChart } from 'vue-google-charts'

export default {




    data() {
        return {

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
                ['Task', 'Hours per Day'],
                ['Work',     5],
                ['Eat',      10],
                ['Commute',  15],
                ['Watch TV', 20],
                ['Sleep',    25]
            ],
            options_1: {
            title: 'My Daily Activities',
            width:'100%',
            height: 400,
            colors: ["#7366ff", "#f73164", "#51bb25", "#007bff", "#FF5370"]
          },

        },



        chart7: {
            options: {
            chart: {
                width: 585,
                height: 350,
                type: "bar",
                toolbar: {
                show: false,
                },
                zoom: {
                enabled: false,
                },
            },
            legend: {
                show: false,
            },
            colors: [primary],
            dataLabels: {
                enabled: false,
            },
            plotOptions: {
                bar: {
                radius: 10,
                horizontal: false,
                columnWidth: "55%",
                },
            },
            stroke: {
                show: true,
                colors: ["transparent"],
                curve: "smooth",
                lineCap: "butt",
                colors: ["transparent"],
            },
            title: {
                text: "Load Average",
                align: "left",
                style: {
                fontSize: "12px",
                },
            },
            subtitle: {
                text: "20%",
                floating: true,
                align: "right",
                offsetY: 0,
                style: {
                fontSize: "22px",
                },
            },
            xaxis: {
                categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
                ],
            },
            fill: {
                colors: [primary],
            },
            tooltip: {
                y: {
                formatter: function (val) {
                    return "$ " + val + " thousands";
                },
                },
            },
            },
            series: [
            {
                data: [200, 250, 330, 390, 420, 500, 580, 620, 700],
            },
            ],
        },








        };
    },

    beforeMount() {

        axios.get('statistics')
        .then(res => {

            if(res.data.success){


                return res.data.MembershipsStatistics.map((item,index) => {

                    var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
                    Object.entries(item).map((val,k) => {

                         this.bar_chart.chartData_1.push([val[0],val[1],randomColor])
                    })


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
