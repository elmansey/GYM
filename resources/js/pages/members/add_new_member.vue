<template>
    <div v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit member':'registeration a new member'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
                <button class="btn btn-success" @click="saveNotificationInFireBaseDatabase">try</button>
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="handelSubmitData" id="myform">

                                    <div class="row">


<!--                                            <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">personal information</div><br/>-->
                                            <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                <div class="col-form-label"> name</div>

                                                <input name="name" :class="['form-control',error.name? 'is-invalid' : '']" v-model="memberData.name"  />
                                             <small style="color: red" v-if="error.name">{{ error.name[0] }}</small >
                                            </div>


                                            <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                <div class="col-form-label"> Gender</div>

                                                <select name="gender"   :class="['form-control',error.gender? 'is-invalid' : '']"  v-model="memberData.gender" >
                                                    <option value="male">Male</option>
                                                    <option value="female">female </option>
                                                </select>
                                             <small style="color: red" v-if="error.gender">{{ error.gender[0] }}</small >
                                            </div>

                                            <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                <div class="col-form-label"> Date of birth </div>

                                                <input name="phone"  @change="countMemberAge" type="date"  :class="['form-control',error.data_of_birth? 'is-invalid' : '']"  v-model="memberData.data_of_birth"/>
                                             <small style="color: red" v-if="error.date_of_birth">{{ error.date_of_birth[0] }}</small >
                                            </div>

                                            <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                                <div class="col-form-label"> age </div>

                                                <input name="phone" readonly type="text"  :class="['form-control',error.age? 'is-invalid' : '']"  v-model="memberData.age"/>
                                             <small style="color: red" v-if="error.age">{{ error.age[0] }}</small >
                                            </div>





