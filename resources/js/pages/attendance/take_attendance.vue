<template>
    <div>
        <Breadcrumbs main="dashboard" title="take attendance"/>
        <!-- Container-fluid starts-->

        <!-- <b-alert style="position: absolute;top: 55px;z-index: 10000;width:30%;right: 40px;border-radius: 20px;" :show="show" variant="light">
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

        </b-alert> -->


        <div class="container-fluid">





                <!-- <div class="col-lg-12" style="padding:0px">
                    <div class="card">
                        <div class="col-lg-4">
                                   <form  @submit.prevent="saveAttendance" class="form theme-form datepicker-responsive">
                            <div class="card-body">

                                    <div class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml">
										<div class="radio radio-primary d-inline-block">
											<b-form-radio name="radio3" value="name" v-model="type">name</b-form-radio>
										</div>
										<div class="radio radio-primary d-inline-block">
											<b-form-radio name="radio3" value="RF_Person_Code" v-model="type"> RF code</b-form-radio>
										</div>

									</div>
                                <div class="form-group form-row" v-if="type == 'name'">
                                     <label class="col-sm-3 col-form-label text-right">name</label>
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
                                                :class="[!$v.attendanceDate.name.requiredIf ? 'is-invalid' : '']"

                                            >
                                            </multiselect>
                                           <small style="color:red" v-if="( submited &&  !$v.attendanceDate.name.requiredIf)"> the  name  failde is required   </small>

                                    </div>

                                </div>



                                <div class="form-group form-row" v-if="type == 'RF_Person_Code'">
                                    <label class="col-sm-3 col-form-label text-right"> RF code</label>
                                    <div class="col-xl-5 col-sm-9" style="height:125px;overflow:scroll">
                                        <input  type="text"  :class="['form-control', submited && !$v.attendanceDate.RF_Person_Code.requiredIf  ? 'is-invalid' : '']" style="margin: 10px;width: 96%;" @keyup="searchInUsersByRFcode" v-model="attendanceDate.RF_Person_Code" placeholder="type or search by RF code"/>
                                        <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.attendanceDate.RF_Person_Code.requiredIf)"> the  RF code  failde is required   </b-form-invalid-feedback>

                                          <div style="width: 100%" >
                                               <p  style="width:100%;margin: 9px 15px;cursor: pointer;" v-for="(item,index) in searchData" :key="index" @click="setValue(item.RF_code)">{{ item.RF_code }} </p>
                                               <p v-if=" attendanceDate.RF_Person_Code.length > 1 && searchData.length < 1" style="width:100%;margin: 9px 15px;" > no data found like this RF code </p>

                                          </div>


                                    </div>

                                </div>

                                <div class="form-group form-row mb-0">
                                    <label class="col-sm-3 col-form-label text-right">date</label>
                                    <div class="col-sm-3">

                                        <datepicker     :inline="true"  format="dd-MM-yyyy" v-model="attendanceDate.date"></datepicker>
                                        <small style="color: red"  v-if="error.date">{{ error.date[0] }}</small>
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
                 -->






                    <!-- <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                    </div> -->

                <div class="card">

                    <div class="row" style="height:100%">

                            <div class="col-lg-4 ">

                                    <form  @submit.prevent="saveAttendance">
                                        <div class="card-body" style="height:100%;border-left: 1px solid #EFEFEF;">
                                            <div class="form-group  mb-0">
                                                <div class="col-lg-12" style="margin-bottom:20px">
                                                    <multiselect

                                                            tag-placeholder="Add this as new tag"
                                                            placeholder="Search  or choose "
                                                            v-model="attendanceDate.select.name"
                                                            label="name"
                                                            track-by="id"

                                                            :options="options"
                                                            :multiple="false"
                                                            :taggable="false"
                                                            style="margin:0px;padding:0px"
                                                        >
                                                        </multiselect>
                                                        <small style="color: red"  v-if="error.name">{{ error.name[0] }}</small>

                                                </div>

                                                <div class="col-lg-12" style="margin-bottom:20px">
                                                        <input type="time"  class="form-control" v-model="attendanceDate.select.time"/>
                                                        <small style="color: red"  v-if="error.time">{{ error.time[0] }}</small>
                                                </div>



                                                <div class="col-lg-12" style="margin-bottom:20px">
                                                    <datepicker  @input="handelData" class="my-datepicker" calendar-class="my-datepicker_calendar"  :inline="true"  format="dd-MM-yyyy" v-model="attendanceDate.select.date"></datepicker>
                                                    <small style="color: red"  v-if="error.date">{{ error.date[0] }}</small>
                                                </div>
                                            </div>

                                            <div class="form-group form-row mb-0">

                                                <div class="col-lg-12 m-t-10">
                                                        <button id="default-custom-success" type="submit" class="btn   btn-dark">save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>


                            <div  class="col-lg-4 ">
                                <div class="card-body" style="height:100%;border-left: 1px solid #EFEFEF;">
                                    <input  id="mytext"  @keyup.enter="handelAttendanceByScan" type="text" v-model="attendanceDate.scan.RF_code" placeholder="RF code" style="width: 100%; padding: 8px;border: 1px solid #EFEFEF"/>
                                </div>
                            </div>



                            <div class="col-lg-4 "  >
                                    <div class="card-body" style="border-left: 1px solid #EFEFEF;padding:20px">
                                           <div class="row" >
                                            <div class="col-lg-12" style="overflow:scroll;padding:5px;">
                                                <input  type="text"
                                                 :class="['form-control']" style="margin-top: 16px;width: 100%;"  v-model="RF_Person_Code" placeholder=" search by RF code"   />

                                            </div>

                                            <div v-if="isLoadig" class="col-lg-12" style="height:600px;overflow:scroll!important" >
                                                <div v-for="(item,index) in search" :key="index">
                                                        <section class=" dashboard-list-with-user ">
                                                            <div class="d-flex flex-row   border-bottom" style=" margin-top: 4px;padding: 6px;">


                                                                <img
                                                                :src="item.profile_picture ? '../../profile_pictures/'+item.profile_picture :
                                                                    '../../profile_pictures/DefaultProfile.jpg'"
                                                                alt=""  style="width:50px;height:50px" class="img-thumbnail  border-0 rounded-circle list-thumbnail align-self-center xsmall">

                                                                    <div class="pl-3 pr-2">

                                                                        <p class="font-weight-medium mb-0">{{ item.name }}</p>
                                                                        <p class="text-muted mb-0 text-small">{{ item.RF_code }}</p>

                                                                    </div>
                                                            </div>
                                                    </section>
                                                </div>
                                            </div>

                                              <div
                                                v-else
                                                class="col-md-3"
                                                style="width: 60px!important;height: 60px!important;margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);"
                                            >


                                                <h6 class="sub-title mb-0 text-center"></h6>
                                                <div class="loader-box">
                                                    <div class="loader-15"></div>
                                                </div>
                                            </div>



                                           </div>
                                    </div>


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
    import {

      requiredIf,


      } from 'vuelidate/lib/validators'

    export default {
        data(){
            return{

                attendanceDate:{

                    select:{
                        name:[],
                        date:'',
                        time:'',
                        type:'select'
                    },

                    scan:{
                        RF_code:'',
                        type:'scan'
                    }

                },



                RF_Person_Code:'',
                type:'RF_Person_Code',
                show:false,
                searchData:[],
                 options: [],
                 responseUserData:[],
                 error:[],
                 submited:false,
                 isLoadig:false
            }
        },
        beforeCreate() {





        },
        mounted() {


                document.getElementById("mytext").focus();

        },

        beforeMount(){


               var today = new Date();
                var da = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                this.attendanceDate.select.date =  da

                this.getAllPersonToAttendance()


        },
        computed:{

            search(){
                 return  this.searchData.filter(item => {
                                                //match
                    return item.RF_code.includes((this.RF_Person_Code).toLowerCase())
                })
            }

        },

        components: {
            Datepicker,
            Multiselect,
        },

    //  validations:{

    //     attendanceDate:{
    //          name:{

    //             requiredIf:requiredIf( function(){
    //                 return   (this.type == 'name')
    //             })

    //         },

    //          RF_Person_Code:{

    //             requiredIf:requiredIf( function(){
    //                 return   (this.type == 'RF_Person_Code')
    //             })

    //         },
    //     }
    //  },

        methods: {



            //  date
            handelData(){
                var today = new Date(this.attendanceDate.select.date);
                var da = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                this.attendanceDate.select.date =  da
            },


            handelAttendanceByScan(){

                let formData  = new FormData();
                formData.append('RF_code',this.attendanceDate.scan.RF_code)
                formData.append('type',this.attendanceDate.scan.type)

                  axios.post('saveAttendance',formData)
                    .then(res => {

                        if(res.data.success){

                            if(res.data.status == 'leave'){


                                this.$notify({
                                    group: 'app',
                                    type: 'success',
                                    duration: 10000,
                                    speed: 1000,
                                    title: 'attendance success',
                                    text: 'god bay ' + '<span>' + res.data.how.name+ '</span>' + ' <h6> leave </h6> ' +
                                    'in '+res.data.attendance.leave_time
                                });

                            }

                            if(res.data.status == 'come'){

                                this.$notify({
                                    type: 'success',
                                    group:"app",
                                    duration: 10000,
                                      speed: 1000,
                                    title: 'attendance success',
                                    text: 'welcome ' + '<span>' + res.data.how.name+ '</span>' + ' <h6> come </h6> ' +
                                    'in '+res.data.attendance.come_time
                                });

                            }


                        }
                        if(res.data.status == 400){
                              this.$notify({
                                    group:"app",
                                    type: 'danger',
                                    duration: 10000,
                                    speed: 1000,
                                    title: 'attendance are already taken ',
                                    text: '<p> attendance are already taken</p>'
                                });
                        }

                    }).catch(err => {

                    })



            },

            saveAttendance(){

                    let formData  = new FormData();

                    formData.append('name',JSON.stringify(this.attendanceDate.select.name))
                    formData.append('date',this.attendanceDate.select.date)
                    formData.append('time',this.attendanceDate.select.time)
                    formData.append('type',this.attendanceDate.select.type)



                    axios.post('saveAttendance',formData)
                    .then(res => {

                        if(res.data.success){

                            if(res.data.status == 'leave'){


                                this.$notify({
                                    group: 'app',
                                    type: 'success',
                                    duration: 10000,
                                    speed: 1000,
                                    title: 'attendance success',
                                    text: 'god bay ' + '<span>' + res.data.how.name+ '</span>' + ' <h6> leave </h6> ' +
                                    'in '+res.data.attendance.leave_time
                                });

                            }

                            if(res.data.status == 'come'){

                                this.$notify({
                                    type: 'success',
                                    group:"app",
                                    duration: 10000,
                                      speed: 1000,
                                    title: 'attendance success',
                                    text: 'welcome ' + '<span>' + res.data.how.name+ '</span>' + ' <h6> come </h6> ' +
                                    'in '+res.data.attendance.come_time
                                });

                            }


                        }
                        if(res.data.status == 400){
                              this.$notify({
                                    group:"app",
                                    type: 'danger',
                                    duration: 10000,
                                    speed: 1000,
                                    title: 'attendance are already taken ',
                                    text: '<p> attendance are already taken</p>'
                                });
                        }

                 })
                 .catch(err => {



                 })

            },



            setValue(val){

                this.attendanceDate.RF_Person_Code = val
                this.searchData = []

            },

            getAllPersonToAttendance(){
                axios.get('getAllPersonToAttendance')
                .then(res => {

                    if(res.data.success){
                        this.searchData = res.data.users
                        this.options = res.data.users
                        this.isLoadig = true
                    }
                })
                .catch(err => {

                })
            }
        },


        watch:{

            searchWatch:function(searchData){

                if(this.attendanceDate.RF_Person_Code.length < 1){

                    searchData = []
                }

            }

        }


    }
</script>



<style scoped>

.my-datepicker >>> .my-datepicker_calendar {
  width: 100%!important;
}

::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
};

</style>
