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

                    <div class="row" style="height:600px">

                            <div class="col-lg-4 ">
                                    <div class="card-body" style="height:100%;border-left: 1px solid #EFEFEF;">
                                        <div class="form-group  mb-0">
                                             <div class="col-lg-12" style="margin-bottom:20px">
                                                <multiselect


                                                        tag-placeholder="Add this as new tag"
                                                        placeholder="Search  or choose "
                                                        v-model="attendanceDate.name"
                                                        label="name"
                                                        track-by="id"

                                                        :options="options"
                                                        :multiple="false"
                                                        :taggable="false"
                                                        :class="[!$v.attendanceDate.name.requiredIf ? 'is-invalid' : '']"
                                                        style="margin:0px;padding:0px"
                                                    >
                                                    </multiselect>
                                                    <small style="color:red" v-if="( submited &&  !$v.attendanceDate.name.requiredIf)"> the  name  failde is required   </small>

                                             </div>

                                             <div class="col-lg-12" style="margin-bottom:20px">
                                                    <input type="time"  class="form-control"/>
                                                    <small style="color: red"  v-if="error.date">{{ error.date[0] }}</small>

                                             </div>

                                            <div class="col-lg-12" style="margin-bottom:20px">
                                                <datepicker  class="my-datepicker" calendar-class="my-datepicker_calendar"  :inline="true"  format="dd-MM-yyyy" v-model="attendanceDate.date"></datepicker>
                                                <small style="color: red"  v-if="error.date">{{ error.date[0] }}</small>
                                            </div>
                                        </div>

                                        <div class="form-group form-row mb-0">

                                            <div class="col-lg-12 m-t-10">
                                                    <button id="default-custom-success" type="submit" class="btn   btn-dark">save</button>
                                            </div>
                                        </div>
                                </div>

                            </div>


                                <div style="overflow:scroll" class="col-lg-4 ">
                                    <div class="card-body" style="height:100%;border-left: 1px solid #EFEFEF;">
                                        <input type="text" class="form-control" />
                                    </div>
                                </div>




                            <div class="col-lg-4 " style="height: 100%;">
                                    <div class="card-body" style="height:100%;border-left: 1px solid #EFEFEF;padding:20px">
                                        <form  @submit.prevent="saveAttendance" class="form theme-form datepicker-responsive">


                                            <!-- <div class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml">
                                                <div class="radio radio-primary d-inline-block">
                                                    <b-form-radio name="radio3" value="name" v-model="type">name</b-form-radio>
                                                </div>
                                                <div class="radio radio-primary d-inline-block">
                                                    <b-form-radio name="radio3" value="RF_Person_Code" v-model="type"> RF code</b-form-radio>
                                                </div>

                                            </div> -->

                                            <!-- <div class="form-group" v-if="type == 'name'">
                                                <label class=" col-form-label text-right">name</label>
                                                <div class="col-lg-12">


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

                                            </div> -->




                                            <div class="col-lg-12" style="overflow:scroll;padding:5px;">
                                                <input  type="text" autofocus :class="['form-control', submited && !$v.attendanceDate.RF_Person_Code.requiredIf  ? 'is-invalid' : '']" style="margin-top: 16px;width: 100%;" @keyup="searchInUsersByRFcode" v-model="attendanceDate.RF_Person_Code" placeholder="type or search by RF code"/>
                                                <b-form-invalid-feedback style="color:red" v-if="( submited && !$v.attendanceDate.RF_Person_Code.requiredIf)"> the  RF code  failde is required   </b-form-invalid-feedback>

                                                <!-- <div style="width: 100%" >
                                                    <p  style="width:100%;margin: 9px 15px;cursor: pointer;" v-for="(item,index) in searchData" :key="index" @click="setValue(item.RF_code)">{{ item.RF_code }} </p>
                                                    <p v-if=" attendanceDate.RF_Person_Code.length > 1 && searchData.length < 1" style="width:100%;margin: 9px 15px;" > no data found like this RF code </p>

                                                </div> -->
                                                <div v-for="(item,index) in searchData" :key="index">
                                                    <section class="ps-container scroll dashboard-list-with-user ps">
                                                        <div class="d-flex flex-row  border-bottom" style="margin:10px">


                                                                <div class="pl-3 pr-2">

                                                                    <p class="font-weight-medium mb-0">{{ item.RF_code }}</p>

                                                                </div>
                                                        </div>
                                                    </section>
                                                </div>



                                            </div>

                                        </form>
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
                    name:[],
                    date:'',
                    RF_Person_Code:''
                },
                type:'RF_Person_Code',
                show:false,
                searchData:[],
                 options: [],
                 responseUserData:[],
                 error:[],
                 submited:false
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

        beforeMount(){

                var today = new Date();
                var da = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                this.attendanceDate.date =  da


        },
        components: {
            Datepicker,
            Multiselect,
        },

     validations:{

        attendanceDate:{
             name:{

                requiredIf:requiredIf( function(){
                    return   (this.type == 'name')
                })

            },

             RF_Person_Code:{

                requiredIf:requiredIf( function(){
                    return   (this.type == 'RF_Person_Code')
                })

            },
        }
     },

        methods: {



            saveAttendance(){


                var today = new Date(this.attendanceDate.date);
                var da = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                this.attendanceDate.date =  da

                 this.$v.attendanceDate.$touch();
                 this.submited = true

                if(!this.$v.attendanceDate.$invalid){






                let formData  = new FormData();

                formData.append('name',JSON.stringify(this.attendanceDate.name))
                formData.append('date',this.attendanceDate.date)
                formData.append('RF_Person_Code',this.attendanceDate.RF_Person_Code)
                formData.append('type',this.type)

                 axios.post('saveAttendance',formData)
                 .then(res => {
                    if(res.data.success){
                         this.attendanceDate = {
                            name:'',
                            RF_Person_Code:''
                        },

                         this.type = 'RF_Person_Code',
                         this.submited = false
                         this.searchData = []
                         this.show = true
                        this.responseUserData = res.data.attendance.userRelation


                        setTimeout(() => {
                            this.show = false
                        }, 4000);



                    } else if(res.data.success == false){

                        this.error = res.data.message

                    }
                    else if (res.data.status == '400'){

                        this.attendanceDate = {
                            name:'',
                            RF_Person_Code:''
                        },
                         this.submited = false
                          this.searchData = []
                         Toast.fire({
                            icon: 'error',
                            title: 'attendance aready taken'
                        })
                    }
                 })
                 .catch(err => {



                 })
                }




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



<style scoped>

.my-datepicker >>> .my-datepicker_calendar {
  width: 260px;
}

::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
};

</style>