<!--                                        <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">contact information</div><br/>-->


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> address </div>

                                            <input name="address" :class="['form-control',error.address? 'is-invalid' : '']" v-model="memberData.address" />
                                             <small style="color: red" v-if="error.address">{{ error.address[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> City </div>

                                            <input name="city"  :class="['form-control',error.city? 'is-invalid' : '']"  v-model="memberData.city" />
                                             <small style="color: red" v-if="error.city">{{ error.city[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> phone number  </div>

                                            <input name="phone" :class="['form-control',error.phone? 'is-invalid' : '']" v-model="memberData.phone"/>
                                             <small style="color: red" v-if="error.phone">{{ error.phone[0] }}</small >
                                        </div>





                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> RF code  </div>

                                            <input name="" :class="['form-control',error.RF_code ? 'is-invalid' : '']" v-model="memberData.RF_code"  />
                                             <small style="color: red" v-if="error.RF_code">{{ error.RF_code[0] }}</small >
                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   start data  </div>

                                            <input name="" type="date" @change="setExpireDate"   :class="['form-control',error.start_date? 'is-invalid' : '']"  v-model="memberData.start_data" />
                                             <small style="color: red" v-if="error.start_date">{{ error.start_date[0] }}</small >
                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   membership  </div>

                                            <select name="membership"  @change="IsAllowFuatureInThisMembership" :class="['form-control',error.membership_id? 'is-invalid' : '']"  v-model="memberData.membership_id" >
                                                <option  :value="item.id" v-for="(item,index) in memberships"  :key="index">
                                                        {{ item.name }}
                                                </option>
                                            </select>
                                             <small style="color: red" v-if="error.membership_id">{{ error.membership_id[0] }}</small >
                                        </div>




                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label">    payment pattern  </div>

                                        <input name=""  readonly type="text"    :class="['form-control',error.payment? 'is-invalid' : '']"  v-model="memberData.payment" />
                                            <small style="color: red" v-if="error.payment">{{ error.payment[0] }}</small >
                                    </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   membership price  </div>

                                            <input name="" readonly type="text"    :class="['form-control',error.membership_price? 'is-invalid' : '']"  v-model="memberData.membership_price" />
                                            <small style="color: red" v-if="error.membership_price">{{ error.membership_price[0] }}</small >
                                        </div>


                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label">   Subscription period {{ this.memberData.payment ?  "(" + this.memberData.payment + ")" : ''}}  </div>

                                        <input name=""  type="number" @change="setExpireDate"   :class="['form-control',error.Subscription_period? 'is-invalid' : '']"  v-model="memberData.Subscription_period" />
                                            <small style="color: red" v-if="error.Subscription_period">{{ error.Subscription_period[0] }}</small >
                                    </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   period Expiry </div>

                                            <input name="" type="text"  readonly  :class="['form-control',error.period_Expiry? 'is-invalid' : '']"  v-model="memberData.period_Expiry" />
                                             <small style="color: red" v-if="error.period_Expiry">{{ error.period_Expiry[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">    total payment </div>

                                            <input name="" type="text"  readonly  :class="['form-control',error.total_payment? 'is-invalid' : '']"  v-model="memberData.total_payment" />
                                             <small style="color: red" v-if="error.total_payment">{{ error.total_payment[0] }}</small >
                                        </div>


                                             <!-- <div class="mb-2 col-md-12 col-lg-12 col-sm-12" v-if="memberData.Membership_choose_allow_private_Features">
                                                    <div class="col-form-label"> Group</div>

                                                    <select name="group" @change="getAllClasseRelatedToThisGroup" :class="['form-control',error.group_id ? 'is-invalid' : '']" v-model="memberData.group_id"  >
                                                        <option :value="item.id" v-for="(item,index) in groups"  :key="index">
                                                            {{ item.name }}
                                                        </option>
                                                    </select>
                                                <small style="color: red" v-if="error.group_id">{{ error.group_id[0] }}</small >
                                            </div> -->

                                            <div class="mb-2 col-md-12 col-lg-12 col-sm-12"  v-if="memberData.Membership_choose_allow_private_Features">
                                                      <div class="col-form-label">groups </div>

                                                      <multiselect name="group" @input="getAllClasseRelatedToThisGroup" v-model="memberData.group_id" tag-placeholder="Add this as new tag" placeholder="Search or add a tag"
                                                                    :class="[error.group_id ? 'is-invalid' : '']"     label="name" track-by="id"    :options="groups"  :multiple="true"   :taggable="true" @tag="addTag"  >

                                                      </multiselect>
                                                     <small style="color: red" v-if="error.group_id">{{ error.group_id[0] }}</small >

                                            </div>




                                            <div class="mb-2 col-md-12 col-lg- col-sm-12" v-if="memberData.Membership_choose_allow_private_Features && afterChooseGroup">
                                                <div class="col-form-label">   class <i class="icofont icofont-ui-calendar"></i>  </div>
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="datatable-vue m-0">
                                                                        <div class="table-responsive vue-smart">
                                                                            <b-table
                                                                                id="tablePrint"
                                                                                show-empty
                                                                                stacked="md"
                                                                                :items="classes"
                                                                                :fields="tablefields"
                                                                                :current-page="currentPage"
                                                                                :per-page="perPage"
                                                                            >

                                                                             <template #cell(ID)="data">
                                                                                {{ data.index + 1 }}
                                                                            </template>


                                                                             <template #cell(days)="data">
                                                                                    <span  style="display: block;" class="badge badge-pill badge-dark" v-if="data.item.days.length == 7">
                                                                                        every day
                                                                                    </span>

                                                                                    <span v-else style="display: block;margin:1px" class="badge badge-pill badge-dark" v-for="(val,ke) in data.item.days" :key="ke">
                                                                                        {{ val.name}}
                                                                                    </span>
                                                                            </template>

                                                                             <template #cell(startingTime)="data">
                                                                                    <td><span class="badge badge-pill badge-primary">{{ data.item.startingTime}}</span></td>
                                                                            </template>
                                                                             <template #cell(endingTime)="data">
                                                                                    <td><span class="badge badge-pill badge-primary">{{ data.item.endingTime}}</span></td>
                                                                            </template>

                                                                             <template #cell(countMember)="data">
                                                                                    <td><span class="badge badge-pill badge-dark">{{ data.item.countMember}}</span></td>
                                                                            </template>

                                                                            <template #cell(choose)="data">

                                                                                <div class=" " style="cursor: pointer;">
                                                                                    <input  type="checkbox" style="cursor: pointer;" :value="data.item.id"  v-model="memberData.class_id" />
                                                                                </div>
                                                                            </template>

                                                                        </b-table>
                                                                    </div>

                                                                    <!-- <b-col md="6" class="my-1">
                                                                            <b-pagination
                                                                            v-model="currentPage"
                                                                            :total-rows="totalRows"
                                                                            :per-page="perPage"
                                                                            class="my-0"
                                                                            ></b-pagination>
                                                                    </b-col> -->
                                                            </div>

                                                         </div>
                                                    </div>

                                                <small style="color: red" v-if="error.class_id">{{ error.class_id[0] }}</small >
                                            </div>


                                               <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                  <div class="col-form-label"> Upload profile picture</div>


                                                      <vue-dropzone
                                                          name="file"
                                                          ref="myVueDropzone"
                                                          id="singledropzone"
                                                          :options="singledropzoneOptions"
                                                          :class="['dropzone digits',error.password ? 'is-invalid' : '']"
                                                          @vdropzone-file-added="handleFileAdded"
                                                          @vdropzone-removed-file="removed"

                                                      >
                                                      </vue-dropzone>


                                                  <small style="color: red" v-if="error.profile_picture">{{ error.profile_picture[0]}}</small>
                                              </div>

                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">  interested area  </div>

                                           <textarea style="width: 100%"  :class="['form-control',error.interested_area? 'is-invalid' : '']"   v-model="memberData.interested_area"></textarea>
                                             <small style="color: red" v-if="error.interested_area">{{ error.interested_area[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">  source </div>

                                            <textarea style="width: 100%" :class="['form-control',error.source? 'is-invalid' : '']"  v-model="memberData.source"></textarea>
                                             <small style="color: red" v-if="error.source">{{ error.source[0] }}</small >
                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-4 col-sm-12">
                                                <button type="submit" class="btn btn-primary mt-3"  v-if="!edit" >
                                                    Save
                                                </button>

                                                <button  type="submit" class="btn btn-success mt-3"   v-if="edit" >
                                                    update
                                                </button>
                                        </div>

                                   </div>

                                </form>

                            </div>
                         </div>
                    </div>
                </div>

             </div>
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
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Multiselect from 'vue-multiselect'
import axios from 'axios'

import {database} from '../../firebase'

export default {
    data(){
        return{

            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            tablefields: [

                'ID',
                { key: 'group_relation.name', label: 'group', sortable: false, },
                'days',
                'startingTime',
                'endingTime',
                'countMember',
                { key: 'captain_relation.name', label: 'caption name', sortable: false, },
                 'choose',
            ],

            filter: {
                currentPage: 1,
                totalPages: 0,
            },
            memberData:{

                name:'',
                gender:'male',
                data_of_birth:'',
                group_id:[],

                period_Expiry:'',
                Subscription_period:'',
                age:'',

                total_payment:'',


                address:'',
                city:'',
                phone:'',


                RF_code:'',
                profile_picture:[],
                payment:'',

                interested_area:'',
                source:'',
                membership_id:'',
                class_id:[],
                start_data:'',
                membership_price:'',
                Membership_choose_allow_private_Features:false,

            },

            afterChooseGroup:false,


            isLoading:false,

            classes: [],
            groups: [],
            memberships: [],

            error:[],
            edit:true,


            singledropzoneOptions:{
                url:'http://127.0.0.1:8000/api/addMember',
                thumbnailWidth: 150,
                maxFiles:1,
                autoProcessQueue: false,
                maxFilesize: 2,
                acceptedFiles: ".jpg , .jpeg, .png",
                maxNumberOfFiles: 1,
                addRemoveLinks: true,
                dictDefaultMessage:
                    "<i class='icon-cloud-up'></i><br />Select Profile Picture",
            },







        }
    },

     components: {
        vueDropzone: vue2Dropzone,
        Multiselect

    },


    beforeCreate() {


    },

    beforeMount() {


            var today = new Date();
            var da = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            this.memberData.start_data =  da


            if(this.$route.params.memberId){

                    this.edit = true

                    axios.get(`getMemberById/${this.$route.params.memberId}`)
                    .then(res => {

                        if(res.data.success){

                            this.memberData.name     = res.data.extraInformation.name,
                            this.memberData.gender         = res.data.extraInformation.gender,
                            this.memberData.data_of_birth    = res.data.extraInformation.date_of_birth,
                            this.memberData.address         = res.data.extraInformation.address,
                            this.memberData.city          = res.data.extraInformation.city,
                            this.memberData.phone       = res.data.extraInformation.phone,
                            this.memberData.interested_area    = res.data.extraInformation.interested_area,
                             this.memberData.group_id    = res.data.extraInformation.group_id,
                            this.memberData.source    = res.data.extraInformation.source,
                            this.memberData.membership_id    = res.data.extraInformation.membership_id,
                            this.memberData.class_id    = res.data.extraInformation.class_id,
                            this.memberData.start_data    = res.data.extraInformation.start_date
                            this.memberData.RF_code    = res.data.extraInformation.RF_code
                            this.memberData.period_Expiry    = res.data.extraInformation.period_Expiry
                            this.memberData.total_payment    = res.data.extraInformation.total_payment
                            this.memberData.membership_price    = res.data.extraInformation.membership_price
                            this.memberData.Subscription_period    = res.data.extraInformation.Subscription_period
                            this.memberData.Membership_choose_allow_private_Features    = this.IsAllowFuatureInThisMembership()
                            this.getAllClasseRelatedToThisGroup()
                            this.countMemberAge()


                            this.isLoading = true

                        }


                    }).catch(err => {

                            console.log(err.message)
                    })


            }else{

                this.edit = false
                  this.edit = false
                this.memberData.name    = '',
                this.memberData.data_of_birth    = '',
                this.memberData.group_id    = [],
                this.memberData.address    = '',
                this.memberData.city    = '',
                this.memberData.phone   = '',
                this.memberData.interested_area    = '',
                this.memberData.source    = '',
                this.memberData.membership_id    = '',
                this.memberData.class_id    = [],
                this.memberData.RF_code    = ''
                this.memberData.RF_code    = ''
                this.memberData.period_Expiry    = ''
                this.memberData.Subscription_period    = ''
                this.memberData.total_payment    = ''
                this.memberData.payment    = ''
                this.memberData.profile_picture    = []
                this.memberData.membership_price    = ''
                this.classes = []
                this.memberData.age = ''
                this.memberData.Membership_choose_allow_private_Features = false
                this.afterChooseGroup = false
                this.isLoading = true

            }



            axios.get('memberships')
            .then(res => {

                if(res.data.success){
                    this.memberships = res.data.memberships
                }
            })
            .catch(err => {

               console.log(err.message)
            })

            axios.get('groups')
            .then(res => {

                 if(res.data.success){
                    this.groups = res.data.groups
                }

            })
            .catch(err => {
                console.log(err.message)
            })

            axios.get('getClassToSelect')
            .then(res => {


                  if(res.data.success){
                    this.classes = res.data.classes
                }

            })
            .catch(err => {
               console.log(err.message)
            })


            this.isLoading = true


    },



    methods: {



        saveNotificationInFireBaseDatabase(){

            var path = database.ref('notification');

            	path.push({
                    titel:'notification' ,
                    body: 'mohamed has added new member',
                    read: 0,
                }).then(() => {
                    console.log('sussess')
                }).catch(() => {
                    console.log('error')
                })

                // var db = database
                // var id = 11

                // set(ref(db, 'notification/'), {
                //          titel:'notification' ,
                //          body: 'mohamed has added new member',
                //          read: 0,
                //     })
                //     .then(() => {
                    
                //     })
                //     .catch((error) => {
                    
                //     });

        },


        asyncFind (query) {
            this.options = findService(query)
        },

        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.taggingOptions.push(tag)
            this.taggingSelected.push(tag)
        },

        countMemberAge(){

        var birthDate = new Date(this.memberData.data_of_birth)
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();

        this.memberData.age = age + '  year'

        },
        setExpireDate(){

             this.memberships.map((item,index) => {
                if(item.id == this.memberData.membership_id){

                    var start_date = new Date(this.memberData.start_data);

                    if(item.payment == 'Monthly'){
                        var Period = 30
                    }else if (item.payment == 'Weekly'){
                         Period = 7
                    }else if (item.payment == 'daily'){
                         Period = 1
                    }else if(item.payment == 'year'){
                         Period = 365
                    }

                   if(this.memberData.Subscription_period < 1 || this.memberData.Subscription_period == 0){

                       this.memberData.Subscription_period = 1
                   }else{
                       this.memberData.Subscription_period = this.memberData.Subscription_period
                   }



                    var Expiry_date = new Date(start_date.setDate(start_date.getDate() + Number(Number(this.memberData.Subscription_period) * Period )))
                    this.memberData.period_Expiry =  Expiry_date.getFullYear()+'-'+(Expiry_date.getMonth()+1)+'-'+Expiry_date.getDate();
                    this.memberData.membership_price  = item.Membership_price
                    this.memberData.total_payment  = Number(item.Membership_price) * Number(this.memberData.Subscription_period)

                }
            })

        },

        getAllClasseRelatedToThisGroup()
        {
            axios.post('getAllClasseRelatedToThisGroup',this.memberData.group_id)
            .then(res => {

                this.classes = res.data.classes
                this.afterChooseGroup = true

            })
            .catch(err => {
                console.error(err);
            })
        },

        IsAllowFuatureInThisMembership(){


                this.setExpireDate()


            axios.get(`IsAllowFuatureInThisMembership/${this.memberData.membership_id}`)
            .then(res => {


                if(res.data.success){
                    this.memberData.Membership_choose_allow_private_Features = res.data.allow
                    this.memberData.payment = res.data.memberShip.payment
                }


            })
            .catch(err => {
                console.error(err);
            })


        },

      handleFileAdded(file) {


            if (this.memberData.profile_picture.length < 1) {
                this.memberData.profile_picture = file;
            }

        },
        removed(files){

            if(files.name == this.memberData.profile_picture.name){

                this.memberData.profile_picture = []
            }
        },




        handelSubmitData(){

            if(this.edit == false){

                let formData = new FormData()
                formData.append('name'               , this.memberData.name)
                formData.append('gender'             , this.memberData.gender)
                formData.append('date_of_birth'      , this.memberData.data_of_birth)
                formData.append('group_id'           , JSON.stringify(this.memberData.group_id))
                formData.append('address'            , this.memberData.address)
                formData.append('city'               , this.memberData.city)
                formData.append('phone'            , this.memberData.phone)
                formData.append('interested_area'    , this.memberData.interested_area)
                formData.append('source'             , this.memberData.source)
                formData.append('membership_id'         , this.memberData.membership_id)
                formData.append('class_id'              , JSON.stringify(this.memberData.class_id))
                formData.append('start_date'         , this.memberData.start_data)
                formData.append('RF_code'           , this.memberData.RF_code)
                formData.append('profile_picture'           , this.memberData.profile_picture)
                formData.append('period_Expiry'           , this.memberData.period_Expiry)
                formData.append('Subscription_period'           , this.memberData.Subscription_period)
                formData.append('total_payment'           , this.memberData.total_payment)
                formData.append('payment'           , this.memberData.payment)
                formData.append('membership_price'           , this.memberData.membership_price)
                formData.append('Membership_choose_allow_private_Features'      , this.memberData.Membership_choose_allow_private_Features)


                let config = {
                    headers:{
                        "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                    }
                }

                axios.post('addMember',formData,config)
                .then(res => {

                    if(res.data.success == false){

                             this.error = res.data.message
                    }

                    if(res.data.success){

                        this.error = []
                         this.memberData.name    = '',
                        this.memberData.data_of_birth    = '',
                        this.memberData.group_id    = [],
                        this.memberData.address    = '',
                        this.memberData.city    = '',
                        this.memberData.phone   = '',
                        this.memberData.interested_area    = '',
                        this.memberData.source    = '',
                        this.memberData.membership_id    = '',
                        this.memberData.class_id    = [],
                        this.memberData.RF_code    = ''
                        this.memberData.RF_code    = ''
                        this.memberData.period_Expiry    = ''
                        this.memberData.Subscription_period    = ''
                        this.memberData.total_payment = ''
                        this.memberData.payment = ''
                        this.memberData.membership_price = ''
                        this.memberData.profile_picture    = []
                           Toast.fire({
                            icon: 'success',
                            title: 'new member added successfully'
                        })

                        this.$router.push({name:'membersList'})



                    }




                    console.log(res)
                })
                .catch(err => {

                    console.log(err)

                })

            }

            if(this.edit){


                let formData = new FormData()
                formData.append('name'         , this.memberData.name)
                formData.append('gender'             , this.memberData.gender)
                formData.append('date_of_birth'      , this.memberData.data_of_birth)
                formData.append('group_id'           ,  JSON.stringify(this.memberData.group_id))
                formData.append('address'            , this.memberData.address)
                formData.append('city'               , this.memberData.city)
                formData.append('phone'             , this.memberData.phone)
                formData.append('interested_area'    , this.memberData.interested_area)
                formData.append('source'             , this.memberData.source)
                formData.append('membership_id'         , this.memberData.membership_id)
                formData.append('class_id'              , JSON.stringify( this.memberData.class_id))
                formData.append('start_date'         , this.memberData.start_data)
                formData.append('RF_code'           , this.memberData.RF_code)
                formData.append('profile_picture'           , this.memberData.profile_picture)
                formData.append('period_Expiry'           , this.memberData.period_Expiry)
                formData.append('total_payment'           , this.memberData.total_payment)
                formData.append('payment'           , this.memberData.total_payment)
                formData.append('membership_price'           , this.memberData.membership_price)
                formData.append('Subscription_period'           , this.memberData.Subscription_period)
                formData.append('Membership_choose_allow_private_Features'           , this.memberData.Membership_choose_allow_private_Features)



                let config = {
                    headers:{
                        "Content-Type":"multipart/form-data; charset=utf-8 ; boundary="+ Math.random().toString().substr(2),
                    }
                }

                axios.post(`updateMember/${this.$route.params.memberId}`,formData,config)
                .then(res => {

                    if(res.data.success == false){

                             this.error = res.data.message
                    }

                    if(res.data.success){

                        this.error = []
                        this.memberData.name    = '',
                        this.memberData.data_of_birth    = '',
                        this.memberData.group_id    = [],
                        this.memberData.address    = '',
                        this.memberData.city    = '',
                        this.memberData.phone   = '',
                        this.memberData.interested_area    = '',
                        this.memberData.source    = '',
                        this.memberData.membership_id    = '',
                        this.memberData.class_id    = [],
                        this.memberData.RF_code    = ''
                        this.memberData.RF_code    = ''
                        this.memberData.period_Expiry    = ''
                        this.memberData.Subscription_period    = ''
                        this.memberData.total_payment    = ''
                        this.memberData.payment    = ''
                        this.memberData.profile_picture    = []
                        this.memberData.membership_price    = ''
                        this.classes = []
                        this.memberData.age = ''
                        this.memberData.Membership_choose_allow_private_Features = false

                           Toast.fire({
                            icon: 'success',
                            title: 'member updated successfully'
                        })

                        this.$router.push({name:'membersList'})



                    }




                    console.log(res)
                })
                .catch(err => {

                    console.log(err)

                })

            }



        }


    },

    watch:{


        $route(to,from){
            if(to.name == 'addMember'){
                this.edit = false
                this.memberData.name    = '',
                this.memberData.data_of_birth    = '',
                this.memberData.group_id    = [],
                this.memberData.address    = '',
                this.memberData.city    = '',
                this.memberData.phone   = '',
                this.memberData.interested_area    = '',
                this.memberData.source    = '',
                this.memberData.membership_id    = '',
                this.memberData.class_id    = [],
                this.memberData.RF_code    = ''
                this.memberData.RF_code    = ''
                this.memberData.period_Expiry    = ''
                this.memberData.Subscription_period    = ''
                this.memberData.total_payment    = ''
                this.memberData.payment    = ''
                this.memberData.profile_picture    = []
                this.memberData.membership_price    = ''
                this.classes = []
                this.memberData.age = ''
                this.memberData.Membership_choose_allow_private_Features = false
                this.afterChooseGroup = false
                this.isLoading = true


            }
        }

    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
