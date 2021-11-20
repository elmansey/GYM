<template>
  <div v-if="isLoading">
    <Breadcrumbs main="dashboard" title="class Schedule" />

    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="select2-drpdwn">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h1>
                  <i class="fa fa-calendar"></i>
                  Class Schedules
                </h1>
              </div>
              <div class="card-body">
                <table class="table">
                  <tbody>
                    <tr>
                      <th width="50">Saturday</th>
                      <td  >
                        <span
                          class="badge badge-primary mb-1 "
                          style="font-size: 12px; height: 30px ;border-radius:40px; flex-wrap: wrap;flex-direction: row;"
                          v-for="(item, index) in classes.saturdayClasses"
                          :key="index"
                        >
                          {{

                              'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="primary"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>

                    <tr>
                      <th width="50">Sunday</th>
                      <td>
                        <span
                          class="badge badge-dark mb-1"
                          style="font-size: 12px; height: 30px;border-radius:40px"
                          v-for="(item, index) in classes.sundayClasses"
                          :key="index"
                        >
                          {{
                              'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="dark"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>

                    <tr>
                      <th width="50">Monday</th>
                      <td>
                        <span
                          class="badge badge-primary mb-1"
                          style="font-size: 12px; height: 30px ;border-radius:40px"
                          v-for="(item, index) in classes.mondayClasses"
                          :key="index"
                        >
                          {{
                               'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="primary"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>

                    <tr>
                      <th width="50">Tuesday</th>
                      <td>
                        <span
                          class="badge badge-success mb-1"
                          style="font-size: 12px; height: 30px ;border-radius:40px"
                          v-for="(item, index) in classes.tuesdayClasses"
                          :key="index"
                        >
                          {{
                              'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="success"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>

                    <tr>
                      <th width="50">Wednesday</th>
                      <td>
                        <span
                          class="badge badge-dark mb-1"
                          style="font-size: 12px; height: 30px ;border-radius:40px"
                          v-for="(item, index) in classes.wednesdayClasses"
                          :key="index"
                        >
                          {{
                               'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="dark"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>

                    <tr>
                      <th width="50">Thursday</th>
                      <td>
                        <span
                          class="badge badge-primary mb-1"
                          style="font-size: 12px; height: 30px ;border-radius:40px"
                          v-for="(item, index) in classes.thursdayClasses"
                          :key="index"
                        >
                          {{
                              'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="primary"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>

                    <tr>
                      <th width="50">Friday</th>
                      <td>
                        <span
                          class="badge badge-success mb-1"
                          style="font-size: 12px; height: 30px ;border-radius:40px"
                          v-for="(item, index) in classes.fridayClasses"
                          :key="index"
                        >
                          {{
                             'group('+
                            item.group_relation.name + ") -> "
                              + " " +
                            "class" +
                            " " +
                            "(" +
                            item.startingTime +
                            "-" +
                            item.endingTime +
                            ")"
                          }}
                          <b-dropdown
                            v-if="can('edit-class-schedule-in-classSchedule')"
                            size="sm"
                            style="height: 20px"
                            menu-class="dropdown-content"
                            variant="success"
                          >
                            <b-dropdown-item>
                              <router-link
                                :to="{
                                  name: 'updateClassSchedule',
                                  params: {
                                    classScheduleId: item.id,
                                  },
                                }"
                                style="color:#000;!important"
                              >
                                edit
                              </router-link>
                            </b-dropdown-item>
                          </b-dropdown>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
  <div
    v-else
    class="col-md-3"
    style="
      margin: auto;
      position: absolute;
      top: 50%;
      right: 50%;
      transform: translate(50%, -50%);
    "
  >
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
