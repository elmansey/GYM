<template>
  <div>
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('Profile')" />
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="edit-profile">
        <div class="row">
          <div class="col-xl-4">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title mb-0">{{ $t("My Profile") }}</h4>
                <div class="card-options">
                  <a
                    class="card-options-collapse"
                    href="#"
                    data-toggle="card-collapse"
                    ><i class="fe fe-chevron-up"></i></a
                  ><a
                    class="card-options-remove"
                    href="#"
                    data-toggle="card-remove"
                    ><i class="fe fe-x"></i
                  ></a>
                </div>
              </div>
              <div class="card-body">
                <div class="row mb-2">
                  <div class="col-auto">
                    <img
                      class="img-70 rounded-circle"
                      :src="
                        ProfileInfo.profile_picture
                          ? '../../profile_pictures/' +
                            ProfileInfo.profile_picture
                          : '../../profile_pictures/DefaultProfile.jpg'
                      "
                      alt=""
                    />
                  </div>
                  <div class="col">
                    <h3 class="mb-1">{{ ProfileInfo.name }}</h3>
                    <p class="mb-4">{{ $t(role[0].role) }}</p>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <img :src="'../../' + ProfileInfo.qr_code" alt="" />
                  </div>
                </div>

                <div class="form-group">
                  <p class="form-label">
                    {{ $t("Use This RF Code To Take Attendance") }}
                  </p>
                  <label style="font-size: 12px" class="form-label"
                    >{{ $t("RF code") }}:</label
                  >
                  <div>
                    {{ ProfileInfo.RF_code }}
                  </div>
                </div>
                <div class="form-group">
                  <label style="font-size: 12px" class="form-label"
                    >{{ $t("email") }}:</label
                  >
                  <div style="font-size: 18px">{{ ProfileInfo.email }}</div>
                </div>

                <div class="form-group">
                  <label style="font-size: 15px" class="form-label"
                    >{{ $t("id") }}:</label
                  >
                  <div style="font-size: 18px">
                    {{ ProfileInfo.Personal_uuid }}
                  </div>
                </div>
                <div class="form-group">
                  <label style="font-size: 15px" class="form-label"
                    >{{ $t("user name") }}:</label
                  >
                  <div style="font-size: 18px">{{ ProfileInfo.user_name }}</div>
                </div>
                <div class="form-group">
                  <label style="font-size: 15px" class="form-label"
                    >{{ $t("phone") }}:</label
                  >
                  <div style="font-size: 18px">{{ ProfileInfo.phone }}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8">
            <form class="card" @submit.prevent="handelSubmitForm">
              <div class="card-header">
                <h4 class="card-title mb-0">{{ $t("Edit Profile") }}</h4>
                <div class="card-options">
                  <a
                    class="card-options-collapse"
                    href="#"
                    data-toggle="card-collapse"
                  >
                    <i class="fe fe-chevron-up"></i>
                  </a>
                  <a
                    class="card-options-remove"
                    href="#"
                    data-toggle="card-remove"
                  >
                    <i class="fe fe-x"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ $t("name") }}</label>
                      <input
                        :class="[
                          'form-control',
                          error.name ? 'is-invalid' : '',
                        ]"
                        type="text"
                        placeholder="name"
                        v-model="userData.name"
                      />
                      <small style="color: red" v-if="error.name">{{
                        error.name[0]
                      }}</small>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ $t("user name") }}</label>
                      <input
                        :class="[
                          'form-control',
                          error.user_name ? 'is-invalid' : '',
                        ]"
                        type="text"
                        placeholder="user name"
                        v-model="userData.user_name"
                      />
                      <small style="color: red" v-if="error.user_name">{{
                        error.user_name[0]
                      }}</small>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ $t("email") }}</label>
                      <input
                        :class="[
                          'form-control',
                          error.email ? 'is-invalid' : '',
                        ]"
                        type="email"
                        placeholder="Email"
                        v-model="userData.email"
                      />
                      <small style="color: red" v-if="error.email">{{
                        error.email[0]
                      }}</small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ $t("phone") }}</label>
                      <input
                        :class="[
                          'form-control',
                          error.phone ? 'is-invalid' : '',
                        ]"
                        type="text"
                        placeholder="phone number"
                        v-model="userData.phone"
                      />
                      <small style="color: red" v-if="error.phone">{{
                        error.phone[0]
                      }}</small>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ $t("password") }}</label>
                      <input
                        :class="[
                          'form-control',
                          error.password ? 'is-invalid' : '',
                        ]"
                        type="password"
                        :placeholder="$t('password')"
                        v-model="userData.password"
                      />
                      <small style="color: red" v-if="error.password">{{
                        error.password[0]
                      }}</small>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{
                        $t("confirm password")
                      }}</label>
                      <input
                        :class="[
                          'form-control',
                          error.confirm_password ? 'is-invalid' : '',
                        ]"
                        type="password"
                        :placeholder="$t('confirm password')"
                        v-model="userData.confirm_password"
                      />
                      <small style="color: red" v-if="error.confirm_password">{{
                        error.confirm_password[0]
                      }}</small>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="form-label">{{
                        $t("profile picture")
                      }}</label>
                      <vue-dropzone
                        name="file"
                        ref="myVueDropzone"
                        id="singledropzone"
                        :options="singledropzoneOptions"
                        :class="[
                          'dropzone digits',
                          error.profile_picture ? 'is-invalid' : '',
                        ]"
                        @vdropzone-file-added="handleFileAdded"
                        @vdropzone-removed-file="removed"
                      >
                      </vue-dropzone>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary btn-sm" type="submit">
                  {{ $t("Update Profile") }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import axios from "axios";
export default {
  data() {
    return {
      ProfileInfo: this.$store.getters.USER,
      role: this.$store.getters.authUserRole,

      userData: {
        name: "",
        user_name: "",
        email: "",
        password: "",
        confirm_password: "",
        phone: "",
        file: [],
      },
      error: [],

      singledropzoneOptions: {
        url: "http://127.0.0.1:8000/api/admin/adminAdd",
        thumbnailWidth: 150,
        maxFiles: 1,
        autoProcessQueue: false,
        maxFilesize: 2,
        acceptedFiles: ".jpg , .jpeg, .png",
        maxNumberOfFiles: 1,
        addRemoveLinks: true,
        dictDefaultMessage:
          "<i class='icon-cloud-up'></i><br />Select Profile Picture",
      },
    };
  },

  beforeMount() {
    this.Info();
  },

  components: {
    vueDropzone: vue2Dropzone,
  },

  methods: {
    handleFileAdded(file) {
      console.log(file);
      if (this.userData.file.length < 1) {
        this.userData.file = file;
      }
    },
    removed(files) {
      if (files.name == this.userData.file.name) {
        this.userData.file = [];
      }
    },

    handelSubmitForm() {
      let formData = new FormData();

      formData.append("name", this.userData.name);
      formData.append("user_name", this.userData.user_name);
      formData.append("email", this.userData.email);
      formData.append("password", this.userData.password);
      formData.append("confirm_password", this.userData.confirm_password);
      formData.append("profile_picture", this.userData.file);
      formData.append("phone", this.userData.phone);

      let config = {
        headers: {
          "Content-Type":
            "multipart/form-data; charset=utf-8 ; boundary=" +
            Math.random().toString().substr(2),
        },
      };

      axios
        .post(
          `updateProfileInfo/${this.$store.getters.USER.id}`,
          formData,
          config
        )
        .then((res) => {
          if (res.data.success) {
            this.$store.dispatch("SET_USER", res.data.user);
            (this.ProfileInfo = this.$store.getters.USER),
              Toast.fire({
                icon: "success",
                title: this.$t("profile updated successfully"),
              });
            this.error = [];
          } else if (res.data.success == false) {
            this.error = res.data.message;
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },

    Info() {
      this.userData.name = this.$store.getters.USER.name;
      this.userData.user_name = this.$store.getters.USER.user_name;
      this.userData.email = this.$store.getters.USER.email;
      this.userData.phone = this.$store.getters.USER.phone;
      this.userData.phone = this.$store.getters.USER.phone;
    },
  },
};
</script>



