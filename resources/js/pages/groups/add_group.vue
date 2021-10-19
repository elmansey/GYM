<template>
    <div  v-if="isLoading">
        <Breadcrumbs main="dashboard" :title="edit ? 'edit group' : 'add group'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">


                                <form @submit.prevent="handeleFormSubmit" id="form">

                                    <div class="row">
                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">Group name</div>

                                            <input name="name" v-model="data.name" :class="['form-control',error.name ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.name">{{error.name[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">Total Group Members</div>

                                            <input name="name" v-model="data.TotalGroupMembers" :class="['form-control',error.TotalGroupMembers ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.TotalGroupMembers">{{error.TotalGroupMembers[0]}}</small>
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

export default {
    data(){
        return{

            data:{
                name:'',
                TotalGroupMembers:''
            },

            error:'',
            edit:true,
            isLoading : false


        }
    },

    beforeCreate(){



    },


    beforeMount() {


        if(this.$route.params.groupId){
            this.edit = true

            axios.get(`getGroupsById/${this.$route.params.groupId}`)
                .then(res => {
                    this.data.name  = res.data.group.name
                    this.data.TotalGroupMembers  = res.data.group.TotalGroupMembers
                    this.isLoading = true
                })
                .catch(err => {

                })


        }else{
            this.edit = false
            this.data.name = ''
            this.data.TotalGroupMembers = ''
            this.isLoading = true
        }
    },


    methods: {

        async handeleFormSubmit(){


            if(this.edit){


                let formData = new FormData()
                await formData.append('name',this.data.name)
                await formData.append('TotalGroupMembers',this.data.TotalGroupMembers)
                axios.post(`updateGroup/${this.$route.params.groupId}`,formData)
                    .then(res => {

                        if(res.data.success == false){
                            this.error = res.data.message
                        }
                        if(res.data.success){

                            Toast.fire({
                                icon: 'success',
                                title: 'group updated successfully'
                            })
                            this.$router.push({name:'groups'})

                        }

                        console.log(res)
                    })
                    .catch(err => {
                        console.log(err)
                    })


            }

            if(this.edit == false){


                let formData = new FormData()
                await formData.append('name',this.data.name)
                await formData.append('TotalGroupMembers',this.data.TotalGroupMembers)
                axios.post('addGroup',formData)
                    .then(res => {

                        if(res.data.success == false){
                            this.error = res.data.message
                        }
                        if(res.data.success){

                            Toast.fire({
                                icon: 'success',
                                title: 'group added successfully'
                            })
                            this.$router.push({name:'groups'})

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

            if(to.name == 'addGroup'){
                this.data.name = ''
                this.data.TotalGroupMembers = ''
                this.edit = false
            }
        }

    }
}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
