<template>
    <div>
        <Breadcrumbs main="dashboard" title="take attendance"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>take attendance</h5>
                        </div>
                        <form class="form theme-form datepicker-responsive">
                            <div class="card-body">

                                <div class="form-group form-row">
                                    <label class="col-sm-3 col-form-label text-right">person</label>
                                    <div class="col-xl-5 col-sm-9">
                                          <multiselect


                                                tag-placeholder="Add this as new tag"
                                                placeholder="Search by name or choose person"
                                                v-model="attendanceDate.name"
                                                label="name"
                                                track-by="id"

                                                :options="options"
                                                :multiple="false"
                                                :taggable="false"

                                            >
                                            </multiselect>
                                    </div>
                                </div>



                                <div class="form-group form-row">
                                    <label class="col-sm-3 col-form-label text-right">or search by RF code</label>
                                    <div class="col-xl-5 col-sm-9" style="height:125px;overflow:scroll">
                                        <input  type="text" class="form-control" style="margin: 10px;width: 96%;" @keyup="searchInUsersByRFcode" v-model="attendanceDate.RF_Person_Code" placeholder="type or search by RF code"/>
                                          <div style="width: 100%" >
                                               <p  style="width:100%;margin: 9px 15px;cursor: pointer;" v-for="(item,index) in searchData" :key="index" @click="setValue(item.RF_code)">{{ item.RF_code }} </p>
                                               <p v-if=" attendanceDate.RF_Person_Code.length > 1 && searchData.length < 1" style="width:100%;margin: 9px 15px;" > no data found like this RF code </p>
                                          </div>
                                    </div>

                                </div>

                                <div class="form-group form-row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">date</label>
                                    <div class="col-sm-3">
                                        <datepicker :inline="true"  format="dd-MM-yyyy" v-model="attendanceDate.date"></datepicker>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import Multiselect from "vue-multiselect";
    import axios from "axios";
    export default {
        data(){
            return{

                attendanceDate:{
                    name:'',
                    date:new Date(),
                    RF_Person_Code:''
                },

                searchData:[],
                 options: [],
            }
        },
        beforeCreate() {


            axios.get('allUsers')
            .then(res => {

                if(res.data.success){

                     this.options = res.data.users

                }

            })
            .catch(err => {

            })



        },
        components: {
            Datepicker,
            Multiselect,
        },

         watch: {
            item: {
                handler(val){
                    if(this.attendanceDate.RF_Person_Code.length < 1){
                        alert('gfffffffffffff')
                    }
                },
                deep: true
            }
        },

        methods: {
            setValue(val){

                this.attendanceDate.RF_Person_Code = val


            },
            searchInUsersByRFcode(){
                axios.get(`searchInUsersByRFcode/${this.attendanceDate.RF_Person_Code}`)
                .then(res => {

                    if(res.data.success){
                        this.searchData = res.data.users
                    }
                })
                .catch(err => {

                })
            }
        },


    }
</script>



