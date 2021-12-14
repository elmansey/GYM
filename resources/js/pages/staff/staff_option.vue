<template>
  <div v-if="isLoading">
    <Breadcrumbs
      :main="$t('Dashboard')"
      :title="edit ? $t('edit person in staff') : $t('add person in staff')"
    />
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="select2-drpdwn">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header"></div>
              <div class="card-body">
                <form @submit.prevent="handelSubmitData">
                  <div class="row">
                    <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                      <div class="col-form-label">{{ $t("name") }}</div>

                      <input
                        name="name"
                        :class="[
                          'form-control',
                          (submited && !$v.staffData.name.required) ||
                          error.name
                            ? 'is-invalid'
                            : '',
                        ]"
                        v-model="staffData.name"
                      />
                      <small style="color: red" v-if="error.name">{{
                        $t(error.name[0])
                      }}</small>
                      <b-form-invalid-feedback
                        style="color: red"
                        v-if="submited && !$v.staffData.name.required"
                        >{{
                          $t("the first name faild is required")
                        }}</b-form-invalid-feedback
                      >
                    </div>

                    <div class="mb-2 col-md-6 co1l-lg-6 col-sm-12">
                      <div class="col-form-label">{{ $t("phone number") }}</div>

                      <input
                        name="phone"
                        :class="[
                          'form-control',
                          (submited && !$v.staffData.phone.required) ||
                          error.phone
                            ? 'is-invalid'
                            : '',
                        ]"
                        v-model="staffData.phone"
                      />
                      <small style="color: red" v-if="error.phone">{{
                        $t(error.phone[0])
                      }}</small>
                      <b-form-invalid-feedback
                        style="color: red"
                        v-if="submited && !$v.staffData.phone.required"
                        >{{
                          $t("the phone faild is required")
                        }}</b-form-invalid-feedback
                      >
                    </div>

                    <div hidden class="mb-2 col-md-6 col-lg-6 col-sm-12">
                      <select hidden v-model="staffData.role"></select>
                    </div>

                    <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                      <div class="col-form-label">
                        {{ $t("Upload profile picture") }}
                      </div>

                      <vue-dropzone
                        name="file"
                        ref="myVueDropzone"
                        id="singledropzone"
                        :options="singledropzoneOptions"
                        :class="[
                          'dropzone digits',
                          error.password ? 'is-invalid' : '',
                        ]"
                        @vdropzone-file-added="handleFileAdded"
                        @vdropzone-removed-file="removed"
                      >
                      </vue-dropzone>

                      <small style="color: red" v-if="error.profile_picture">{{
                        $t(error.profile_picture[0])
                      }}</small>
                    </div>

                    <!-- <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                                                        <input  type="checkbox" v-model="allowLogin"/>
                                                        <span class="col-form-label">alow login</span>

                                                  </div> -->

                    <div class="login data row">
                      <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                        <div class="col-form-label">{{ $t("email") }}</div>

                        <input
                          name="email"
                          type="email"
                          :class="[
                            'form-control',
                            error.email ||
                            (submited && !$v.staffData.loginData.email.required)
                              ? 'is-invalid'
                              : '',
                          ]"
                          v-model="staffData.loginData.email"
                        />
                        <small style="color: red" v-if="error.email">{{
                          $t(error.email[0])
                        }}</small>
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="!$v.staffData.loginData.email.required"
                          >{{
                            $t("the email faild is required")
                          }}</b-form-invalid-feedback
                        >
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="!$v.staffData.loginData.email.email"
                          >{{
                            $t("the email must vaild email")
                          }}</b-form-invalid-feedback
                        >
                      </div>

                      <div class="mb-2 col-md-12 col-lg-6 col-sm-12">
                        <div class="col-form-label">{{ $t("RF code") }}</div>

                        <input
                          name="name"
                          :class="[
                            'form-control',
                            error.RF_code ? 'is-invalid' : '',
                          ]"
                          v-model="staffData.loginData.RF_code"
                        />
                        <small style="color: red" v-if="error.RF_code">{{
                          $t(error.RF_code[0])
                        }}</small>
                      </div>

                      <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                        <div class="col-form-label">{{ $t("user name") }}</div>

                        <input
                          name="user_name"
                          type="text"
                          :class="[
                            'form-control',
                            (submited &&
                              !$v.staffData.loginData.user_name.required) ||
                            error.user_name
                              ? 'is-invalid'
                              : '',
                          ]"
                          v-model="staffData.loginData.user_name"
                        />
                        <small style="color: red" v-if="error.user_name">{{
                          $t(error.user_name[0])
                        }}</small>
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="!$v.staffData.loginData.user_name.required"
                          >{{
                            $t("the user name failde is required")
                          }}</b-form-invalid-feedback
                        >
                      </div>
                      <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                        <div class="col-form-label">{{ $t("password") }}</div>

                        <input
                          name="password"
                          type="password"
                          :class="[
                            'form-control',
                            (submited &&
                              !$v.staffData.loginData.password.requiredIf) ||
                            !$v.staffData.loginData.password.maxLength ||
                            !$v.staffData.loginData.password.minLength ||
                            error.password
                              ? 'is-invalid'
                              : '',
                          ]"
                          v-model="staffData.loginData.password"
                        />
                        <small style="color: red" v-if="error.password">{{
                          $t(error.password[0])
                        }}</small>
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="!$v.staffData.loginData.password.requiredIf"
                          >{{
                            $t("the password failde is required")
                          }}</b-form-invalid-feedback
                        >
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="!$v.staffData.loginData.password.maxLength"
                          >{{ $t("the max character allow is") }}
                          {{
                            $v.staffData.loginData.password.$params.maxLength
                              .max
                          }}
                        </b-form-invalid-feedback>
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="!$v.staffData.loginData.password.minLength"
                        >
                          {{ $t("the min character allow is") }}
                          {{
                            $v.staffData.loginData.password.$params.minLength
                              .min
                          }}
                        </b-form-invalid-feedback>
                      </div>
                      <div class="mb-2 col-md-6 col-lg-6 col-sm-12">
                        <div class="col-form-label">
                          {{ $t("confirm password") }}
                        </div>

                        <input
                          name="password"
                          type="password"
                          :class="[
                            'form-control',
                            (submited &&
                              !$v.staffData.loginData.confirm_Password
                                .requiredIf) ||
                            error.confirm_Password
                              ? 'is-invalid'
                              : '',
                          ]"
                          v-model="staffData.loginData.confirm_Password"
                        />
                        <small
                          style="color: red"
                          v-if="error.confirm_Password"
                          >{{ $t(error.confirm_Password) }}</small
                        >
                        <b-form-invalid-feedback
                          style="color: red"
                          v-if="
                            submited &&
                            !$v.staffData.loginData.confirm_Password.requiredIf
                          "
                        >
                          {{ $t("the confirm password failde is required") }}
                        </b-form-invalid-feedback>
                      </div>
                      <div class="mb-2 col-md-12 col-lg-12 col-sm-12 mt-3">
                        <div class="media">
                          <label class="col-form-label m-r-10">{{
                            $t("active")
                          }}</label>
                          <div
                            class="media-body text-right switch-lg icon-state"
                          >
                            <label class="switch">
                              <input
                                type="checkbox"
                                checked=""
                                v-model="staffData.loginData.isActive"
                              /><span class="switch-state"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mb-2 col-md-12 col-lg-12 col-sm-12">
                      <button
                        type="submit"
                        class="btn btn-primary mt-3"
                        v-if="!edit"
                      >
                        {{ $t("Save") }}
                      </button>

                      <button
                        type="submit"
                        class="btn btn-success mt-3"
                        v-if="edit"
                      >
                        {{ $t("update") }}
                      </button>
                    </div>
                  </div>
                </form>
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
import Multiselect from "vue-multiselect";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

