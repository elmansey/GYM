<template>
    <div  v-if="isLoading">
        <Breadcrumbs main="Permissions" :title="edit ? 'edit membership' : 'add membership'"/>
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
                                        <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                            <div class="col-form-label">membership name</div>

                                            <input name="name" v-model="data.name" :class="['form-control',error.name ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.name">{{error.name[0]}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">membership Period</div>

                                            <select name="name" v-model="data.Membership_Period" :class="['form-control',error.Membership_Period ? 'is-invalid' : '']" >
                                                <option value="1">daily (1 day)</option>
                                                <option value="7">Weekly (1 week)</option>
                                                <option value="30">Monthly (1 month)</option>
                                                <option value="365">Annual(1 year)</option>
                                            </select>
                                            <small style="color: red"  v-if="error.Membership_Period">{{error.Membership_Period[0]}}</small>
                                        </div>
                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">membership price</div>

                                            <input name="name" v-model="data.Membership_price" :class="['form-control',error.Membership_price ? 'is-invalid' : '']" />
                                            <small style="color: red"  v-if="error.Membership_price">{{error.Membership_price[0]}}</small>
                                        </div>

                                        <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                            <div class="col-form-label">with Membership private Features</div>

                                            <input name="name" v-model="data.Membership_private_Features" type="checkbox" />
                                            <small style="color: red"  v-if="error.Membership_private_Features">{{error.Membership_private_Features[0]}}</small>
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
                Membership_Period:'',
                Membership_price:'',
                Membership_private_Features:false

            },

            error:'',
            edit:true,
            isLoading : false


        }
    },

    beforeCreate(){



    },


    beforeMount() {


        if(this.$route.params.membershipId){
            this.edit = true

            axios.get(`getMembershipsById/${this.$route.params.membershipId}`)
            .then(res => {
                this.data.name  = res.data.membership.name
                this.data.Membership_Period  = res.data.membership.Membership_Period
                this.data.Membership_price  = res.data.membership.Membership_price
                this.data.Membership_private_Features  = res.data.membership.Membership_private_Features
                this.isLoading = true
            })
            .catch(err => {

            })


        }else{
            this.edit = false
            this.data.name = ''
            this.data.Membership_Period = ''
            this.data.Membership_price = ''
            this.data.Membership_private_Features = false
            this.isLoading = true
        }
    },


    methods: {

       handeleFormSubmit(){


            if(this.edit){


                let formData = new FormData()
                 formData.append('name',this.data.name)
                 formData.append('Membership_Period',this.data.Membership_Period)
                 formData.append('Membership_price',this.data.Membership_price)
                 formData.append('Membership_private_Features',this.data.Membership_private_Features)

                axios.post(`updateMemberships/${this.$route.params.membershipId}`,formData)
                .then(res => {

                    if(res.data.success == false){
                        this.error = res.data.message
                    }
                    if(res.data.success){

                        Toast.fire({
                            icon: 'success',
                            title: 'membership updated successfully'
                        })
                        this.$router.push({name:'memberships'})

                    }

                    console.log(res)
                })
                .catch(err => {
                  console.log(err)
                })


            }

            if(this.edit == false){


                let formData = new FormData()
                 formData.append('name',this.data.name)
                 formData.append('Membership_Period',this.data.Membership_Period)
                 formData.append('Membership_price',this.data.Membership_price)
                 formData.append('Membership_private_Features',this.data.Membership_private_Features)


                axios.post('addMemberships',formData)
                    .then(res => {

                        if(res.data.success == false){
                            this.error = res.data.message
                        }
                        if(res.data.success){

                            Toast.fire({
                                icon: 'success',
                                title: 'membership added successfully'
                            })
                            this.$router.push({name:'memberships'})

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

            if(to.name == 'addMembership'){
                this.data.name = ''
                this.data.Membership_Period = ''
                this.data.Membership_price = ''
                this.data.Membership_private_Features = false
                this.edit = false
            }
        }

    }
}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
