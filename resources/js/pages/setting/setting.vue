<template>
    <div  v-if="isLoading">
        <Breadcrumbs main="dashboard" title="setting"/>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                <h5 class="card-title">Simple Editor</h5>
                                                </div>
                                                <div class="card-body">
                                                <vue-editor v-model="content"></vue-editor>
                                                </div>
                                            </div>
                                        </div>
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
    <div v-else class="col-md-3" style="margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);">
        <h6 class="sub-title mb-0 text-center"></h6>
        <div class="loader-box" >
            <div class="loader-3"></div>
        </div>
    </div>

</template>

<script>
import axios from 'axios'
import { VueEditor } from "vue2-editor";
export default {
    data(){
        return{

            data:{

            },

            error:'',
            edit:true,
            isLoading : true


        }
    },

    beforeCreate(){



    },

      components: {
            VueEditor
        },


    beforeMount() {




    },


    methods: {





    },
    watch:{



    }
}
</script>
<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
