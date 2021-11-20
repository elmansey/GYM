<template>
    <div v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit member':'registeration a new member'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
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

                                                <input name="phone" type="date"  :class="['form-control',error.data_of_birth? 'is-invalid' : '']"  v-model="memberData.data_of_birth"/>
                                             <small style="color: red" v-if="error.data_of_birth">{{ error.data_of_birth[0] }}</small >
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
                                            <div class="col-form-label">  email  </div>

                                            <input name="" :class="['form-control',error.email? 'is-invalid' : '']"  v-model="memberData.email"  />
                                             <small style="color: red" v-if="error.email">{{ error.email[0] }}</small >
                                        </div>



<!--                                        <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">login information</div><br/>-->

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">  user name  </div>

                                            <input name="" :class="['form-control',error.user_name? 'is-invalid' : '']"  v-model="memberData.user_name"  />
                                             <small style="color: red" v-if="error.user_name">{{ error.user_name[0] }}</small >
                                        </div>



                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">  password  </div>

                                            <input name="" :class="['form-control',error.password? 'is-invalid' : '']"  v-model="memberData.password" />
                                             <small style="color: red" v-if="error.password">{{ error.password[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> Confirm password  </div>

                                            <input name="" :class="['form-control',error.confirm_password? 'is-invalid' : '']" v-model="memberData.confirm_password"  />
                                             <small style="color: red" v-if="error.confirm_password">{{ error.confirm_password[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> RF code  </div>

                                            <input name="" :class="['form-control',error.RF_code ? 'is-invalid' : '']" v-model="memberData.RF_code"  />
                                             <small style="color: red" v-if="error.RF_code">{{ error.RF_code[0] }}</small >
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">   start data  </div>

                                            <input name="" type="date"    :class="['form-control',error.start_date? 'is-invalid' : '']"  v-model="memberData.start_data" />
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
                                            <div class="col-form-label">   amount paid  </div>

                                            <input name="" readonly type="text"    :class="['form-control',error.amount_paid? 'is-invalid' : '']"  v-model="memberData.amount_paid" />
                                             <small style="color: red" v-if="error.amount_paid">{{ error.amount_paid[0] }}</small >
                                        </div>

                                             <div class="mb-2 col-md-12 col-lg-12 col-sm-12" v-if="memberData.Membership_choose_allow_private_Features">
                                                    <div class="col-form-label"> Group</div>

                                                    <select name="group" @change="getAllClasseRelatedToThisGroup" :class="['form-control',error.group_id ? 'is-invalid' : '']" v-model="memberData.group_id"  >
                                                        <option :value="item.id" v-for="(item,index) in groups"  :key="index">
                                                            {{ item.name }}
                                                        </option>
                                                    </select>
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
                                                                                    <div class="radio radio-primary " style="cursor: pointer;">
                                                                                    <b-form-radio name="radio1" style="cursor: pointer;" :value="data.item.id"  v-model="memberData.class_id"></b-form-radio>
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
                                                    class="dropzone digits"
                                                    @vdropzone-file-added="handleFileAdded"
                                                    @vdropzone-removed-file="removed"

                                                >
                                                </vue-dropzone>

                                             <small style="color: red" v-if="error.profile_picture">{{ error.profile_picture[0] }}</small >
                                        </div>


<!--                                        <div  class="mb-2 col-md-12 col-lg-12 col-sm-12">extra information</div><br/>-->



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











                                     <div class="mb-2  mt-4 col-md-12 col-lg-12 col-sm-12">

                                           <div class="media">
                                                <label class="col-form-label m-r-10">active</label>
                                                <div class="media-body text-right icon-state">
                                                <label class="switch">
                                                    <input type="checkbox" checked="" v-model="memberData.isActive"><span class="switch-state bg-primary"></span>
                                                </label>
                                            </div>
                                        </div>
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

import axios from 'axios'

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
                group_id:'',

                amount_paid:'',




                address:'',
                city:'',
                phone:'',
                email:'',


                user_name:'',
                password:'',
                confirm_password:'',
                profile_picture:[],
                role:{'id':3,'name':'member'},
                RF_code:'',


                interested_area:'',
                source:'',
                membership_id:'',
                class_id:'',
                start_data:'',
                isActive:true,
                Membership_choose_allow_private_Features:false,

            },

            afterChooseGroup:false,

            Membership_choose_allow_private_Features:false,

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
        vueDropzone: vue2Dropzone

    },

    beforeCreate() {


    },

    beforeMount() {


            if(this.$route.params.memberId){

                    this.edit = true

                    axios.get(`getMemberById/${this.$route.params.memberId}`)
                    .then(res => {

                        if(res.data.success){
                             this.memberData.name     = res.data.personalInformation.name,
                            this.memberData.gender         = res.data.personalInformation.gender,
                            this.memberData.data_of_birth    = res.data.personalInformation.date_of_birth,
                            this.memberData.address         = res.data.contentInformation.address,
                            this.memberData.city          = res.data.contentInformation.city,
                            this.memberData.phone       = res.data.loginInformation.phone,
                            this.memberData.email         = res.data.loginInformation.email,
                            this.memberData.user_name      = res.data.loginInformation.user_name,
                            this.memberData.interested_area    = res.data.extraInformation.interested_area,
                             this.memberData.group_id    = res.data.extraInformation.group_id,
                            this.memberData.source    = res.data.extraInformation.source,
                            this.memberData.membership_id    = res.data.extraInformation.membership_id,
                            this.memberData.class_id    = res.data.extraInformation.class_id,
                            this.memberData.start_data    = res.data.extraInformation.start_date
                            this.memberData.isActive    = res.data.loginInformation.isActive
                            this.memberData.RF_code    = res.data.loginInformation.RF_code
                            this.memberData.amount_paid    = res.data.extraInformation.amount_paid
                            this.memberData.Membership_choose_allow_private_Features    = this.IsAllowFuatureInThisMembership()


                            this.isLoading = true

                        }


                    }).catch(err => {

                            console.log(err.message)
                    })


            }else{

                this.edit = false
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

        getAllClasseRelatedToThisGroup()
        {
            axios.get(`getAllClasseRelatedToThisGroup/${this.memberData.group_id}`)
            .then(res => {
                console.log(res)
            })
            .catch(err => {
                console.error(err);
            })
        },

        IsAllowFuatureInThisMembership(){

            axios.get(`IsAllowFuatureInThisMembership/${this.memberData.membership_id}`)
            .then(res => {


                if(res.data.success){
                    this.memberData.Membership_choose_allow_private_Features = res.data.allow
                    this.memberData.amount_paid = res.data.memberShip.Membership_price
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
                formData.append('data_of_birth'      , this.memberData.data_of_birth)
                formData.append('group_id'           , this.memberData.group_id)
                formData.append('address'            , this.memberData.address)
                formData.append('city'               , this.memberData.city)
                formData.append('phone'            , this.memberData.phone)
                formData.append('email'               , this.memberData.email)
                formData.append('user_name'           , this.memberData.user_name)
                formData.append('password'           , this.memberData.password)
                formData.append('role'               , JSON.stringify(this.memberData.role))
                formData.append('confirm_password'   , this.memberData.confirm_password)
                formData.append('profile_picture'    , this.memberData.profile_picture)
                formData.append('interested_area'    , this.memberData.interested_area)
                formData.append('source'             , this.memberData.source)
                formData.append('membership_id'         , this.memberData.membership_id)
                formData.append('class_id'              , this.memberData.class_id)
                formData.append('start_date'         , this.memberData.start_data)
                formData.append('isActive'           , this.memberData.isActive)
                formData.append('RF_code'           , this.memberData.RF_code)
                formData.append('amount_paid'           , this.memberData.amount_paid)
                formData.append('Membership_choose_allow_private_Features'           , this.memberData.Membership_choose_allow_private_Features)








                 let config = {
                    headers: {
                        "Content-Type":
                            "multipart/form-data; charset=utf-8 ; boundary=" +
                            Math.random()
                                .toString()
                                .substr(2)
                    }
                };




                axios.post('addMember',formData,config)
                .then(res => {

                    if(res.data.success == false){

                             this.error = res.data.message
                    }

                    if(res.data.success){

                        this.error = []
                        this.memberData = []
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
                formData.append('data_of_birth'      , this.memberData.data_of_birth)
                formData.append('group_id'           , this.memberData.group_id)
                formData.append('address'            , this.memberData.address)
                formData.append('city'               , this.memberData.city)
                formData.append('phone'             , this.memberData.phone)
                formData.append('email'              , this.memberData.email)
                formData.append('user_name'           , this.memberData.user_name)
                formData.append('password'           , this.memberData.password)
                formData.append('role'               , JSON.stringify(this.memberData.role))
                formData.append('confirm_password'   , this.memberData.confirm_password)
                formData.append('profile_picture'    , this.memberData.profile_picture)
                formData.append('interested_area'    , this.memberData.interested_area)
                formData.append('source'             , this.memberData.source)
                formData.append('membership_id'         , this.memberData.membership_id)
                formData.append('class_id'              , this.memberData.class_id)
                formData.append('start_date'         , this.memberData.start_data)
                formData.append('isActive'           , this.memberData.isActive)
                formData.append('RF_code'           , this.memberData.RF_code)
                formData.append('amount_paid'           , this.memberData.amount_paid)
                formData.append('Membership_choose_allow_private_Features'           , this.memberData.Membership_choose_allow_private_Features)









                 let config = {
                    headers: {
                        "Content-Type":
                            "multipart/form-data; charset=utf-8 ; boundary=" +
                            Math.random()
                                .toString()
                                .substr(2)
                    }
                };




                axios.post(`updateMember/${this.$route.params.memberId}`,formData,config)
                .then(res => {

                    if(res.data.success == false){

                             this.error = res.data.message
                    }

                    if(res.data.success){

                        this.error = []
                        this.memberData = []
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
                this.memberData.gender    = '',
                this.memberData.data_of_birth    = '',
                this.memberData.group_id    = '',
                this.memberData.address    = '',
                this.memberData.city    = '',
                this.memberData.phoneNumber    = '',
                this.memberData.email    = '',
                this.memberData.user_name    = '',
                this.memberData.password    = '',
                this.memberData.confirm_password    = '',
                this.memberData.profile_picture    = [],
                this.memberData.interested_area    = '',
                this.memberData.source    = '',
                this.memberData.membership_id    = '',
                this.memberData.class_id    = '',
                this.memberData.start_data    = '',
                this.memberData.isActive    = true
                this.memberData.RF_code    = ''
                this.memberData.amount_paid    = ''
                this.isLoading = true


            }
        }

    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
