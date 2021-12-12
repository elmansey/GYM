<template>
    <div>
        <Breadcrumbs :main="$t('Dashboard')" :title="$t('custom permissions')" />
            <div
                style="
                max-width:600px;margin:auto;
                overflow:scroll;
                background-color:#fff;
                height:630px;
                margin-bottom: 35px;
                box-shadow: 0 1px 15px  rgba(0 0 0 /4%), 0 1px 6px  rgba(0 0 0 /4%); " class="card-body">

                 <div style="display:flex;" class=" border-bottom mb-10" >
                    <h4 class="card-title" >
                        {{ $t('custom permissions') }}
                    </h4>
                    <feather  style="margin-left: 30px;  margin-top: 5px;" type="help-circle"></feather>


                    </div>

                    <section class="ps-container scroll dashboard-list-with-user ps">

                        <div class="d-flex flex-row   border-bottom" >


                            <div style="width:100%">
                                
                                    
                                          <div class="col col-12">
                                            <b-form-group class="has-float-label my-3 p-0">
                                                <v-select
                                                
                                               
                                                :options="options"
                                                :searchable="true"
                                                :clearable="true"
                                                placeholder="Search"
                                                label="name"
                                                
                                              
                                                />
                                            </b-form-group>
                                        </div>
                                   
                                
                            </div>
                                

                             
                        </div>
                    </section>
            </div>
    </div>        
</template>

<script>
    export default{
        data(){
            return{
                options:[]
            }
         }
    }
</script>