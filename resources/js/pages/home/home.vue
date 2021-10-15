<template>
    <div>
        <Breadcrumbs main="Dashboard" title="Home" />
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row second-chart-list third-news-update">

                <div class="col-xl-9 xl-100 chart_data_left box-col-12">
                    <px-card>
                        <div class="row m-0 chart-main">
                            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                <div class="media align-items-center">
                                    <div class="hospital-small-chart">
                                        <div class="small-bar">
                                            <div class="small-chart flot-chart-container">
                                                <chartist
                                                    type="Bar"
                                                    :data="smallchart1.chartData_1"
                                                    :options="smallchart1.chartOptions"
                                                    :event-handlers="smallchart1.eventHandlers"
                                                ></chartist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="right-chart-content">
                                            <h4>1001</h4>
                                            <span>purchase</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                <div class="media align-items-center">
                                    <div class="hospital-small-chart">
                                        <div class="small-bar">
                                            <div class="small-chart1 flot-chart-container">
                                                <chartist
                                                    type="Bar"
                                                    :data="smallchart2.chartData_1"
                                                    :options="smallchart2.chartOptions"
                                                    :event-handlers="smallchart2.eventHandlers"
                                                ></chartist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="right-chart-content">
                                            <h4>1005</h4>
                                            <span>Sales</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                <div class="media align-items-center">
                                    <div class="hospital-small-chart">
                                        <div class="small-bar">
                                            <div class="small-chart2 flot-chart-container">
                                                <chartist
                                                    type="Bar"
                                                    :data="smallchart3.chartData_1"
                                                    :options="smallchart3.chartOptions"
                                                    :event-handlers="smallchart3.eventHandlers"
                                                ></chartist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="right-chart-content">
                                            <h4>100</h4>
                                            <span>Sales return</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                <div class="media border-none align-items-center">
                                    <div class="hospital-small-chart">
                                        <div class="small-bar">
                                            <div class="small-chart3 flot-chart-container">
                                                <chartist
                                                    type="Bar"
                                                    :data="smallchart4.chartData_1"
                                                    :options="smallchart4.chartOptions"
                                                    :event-handlers="smallchart4.eventHandlers"
                                                ></chartist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="right-chart-content">
                                            <h4>101</h4>
                                            <span>Purchase ret</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </px-card>
                </div>


            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</template>
<script>

import * as Chartist from "chartist";
var primary = localStorage.getItem("primary_color") || "#7366ff";
var secondary = localStorage.getItem("secondary_color") || "#f73164";
var Knob = require("knob");
var ordervalue = Knob({
    value: 35,
    angleOffset: 90,
    className: "review",
    thickness: 0.2,
    width: 65,
    height: 65,
    fgColor: primary,
});
var productvalue = Knob({
    value: 60,
    angleOffset: 90,
    className: "review",
    thickness: 0.2,
    width: 65,
    height: 65,
    fgColor: primary,
});

export default {
    data() {
        return {

            smallchart1: {
                chartData_1: {
                    labels: ["Q1", "Q2", "Q3", "Q4", "Q5", "Q6", "Q7"],
                    series: [
                        [400, 900, 800, 1000, 700, 1200, 300],
                        [1000, 500, 600, 400, 700, 200, 1100],
                    ],
                },
                chartOptions: {
                    stackBars: true,
                    axisX: {
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                    },
                    axisY: {
                        low: 0,
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                        labelInterpolationFnc: function (value) {
                            return value / 1000 + "k";
                        },
                    },
                },
                eventHandlers: [
                    {
                        event: "draw",
                        fn(data) {
                            if (data.type === "bar") {
                                data.element.attr({
                                    style: "stroke-width: 3px",
                                });
                            }
                        },
                    },
                ],
            },
            smallchart2: {
                chartData_1: {
                    labels: ["Q1", "Q2", "Q3", "Q4", "Q5", "Q6", "Q7"],
                    series: [
                        [400, 600, 900, 800, 1000, 1200, 500],
                        [1000, 800, 500, 600, 400, 200, 900],
                    ],
                },
                chartOptions: {
                    stackBars: true,
                    axisX: {
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                    },
                    axisY: {
                        low: 0,
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                        labelInterpolationFnc: function (value) {
                            return value / 1000 + "k";
                        },
                    },
                },
                eventHandlers: [
                    {
                        event: "draw",
                        fn(data) {
                            if (data.type === "bar") {
                                data.element.attr({
                                    style: "stroke-width: 3px",
                                });
                            }
                        },
                    },
                ],
            },
            smallchart3: {
                chartData_1: {
                    labels: ["Q1", "Q2", "Q3", "Q4", "Q5", "Q6", "Q7"],
                    series: [
                        [1100, 900, 600, 1000, 700, 1200, 300],
                        [300, 500, 800, 400, 700, 200, 1100],
                    ],
                },
                chartOptions: {
                    stackBars: true,
                    axisX: {
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                    },
                    axisY: {
                        low: 0,
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                        labelInterpolationFnc: function (value) {
                            return value / 1000 + "k";
                        },
                    },
                },
                eventHandlers: [
                    {
                        event: "draw",
                        fn(data) {
                            if (data.type === "bar") {
                                data.element.attr({
                                    style: "stroke-width: 3px",
                                });
                            }
                        },
                    },
                ],
            },
            smallchart4: {
                chartData_1: {
                    labels: ["Q1", "Q2", "Q3", "Q4", "Q5", "Q6", "Q7"],
                    series: [
                        [400, 600, 800, 1000, 700, 1100, 300],
                        [1000, 500, 600, 300, 700, 200, 1100],
                    ],
                },
                chartOptions: {
                    stackBars: true,
                    axisX: {
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                    },
                    axisY: {
                        low: 0,
                        showGrid: false,
                        showLabel: false,
                        offset: 0,
                        labelInterpolationFnc: function (value) {
                            return value / 1000 + "k";
                        },
                    },
                },
                eventHandlers: [
                    {
                        event: "draw",
                        fn(data) {
                            if (data.type === "bar") {
                                data.element.attr({
                                    style: "stroke-width: 3px",
                                });
                            }
                        },
                    },
                ],
            },

        };
    },
    mounted() {

    },
};
</script>
