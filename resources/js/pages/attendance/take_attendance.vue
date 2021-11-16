<template>
    <div>
        <Breadcrumbs main="dashboard" title="take attendance"/>
        <!-- Container-fluid starts-->

        <b-alert style="position: absolute;top: 55px;z-index: 10000;width:30%;right: 40px;border-radius: 20px;" :show="show" variant="light">
                            <h4 class="alert-heading">Well done!</h4>




                                        <div class="card-body "  >
                                                <div class="d-flex flex-row pb-1">

                                                    <img
                                                    alt=""
                                                    :src=" responseUserData.profile_picture   ? '../../profile_pictures/'+responseUserData.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                    class="img-thumbnail  border-0 rounded-circle  mr-3  list-thumbnail align-self-center "
                                                    style="width:40px;hight:40px"
                                                    >



                                                    <div class="d-flex flex-grow-1 min-width-zero">
                                                        <div class="m-2 pl-0  align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero ">
                                                            <div class="min-width-zero">
                                                                <p>{{ responseUserData.name }}</p>
                                                                <p class="mb-0 truncate list-item-heading">

                                                                    {{ responseUserData.RF_code }}


                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>







        </b-alert>
        <div class="container-fluid">

            <div class="row">



                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>take attendance</h5>

                        </div>
                        <form  @submit.prevent="saveAttendance" class="form theme-form datepicker-responsive">
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

                                <div class="form-group form-row mb-0">

                                    <div class="col-lg-12 m-t-10">
                                            <button id="default-custom-success" type="submit" class="btn btn-pill btn-air-success btn-success">save</button>
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
                    date:new Date().toLocaleDateString("en-US"),
                    RF_Person_Code:''
                },
                show:false,
                searchData:[],
                 options: [],
                 responseUserData:[]
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



        methods: {



            saveAttendance(){

                let formData  = new FormData();

                formData.append('name',JSON.stringify(this.attendanceDate.name))
                formData.append('date',this.attendanceDate.date)
                formData.append('RF_Person_Code',this.attendanceDate.RF_Person_Code)

                 axios.post('saveAttendance',formData)
                 .then(res => {
                    if(res.data.success){
                         this.attendanceDate={
                            name:'',
                            date:new Date(),
                            RF_Person_Code:''
                        },
                        this.searchData = []
                         this.show = true
                        this.responseUserData = res.data.attendance.userRelation

                        setTimeout(() => {
                            this.show = false
                        }, 4000);
                    }
                 })
                 .catch(err => {



                 })



            },


            setValue(val){

                this.attendanceDate.RF_Person_Code = val
                this.searchData = []

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



