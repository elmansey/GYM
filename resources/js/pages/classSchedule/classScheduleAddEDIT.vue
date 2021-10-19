<template>
    <div  v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit class' : 'add class'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="handelData" id="form">

                                    <div class="row">
                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">class Name</div>

                                            <input name="className" v-model="data.className" :class="['form-control',error.className ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.className">{{error.className[0]}}</small>
                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div style="float: right ">
                                                <label>select all days</label>
                                                <input type="checkbox" @change="check($event)" />

                                            </div>
                                            <div class="col-form-label">select day</div>

                                            <multiselect :disabled="selectAll" v-model="data.days" tag-placeholder="Add this as new tag" placeholder="Search or add a tag"
                                                          :class="[error.day ? 'is-invalid' : '']"      label="name" track-by="id"   @search-change="asyncFind" :options="options"  :multiple="true"   :taggable="true" @tag="addTag"  >

                                            </multiselect>
                                            <small  style="color: red" v-if="error.day">{{ error.day[0] }}</small>

                                        </div>


                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">Coach Name </div>

                                            <select name="coachName" v-model="data.coachName" :class="['form-control',error.coachName ? 'is-invalid' : '']" >

                                            </select>
                                            <small style="color: red"  v-if="error.coachName">{{error.coachName[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> starting Time </div>

                                            <input name="startingTime"  type="time" v-model="data.startingTime" :class="['form-control',error.startingTime ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.startingTime">{{error.startingTime[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> ending Time </div>

                                            <input name="endingTime" type="time" v-model="data.endingTime" :class="['form-control',error.endingTime ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.endingTime">{{error.endingTime[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label"> training Location </div>

                                            <input name="trainingLocation" v-model="data.trainingLocation" :class="['form-control',error.trainingLocation ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.trainingLocation">{{error.trainingLocation[0]}}</small>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3" v-if="!edit" >
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-success mt-3" v-if="edit" >
                                        update
                                    </button>

                                </form>





                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
import axios from 'axios'
import Multiselect from "vue-multiselect";

export default {
    data(){
        return{

            data:{
                className:'',
                coachName:'',
                startingTime:'',
                trainingLocation:'',
                days:''
            },

            options: [

                { id: 1 , name: 'Saturday' },
                { id: 2 , name: 'Sunday' },
                { id: 3 , name: 'Monday' },
                { id: 4 , name: 'Tuesday' },
                { id: 5 , name: 'Wednesday'},
                { id: 6 , name: 'Thursday'},
                { id: 7 , name: 'Friday'}
            ],
            error:'',
            edit:true,
            isLoading : true,
            selectAll:false


        }
    },
    components: {
        Multiselect
    },

    beforeCreate(){



    },


    beforeMount() {


        if(this.$route.params.classScheduleId){
            this.edit = true




        }else{
            this.edit = false

        }
    },


    methods: {

        handelData(){

            if(this.edit == false){

                let formData = new FormData()
                formData.append('className',this.data.className)
                formData.append('coachName',this.data.coachName)
                formData.append('startingTime',this.data.startingTime)
                formData.append('trainingLocation',this.data.trainingLocation)
                formData.append('days',this.data.days)


                axios.post('')
            }


        },
        check(event){
            if(event.target.checked){

                this.selectAll = true
                this.data.days = this.options
            }else{
                this.selectAll = false
                this.data.days = ''

            }
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


        async handeleFormSubmit(){


            if(this.edit){

            }

            if(this.edit == false){



            }



    }
  },

    watch:{



    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
