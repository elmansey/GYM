<template>
    <div>
        <Breadcrumbs main="Permissions" :title="this.$store.getters.EDIT ? 'edit Role' : 'add Role'"/>
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
                                        <div class="col-form-label">Role name</div>

                                        <input  :class="['form-control',error.name ? 'is-invalid' : '']"  v-model="role.name"/>
                                        <small style="color: red" v-if="error.name">{{ error.name[0] }}</small>
                                    </div>

                                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                                        <div class="col-form-label">Choose the permissions for this Role</div>

                                        <multiselect  v-model="role.permission" tag-placeholder="Add this as new tag" placeholder="Search or add a tag"
                                                :class="['form-control',error.permission ? 'is-invalid' : '']"      label="name" track-by="id"   @search-change="asyncFind" :options="options"  :multiple="true"   :taggable="true" @tag="addTag"  >

                                        </multiselect>
                                        <small  style="color: red" v-if="error.permission">{{ error.permission[0] }}</small>

                                    </div>
                                </div>

                                <button class="btn btn-primary mt-3"  v-if="!this.$store.getters.EDIT" @click.prevent="storeRole">
                                    Save
                                </button>
                                <button class="btn btn-success mt-3"  v-if="this.$store.getters.EDIT" @click.prevent="UpdateRole">
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
            role:{
                id:'',
                name:'',
                permission: []
            },

            options: [],
            error:'',


        }
    },
    components: {
        Multiselect
    },
    beforeCreate() {

        axios.get('createRole')
        .then(res => {
            this.options = res.data.permission
        })
        .catch(err => {
            console.log(err.message)
        })

    },

    created() {

        if(this.$store.getters.EDIT  == true){
            this.role.name = this.$store.getters.ROLEDATATOEDIT.role
            this.role.id = this.$store.getters.ROLEDATATOEDIT.id
            this.role.permission = this.$store.getters.ROLEDATATOEDIT.permission
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


        storeRole(){

            axios.post('roleAdd',this.role)
            .then(res => {

                if(res.data.success == true){

                    Toast.fire({
                        icon: 'success',
                        title: 'add Role successfully'
                    })
                    this.role.name = ''
                    this.role.permission = []
                    this.$router.push('Permissions')

                }else if (res.data.success == false){

                    this.error = res.data.message

                }

            })
            .catch(err => {
                console.log(err.message)
            })


        },


        UpdateRole(){
            axios.post('roleUpdate',this.role)
            .then(res => {

                if(res.data.success == true){

                    Toast.fire({
                        icon: 'success',
                        title: 'Update Role successfully'
                    })

                    this.$router.push('Permissions')

                }else if (res.data.success == false){

                    this.error = res.data.message

                }


            })
            .catch(err => {

            })
        }


    }
}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