import axios from "axios";
import {
  required,
  minLength,
  maxLength,
  between,
  sameAs,
  requiredIf,
  email,
} from "vuelidate/lib/validators";

export default {
  data() {
    return {
      staffData: {
        name: "",
        phone: "",
        loginData: {
          email: "",
          user_name: "",
          password: "",
          confirm_Password: "",
          isActive: true,
          RF_code: "",
        },
        profile_picture: "",
        role: { id: 3, name: "staff" },
      },
      isLoading: false,
      allowLogin: false,
      submited: false,

      options: [],
      error: "",
      edit: true,

      singledropzoneOptions: {
        url: "http://127.0.0.1:8000/api/addPersonInStaff",
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
  components: {
    Multiselect,
    vueDropzone: vue2Dropzone,
  },

  beforeMount() {
    if (this.$route.params.staffPersonId) {
      this.edit = true;

      axios
        .get(`getItemFromStaffById/${this.$route.params.staffPersonId}`)
        .then((res) => {
          console.log(res);

          if (res.data.success) {
            this.staffData.name = res.data.staff.name;
            this.staffData.phone = res.data.staff.phone;
            this.staffData.role = res.data.staff.roles;
            this.staffData.loginData.email = res.data.staff.email;
            this.staffData.loginData.user_name = res.data.staff.user_name;
            this.staffData.loginData.isActive = res.data.staff.isActive;
            this.staffData.loginData.RF_code = res.data.staff.RF_code;
            this.isLoading = true;

            // this.allowLogin = (res.data.staff.email)
          }

          if (res.data.status == 404) {
            this.$router.push({ name: "staffList" });
          }
        })
        .catch((err) => {});
    } else {
      this.edit = false;
      this.isLoading = true;
    }
  },

  beforeCreate() {
    axios
      .get("getStaffRole")
      .then((res) => {
        this.options = res.data.staffRole;
      })
      .catch((err) => {});
  },

  validations: {
    staffData: {
      name: {
        required: required,
      },

      phone: {
        required: required,
      },

      loginData: {
        email: {
          required: required,

          email,
        },
        user_name: {
          required: required,
        },
        password: {
          requiredIf: requiredIf(function () {
            return this.edit == false;
          }),
          maxLength: maxLength(25),
          minLength: minLength(6),
        },
        confirm_Password: {
          requiredIf: requiredIf(function () {
            return this.edit == false;
          }),
        },
      },
      role: {
        required: required,
      },
    },
  },

  methods: {
    handelSubmitData() {
      this.$v.staffData.$touch();
      this.submited = true;

      if (!this.$v.staffData.$invalid) {
        if (this.edit == false) {
          let formData = new FormData();

          formData.append("name", this.staffData.name);
          formData.append("phone", this.staffData.phone);
          formData.append("user_name", this.staffData.loginData.user_name);
          formData.append("email", this.staffData.loginData.email);
          formData.append("password", this.staffData.loginData.password);
          formData.append("isActive", this.staffData.loginData.isActive);
          formData.append("RF_code", this.staffData.loginData.RF_code);
          formData.append(
            "confirm_Password",
            this.staffData.loginData.confirm_Password
          );
          formData.append("profile_picture", this.staffData.profile_picture);
          formData.append("role", JSON.stringify(this.staffData.role));

          let config = {
            headers: {
              "Content-Type":
                "multipart/form-data; charset=utf-8 ; boundary=" +
                Math.random().toString().substr(2),
            },
          };

          axios
            .post("addInStaff", formData, config)
            .then((res) => {
              if (res.data.success == true) {
                this.error = "";
                this.submited = false;

                this.staffData.name = "";
                this.staffData.phone = "";

                this.staffData.loginData.email = "";
                this.staffData.loginData.user_name = "";
                this.staffData.loginData.password = "";
                this.staffData.loginData.isActive = true;
                this.staffData.loginData.RF_code = "";
                this.staffData.loginData.confirm_Password = "";
                this.staffData.profile_picture = "";
                (this.staffData.role = { id: 3, name: "staff" }),
                  this.$router.push({ name: "staffList" });
                Toast.fire({
                  icon: "success",
                  title: this.$t("person added in staff successfully"),
                });

                console.log(res.data);
              } else if (res.data.success == false) {
                this.error = res.data.message;
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }

        if (this.edit) {
          let formData = new FormData();

          formData.append("name", this.staffData.name);
          formData.append("phone", this.staffData.phone);
          formData.append("user_name", this.staffData.loginData.user_name);
          formData.append("email", this.staffData.loginData.email);
          formData.append("password", this.staffData.loginData.password);
          formData.append("isActive", this.staffData.loginData.isActive);
          formData.append("RF_code", this.staffData.loginData.RF_code);
          formData.append(
            "confirm_Password",
            this.staffData.loginData.confirm_Password
          );
          formData.append("profile_picture", this.staffData.profile_picture);
          formData.append("role", JSON.stringify(this.staffData.role));

          let config = {
            headers: {
              "Content-Type":
                "multipart/form-data; charset=utf-8 ; boundary=" +
                Math.random().toString().substr(2),
            },
          };

          axios
            .post(
              `updateInStaff/${this.$route.params.staffPersonId}`,
              formData,
              config
            )
            .then((res) => {
              if (res.data.success == true) {
                this.error = "";
                this.submited = false;

                this.staffData.name = "";
                this.staffData.phone = "";

                this.staffData.loginData.email = "";
                this.staffData.loginData.user_name = "";
                this.staffData.loginData.password = "";
                this.staffData.loginData.isActive = true;
                this.staffData.loginData.RF_code = "";
                this.staffData.loginData.confirm_Password = "";
                this.staffData.profile_picture = "";
                (this.staffData.role = { id: 3, name: "staff" }),
                  this.$router.push({ name: "staffList" });

                Toast.fire({
                  icon: "success",
                  title: this.$t("staff person updated successfully"),
                });
                console.log(res.data);
              } else if (res.data.success == false) {
                this.error = res.data.message;
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }
      }
    },

    handleFileAdded(file) {
      console.log(file);
      if (this.staffData.profile_picture.length < 1) {
        this.staffData.profile_picture = file;
      }
    },
    removed(files) {
      if (files.name == this.staffData.profile_picture.name) {
        this.staffData.profile_picture = [];
      }
    },

    asyncFind(query) {
      this.options = findService(query);
    },

    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.taggingOptions.push(tag);
      this.taggingSelected.push(tag);
    },

    // editAdmin(){

    //     axios.post('userUpdate',this.staffData)
    //         .then(res => {

    //             if(res.data.success == true){
    //                 Toast.fire({
    //                     icon: 'success',
    //                     title: 'admin updated successfully'
    //                 })
    //                 this.$router.push({name : 'adminsList'})

    //             }else if(res.data.success == false) {

    //                 this.error = res.data.message
    //             }

    //         })
    //         .catch(err => {
    //             console.log(err)
    //         })

    // }
  },

  watch: {
    $route(to, from) {
      if (to.name == "addPersonInStaff") {
        this.edit = false;
        (this.staffData.name = ""),
          (this.staffData.phone = ""),
          (this.staffData.loginData.email = ""),
          (this.staffData.loginData.user_name = ""),
          (this.staffData.loginData.password = ""),
          (this.staffData.loginData.password = ""),
          (this.staffData.loginData.isActive = true),
          (this.staffData.loginData.RF_code = ""),
          (this.staffData.profile_picture = ""),
          (this.staffData.role = { id: 3, name: "staff" }),
          (this.allowLogin = false);
      }
    },
  },
};
</script>
<style>
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
