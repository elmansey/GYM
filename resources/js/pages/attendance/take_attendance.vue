<template>
  <div>
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('take attendance')" />
    <!-- Container-fluid starts-->

    <div class="container-fluid">
      <div class="card">
        <div class="row" style="height: 100%">
          <div class="col-lg-4">
            <form @submit.prevent="saveAttendance">
              <div
                class="card-body"
                style="height: 100%; border-left: 1px solid #efefef"
              >
                <div class="form-group mb-0">
                  <div class="col-lg-12" style="margin-bottom: 20px">
                    <multiselect
                      tag-placeholder="Add this as new tag"
                      :placeholder="$t('Search or choose')"
                      v-model="attendanceDate.select.name"
                      label="name"
                      track-by="id"
                      :options="options"
                      :multiple="false"
                      :taggable="false"
                      style="margin: 0px; padding: 0px"
                    ></multiselect>
                    <small style="color: red" v-if="error.name">
                      {{ error.name[0] }}
                    </small>
                  </div>

                  <div class="col-lg-12" style="margin-bottom: 20px">
                    <input
                      type="time"
                      class="form-control"
                      v-model="attendanceDate.select.time"
                    />
                    <small style="color: red" v-if="error.time">
                      {{ error.time[0] }}
                    </small>
                  </div>

                  <div class="col-lg-12" style="margin-bottom: 20px">
                    <datepicker
                      @input="handelData"
                      class="my-datepicker"
                      calendar-class="my-datepicker_calendar"
                      :inline="true"
                      format="dd-MM-yyyy"
                      v-model="attendanceDate.select.date"
                    ></datepicker>
                    <small style="color: red" v-if="error.date">
                      {{ error.date[0] }}
                    </small>
                  </div>
                </div>

                <div class="form-group form-row mb-0">
                  <div class="col-lg-12 m-t-10">
                    <button
                      id="default-custom-success"
                      type="submit"
                      class="btn btn-dark"
                    >
                      {{ $t("Save") }}
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="col-lg-4">
            <div
              class="card-body"
              style="height: 100%; border-left: 1px solid #efefef"
            >
              <input
                id="mytext"
                @keyup.enter="handelAttendanceByScan"
                type="text"
                v-model="attendanceDate.scan.RF_code"
                :placeholder="$t('RF code')"
                style="width: 100%; padding: 8px; border: 1px solid #efefef"
              />

              <div
                class="col-lg-12"
                style="height: 600px; overflow: scroll !important; padding: 0px"
              >
                <div v-for="(item, index) in attendanceAction" :key="index">
                  <section class="dashboard-list-with-user">
                    <div
                      class="d-flex flex-row border-bottom"
                      style="margin-top: 4px; padding: 6px"
                    >
                      <div class="col-10">
                        <p class="font-weight-medium mb-0">
                          {{ item.how.name }}
                        </p>
                        <h5 class="font-weight-medium mb-0">
                          {{ $t(item.status) }}
                        </h5>
                        <span>{{ $t(item.message) }}</span>
                      </div>

                      <div class="col-2">
                        <feather
                          style="width: 20px; margin-top: 12px; color: #116530"
                          v-if="item.status == 'come'"
                          type="log-in"
                        ></feather>
                        <feather
                          style="width: 20px; margin-top: 12px; color: #116530"
                          v-if="item.status == 'leave'"
                          type="log-out"
                        ></feather>
                        <feather
                          style="width: 20px; margin-top: 12px; color: #516beb"
                          v-if="item.status == 'taken'"
                          type="check-circle"
                        ></feather>
                        <feather
                          style="width: 20px; margin-top: 12px; color: #cd1818"
                          v-if="item.status == 'expire'"
                          type="x-circle"
                        ></feather>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div
              class="card-body"
              style="border-left: 1px solid #efefef; padding: 20px"
            >
              <div class="row">
                <div class="col-lg-12" style="overflow: scroll; padding: 5px">
                  <input
                    type="text"
                    :class="['form-control']"
                    style="margin-top: 16px; width: 100%"
                    v-model="RF_Person_Code"
                    :placeholder="$t('search by RF code')"
                  />
                </div>

                <div
                  v-if="isLoadig"
                  class="col-lg-12"
                  style="height: 600px; overflow: scroll !important"
                >
                  <div v-for="(item, index) in search" :key="index">
                    <section class="dashboard-list-with-user">
                      <div
                        class="d-flex flex-row border-bottom"
                        style="margin-top: 4px; padding: 6px"
                      >
                        <img
                          :src="
                            item.profile_picture
                              ? '../../profile_pictures/' + item.profile_picture
                              : '../../profile_pictures/DefaultProfile.jpg'
                          "
                          alt
                          style="width: 50px; height: 50px"
                          class="
                            img-thumbnail
                            border-0
                            rounded-circle
                            list-thumbnail
                            align-self-center
                            xsmall
                          "
                        />

                        <div class="pl-3 pr-2">
                          <p class="font-weight-medium mb-0">{{ item.name }}</p>
                          <input
                            readonly
                            style="border: none"
                            :id="'myCopy' + index"
                            :value="item.RF_code"
                          />
                          <i
                            class="fa fa-copy"
                            :id="'copied' + index"
                            @click="copyThis(index)"
                          ></i>

                          <b-tooltip
                            :target="'copied' + index"
                            triggers="hover"
                            placement="top"
                          >
                            <p :id="'cop' + index">
                              {{ $t("copy : ") + item.RF_code + " ? " }}
                            </p>
                          </b-tooltip>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>

                <div
                  v-else
                  class="col-md-3"
                  style="
                    width: 60px !important;
                    height: 60px !important;
                    margin: auto;
                    position: absolute;
                    top: 50%;
                    right: 50%;
                    transform: translate(50%, -50%);
                  "
                >
                  <h6 class="sub-title mb-0 text-center"></h6>
                  <div class="loader-box">
                    <div class="loader-15"></div>
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
</template>

