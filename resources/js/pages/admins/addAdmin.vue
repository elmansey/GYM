<script src="../../../../../ح/gexeer_project/resources/js/app.js"></script>
<template>
    <div>
        <Breadcrumbs main="dashboard" :title="this.$store.getters.editAdmin ? 'edit admin' : 'add admin'"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">



                                <div class="row">
                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label">name</div>

                                        <input  :class="['form-control',error.name ? 'is-invalid' : '']"  v-model="adminData.name"/>
                                        <small style="color: red" v-if="error.name">{{ error.name[0]}}</small>
                                    </div>
                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label"> email</div>

                                        <input  :class="['form-control',error.email ? 'is-invalid' : '']"  v-model="adminData.email"/>
                                        <small style="color: red" v-if="error.email">{{ error.email[0]}}</small>
                                    </div>
                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label"> phone number</div>

                                        <input :class="['form-control',error.phone ? 'is-invalid' : '']" v-model="adminData.phone"/>
                                        <small style="color: red" v-if="error.phone">{{ error.phone[0]}}</small>
                                    </div>
                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label">Choose the  Roles</div>

                                        <multiselect  v-model="adminData.roles" tag-placeholder="Add this as new tag" placeholder="Search or add a tag"
                                                      :class="[error.roles ? 'is-invalid' : '']"     label="name" track-by="id"   @search-change="asyncFind" :options="options"  :multiple="true"   :taggable="true" @tag="addTag"  >

                                        </multiselect>
                                        <small  style="color: red" v-if="error.roles">{{ error.roles[0]}}</small>

                                    </div>
                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label"> password</div>

                                        <input  :class="['form-control',error.password ? 'is-invalid' : '']"  v-model="adminData.password"/>
                                        <small style="color: red" v-if="error.password">{{ error.password[0]}}</small>
                                    </div>
                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label"> confirm password</div>

                                        <input  :class="['form-control',error.confirm_password ? 'is-invalid' : '']"  v-model="adminData.confirm_password"/>
                                        <small style="color: red" v-if="error.confirm_password">{{ error.confirm_password[0]}}</small>
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-3"  v-if="!this.$store.getters.editAdmin" @click.prevent="storeAdmin">
                                    Save
                                </button>
                                <button class="btn btn-success mt-3"   v-if="this.$store.getters.editAdmin" @click.prevent="">
                                    update
                                </button>



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
import Multiselect from 'vue-multiselect'
import axios from 'axios'

export default {
    data(){
        return{
            adminData:{
                id:'',
                name:'',
                email:'',
                phone:'',
                password:'',
                confirm_password:'',
                roles: null
            },

            options: [],
            error:'',


        }
    },
    components: {
        Multiselect
    },
    beforeCreate() {
        axios.get('createUser')
        .then(res => {

            if(res.data.success == true){
                this.options = res.data.roles
            }

        })
        .catch(err => {

            console.log(err)
        })

    },

    created() {

        if(this.$store.getters.editAdmin == true){

            this.adminData = this.$store.getters.AdminInfoToEdit

        }

    },

    methods: {
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
        storeAdmin(){
            axios.post('adminAdd',this.adminData)
            .then(res => {

                if(res.data.success == true){
                    Toast.fire({
                        icon: 'success',
                        title: 'admin added successfully'
                    })
                    this.$router.push('adminsList')
                }else if(res.data.success == false) {

                    this.error = res.data.message
                }

            })
            .catch(err => {
                console.log(err)
            })
        }
    }

}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
