<template>
  <div v-if="isLoading">
    <Breadcrumbs main="dashboard" title="class Schedule" />



      <div class="container-fluid">
        <div class="row">

          <div class="col-sm-12">
            <div class="card">
              <!-- <div class="card-header">
                <h5>IMAGE GALLERY</h5>
              </div> -->
               <h1 style="margin: 15px 20px;"><i class="fa fa-calendar"></i></h1>

                  <div  class="card-body my-gallery gallery border-bottom">
                      
                    <div class="row" itemscope itemprop="thumbnail">
                        
                      <figure class="col-xl-3 col-sm-6 m-0" v-for="(item, index) in classes.saturdayClasses"  :key="index">
                        <div>

                              <div  style="height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;"  >
                                <label style="font-size: 20px;font-weight: 700;">Saturday</label> <br />

                                <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>                            <br />
                                <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br />  


                                <b-dropdown
                                  v-if="can('edit-class-schedule-in-classSchedule')"
                                  size="sm"
                                  style="height: 20px"
                                  menu-class="dropdown-content"
                                  variant="default"
                                >
                                  <b-dropdown-item>
                                    <router-link
                                      :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                      edit
                                    </router-link>
                                  </b-dropdown-item>
                                </b-dropdown>
                        
                              </div>

                        </div>
                      </figure>
            
                    </div>
                  </div>


                  <div  class="card-body my-gallery gallery border-bottom">
                    <div class="row" itemscope itemprop="thumbnail">
                      <figure class="col-xl-3 col-sm-6 m-0" v-for="(item, index) in classes.sundayClasses":key="index">
                          <div>
                              <div  style="height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;"    >
                                  <label style="font-size: 20px;font-weight: 700;">Sunday</label><br /> 
                                          <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                          <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>                            <br />
                                          <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br /> 

                                            <b-dropdown
                                              v-if="can('edit-class-schedule-in-classSchedule')"
                                              size="sm"
                                              style="height: 20px"
                                              menu-class="dropdown-content"
                                              variant="default"
                                            >
                                              <b-dropdown-item>
                                                <router-link
                                                  :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                                  edit
                                                </router-link>
                                              </b-dropdown-item>
                                            </b-dropdown>
                                          
                              </div>
                          </div> 
                        </figure>
                        
                    </div>
                  </div>
                  

                    



                  <div  class="card-body my-gallery gallery border-bottom">
                      
                    <div class="row" itemscope itemprop="thumbnail">
                      <figure class="col-xl-3 col-sm-6 m-0" v-for="(item, index) in classes.mondayClasses":key="index">
                        <div >
                            <div  style="height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;">
                            
                                      <label style="font-size: 20px;font-weight: 700;">Monday</label><br />
                                     <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                  <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>                            <br />
                                  <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br /> 


                                  <b-dropdown
                                    v-if="can('edit-class-schedule-in-classSchedule')"
                                    size="sm"
                                    style="height: 20px"
                                    menu-class="dropdown-content"
                                    variant="default"
                                  >
                                    <b-dropdown-item>
                                      <router-link
                                        :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                        edit
                                      </router-link>
                                    </b-dropdown-item>
                                  </b-dropdown>
                          
                                </div>
                              </div>
                      </figure>
            
                    </div>
                  </div>


                  <div  class="card-body my-gallery gallery border-bottom">
                      
                    <div class="row" itemscope itemprop="thumbnail">
                      <figure class="col-xl-3 col-sm-6 m-0"   v-for="(item, index) in classes.tuesdayClasses" :key="index">
                        <!-- <a>
                          <img src="" class="img-thumbnail" alt="Image description" />
                        </a> -->

                        <div >
                                <div  style=" height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;"  >
                                  <label style="font-size: 20px;font-weight: 700;">Tuesday</label><br />

                               <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                  <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>         <br />
                                  <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br /> 

                                  <b-dropdown
                                    v-if="can('edit-class-schedule-in-classSchedule')"
                                    size="sm"
                                    style="height: 20px"
                                    menu-class="dropdown-content"
                                    variant="default"
                                  >
                                    <b-dropdown-item>
                                      <router-link
                                        :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                        edit
                                      </router-link>
                                    </b-dropdown-item>
                                  </b-dropdown>
                          
                                </div>
                              </div>
                      </figure>
            
                    </div>
                  </div>


                  <div  class="card-body my-gallery gallery border-bottom">
                      
                    <div class="row" itemscope itemprop="thumbnail">
                      
                      <figure class="col-xl-3 col-sm-6 m-0" v-for="(item, index) in classes.wednesdayClasses":key="index">
                        <!-- <a>
                          <img src="" class="img-thumbnail" alt="Image description" />
                        </a> -->

                        <div >
                                <div  style="height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;"  >
                              <label style="font-size: 20px;font-weight: 700;">Wednesday</label><br />
                                     <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                  <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>  <br />
                                  <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br /> 


                                  <b-dropdown
                                    v-if="can('edit-class-schedule-in-classSchedule')"
                                    size="sm"
                                    style="height: 20px"
                                    menu-class="dropdown-content"
                                    variant="default"
                                  >
                                    <b-dropdown-item>
                                      <router-link
                                        :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                        edit
                                      </router-link>
                                    </b-dropdown-item>
                                  </b-dropdown>
                          
                                </div>
                              </div>
                      </figure>
            
                    </div>
                  </div>

                  <div  class="card-body my-gallery gallery border-bottom">
                      
                    <div class="row" itemscope itemprop="thumbnail">
                       
                      <figure class="col-xl-3 col-sm-6 m-0"  v-for="(item, index) in classes.thursdayClasses" :key="index">
                        <!-- <a>
                          <img src="" class="img-thumbnail" alt="Image description" />
                        </a> -->

                        <div >
                                <div  style="height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;">
                             <label style="font-size: 20px;font-weight: 700;">Thursday</label><br />
                                       <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                  <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>  <br />
                                  <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br /> 


                                  <b-dropdown
                                    v-if="can('edit-class-schedule-in-classSchedule')"
                                    size="sm"
                                    style="height: 20px"
                                    menu-class="dropdown-content"
                                    variant="default"
                                  >
                                    <b-dropdown-item>
                                      <router-link
                                        :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                        edit
                                      </router-link>
                                    </b-dropdown-item>
                                  </b-dropdown>
                          
                                </div>
                              </div>
                      </figure>
            
                    </div>
                  </div>

                  <div  class="card-body my-gallery gallery border-bottom">
                      
                    <div class="row" itemscope itemprop="thumbnail">
                      <figure class="col-xl-3 col-sm-6 m-0" v-for="(item, index) in classes.fridayClasses"
                          :key="index">
                        <!-- <a>
                          <img src="" class="img-thumbnail" alt="Image description" />
                        </a> -->

                        <div >
                                <div  style="height:150px;background-color: rgb(255, 255, 255);box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px; padding: 10px 0px; text-align: center;">
                                <label style="font-size: 20px;font-weight: 700;">Friday</label><br />

                                      <span> {{ "group name: " + item.group_relation.name }} </span>  <br />
                                  <span>{{" class time : " +  item.startingTime +" - " +item.endingTime}}</span>  <br />
                                  <span> {{ "class captien : " +  item.staff_relation.name }}</span> <br /> 


                                  <b-dropdown
                                    v-if="can('edit-class-schedule-in-classSchedule')"
                                    size="sm"
                                    style="height: 20px"
                                    menu-class="dropdown-content"
                                    variant="default"
                                  >
                                    <b-dropdown-item>
                                      <router-link
                                        :to="{name: 'updateClassSchedule',params: {classScheduleId: item.id,},  }" style="color:#000;!important" >
                                        edit
                                      </router-link>
                                    </b-dropdown-item>
                                  </b-dropdown>
                          
                                </div>
                              </div>
                      </figure>
            
                    </div>
                  </div>


            





              
            </div>
          </div>
          
        </div>
       </div> 

    

  </div>




  <div
    v-else
    class="col-md-3"
    style="
      margin: auto;
      position: absolute;
      top: 50%;
      right: 50%;
      transform: translate(50%, -50%);">

    <h6 class="sub-title mb-0 text-center"></h6>
    <div class="loader-box">
      <div class="loader-3"></div>
    </div>
  </div>


</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      classes: {},
      isLoading: false,
      filter: {
        currentPage: 1,
        totalPages: 0,
      },
    };
  },

  beforeCreate() {
    axios
      .get("getClassInDays")
      .then((res) => {
        this.classes = res.data.classes;
        this.isLoading = true;
      })
      .catch((err) => {
        console.error(err);
      });
  },

  beforeMount() {},

  methods: {},

  watch: {},
};
</script>
<style></style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