<script>
import Datepicker from "vuejs-datepicker";
import Multiselect from "vue-multiselect";
import axios from "axios";
import { requiredIf } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      attendanceDate: {
        select: {
          name: [],
          date: "",
          time: "",
          type: "select",
        },

        scan: {
          RF_code: "",
          type: "scan",
        },
      },
      copiedText: "",
      attendanceAction: [],

      RF_Person_Code: "",
      type: "RF_Person_Code",
      show: false,
      searchData: [],
      options: [],
      responseUserData: [],
      error: [],
      submited: false,
      isLoadig: false,
    };
  },
  beforeCreate() {},
  mounted() {
    document.getElementById("mytext").focus();
  },

  beforeMount() {
    var today = new Date();
    var da =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    this.attendanceDate.select.date = da;

    this.getAllPersonToAttendance();
  },
  computed: {
    search() {
      return this.searchData.filter((item) => {
        //  console.log(item.RF_code)
        //match
        return item.RF_code.includes(this.RF_Person_Code.toLowerCase());
      });
    },
  },

  components: {
    Datepicker,
    Multiselect,
  },

  //  validations:{

  //     attendanceDate:{
  //          name:{

  //             requiredIf:requiredIf( function(){
  //                 return   (this.type == 'name')
  //             })

  //         },

  //          RF_Person_Code:{

  //             requiredIf:requiredIf( function(){
  //                 return   (this.type == 'RF_Person_Code')
  //             })

  //         },
  //     }
  //  },

  methods: {
    copyThis(index) {
      window.getSelection().removeAllRanges();

      var test = document.getElementById(`myCopy${index}`);
      test.select();
      console.log(test.value);

      try {
        var successful = document.execCommand("copy");

        var contentTool = document.getElementById(`cop${index}`);

        contentTool.innerHTML = successful
          ? this.$t("copied : ") + test.value + "  !! "
          : "";
      } catch (err) {
        console.log(err);
      }
    },

    //  date
    handelData() {
      var today = new Date(this.attendanceDate.select.date);
      var da =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      this.attendanceDate.select.date = da;
    },

    handelAttendanceByScan() {
      let formData = new FormData();
      formData.append("RF_code", this.attendanceDate.scan.RF_code);
      formData.append("type", this.attendanceDate.scan.type);

      axios
        .post("saveAttendance", formData)
        .then((res) => {
          if (res.data.success || res.data.status == "taken") {
            this.attendanceAction.unshift(res.data);

            // if(res.data.status == 'leave'){

            //     this.$notify({
            //         group: 'app',
            //         type: 'success',
            //         duration: 1000,
            //         speed: 1000,
            //         title: 'attendance success',
            //         text: 'god bay ' + '<span>' + res.data.how.name+ '</span>' + ' <h6>'+ this.$t('Leave') +'</h6>' +
            //         'in '+res.data..leave_time
            //     });

            // }

            // if(res.data.status == 'expire'){

            //     this.$notify({
            //         group: 'app',
            //         type: 'error',
            //         duration: 1000,
            //         speed: 1000,
            //         title: '<span style="color:#fff">'+ this.$t('attendance fail')+'</span>',
            //         text: '<span style="color:#fff;padding:25px">'+ this.$t('The monthly subscription has expired')+'</span>'
            //     });

            // }

            // if(res.data.status == 'come'){

            //     this.$notify({
            //         type: 'success',
            //         group:"app",
            //         duration: 1000,
            //           speed: 1000,
            //         title: 'attendance success',
            //         text: 'welcome ' + '<span>' + res.data.how.name+ '</span>' + ' <h6>'+ this.$t('Come') +'</h6>' +
            //         'in '+res.data.attendance.come_time
            //     });

            // }
          }

          // if(res.data.status == 400){
          //       this.$notify({
          //             group:"app",
          //             type: 'danger',
          //             duration: 1000,
          //             speed: 1000,
          //             title: this.$t('attendance are already taken'),
          //             text: this.$t('<p> attendance are already taken</p>')
          //         });
          // }
        })
        .catch((err) => {});
    },

    saveAttendance() {
      let formData = new FormData();

      formData.append("name", JSON.stringify(this.attendanceDate.select.name));
      formData.append("date", this.attendanceDate.select.date);
      formData.append("time", this.attendanceDate.select.time);
      formData.append("type", this.attendanceDate.select.type);

      axios
        .post("saveAttendance", formData)
        .then((res) => {
          if (res.data.success) {
            if (res.data.status == "leave") {
              this.$notify({
                group: "app",
                type: "success",
                duration: 10000,
                speed: 1000,
                title: "attendance success",
                text:
                  "god bay " +
                  "<span>" +
                  res.data.how.name +
                  "</span>" +
                  " <h6> leave </h6> " +
                  "in " +
                  res.data.attendance.leave_time,
              });
            }

            if (res.data.status == "come") {
              this.$notify({
                type: "success",
                group: "app",
                duration: 10000,
                speed: 1000,
                title: "attendance success",
                text:
                  "welcome " +
                  "<span>" +
                  res.data.how.name +
                  "</span>" +
                  " <h6> come </h6> " +
                  "in " +
                  res.data.attendance.come_time,
              });
            }
          }

          if (res.data.status == "expire") {
            this.$notify({
              group: "app",
              type: "error",
              duration: 1000,
              speed: 1000,
              title:
                '<span style="color:#fff">' +
                this.$t("attendance fail") +
                "</span>",
              text:
                '<span style="color:#fff;padding:25px">' +
                this.$t("The monthly subscription has expired") +
                "</span>",
            });
          }
          if (res.data.status == 400) {
            this.$notify({
              group: "app",
              type: "danger",
              duration: 10000,
              speed: 1000,
              title: "attendance are already taken ",
              text: "<p> attendance are already taken</p>",
            });
          }
        })
        .catch((err) => {});
    },

    setValue(val) {
      this.attendanceDate.RF_Person_Code = val;
      this.searchData = [];
    },

    getAllPersonToAttendance() {
      axios
        .get("getAllPersonToAttendance")
        .then((res) => {
          if (res.data.success) {
            this.searchData = res.data.users;
            this.options = res.data.users;
            this.isLoadig = true;
          }
        })
        .catch((err) => {});
    },
  },

  watch: {
    searchWatch: function (searchData) {
      if (this.attendanceDate.RF_Person_Code.length < 1) {
        searchData = [];
      }
    },
  },
};
</script>



<style scoped>
.my-datepicker >>> .my-datepicker_calendar {
  width: 100% !important;
}

::-webkit-scrollbar {
  width: 0px;
  background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
}
</style>
