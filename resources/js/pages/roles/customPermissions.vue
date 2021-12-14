<template>
  <div>
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('custom permissions')" />
    <div
      style="
        max-width: 600px;
        margin: auto;

        background-color: #fff;
      "
      class="card-body"
    >
      <div style="display: flex" class="mb-10">
        <h4 class="card-title">{{ $t("custom permissions") }}</h4>
        <feather
          style="margin-left: 30px; margin-top: 5px"
          type="help-circle"
        ></feather>
      </div>

      <section class="ps-container dashboard-list-with-user ps">
        <div class="d-flex flex-row">
          <div style="width: 100%">
            <div class="col col-12">
              <b-form-group
                style="border: none"
                class="has-float-label my-3 p-0"
              >
                <v-select
                  @input="getOldCustomPermission"
                  :options="options"
                  :searchable="true"
                  :clearable="true"
                  v-model="custom.user"
                  placeholder="Search"
                  label="name"
                />
              </b-form-group>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div
      v-if="isLoading"
      class="row"
      style="
        max-width: 600px;
        margin: auto;
        padding: 0px 17px;
        height: 520px;
        overflow: scroll;
        background-color: #fff;
      "
    >
      <div
        class="col-6"
        style="margin-top: 20px"
        v-for="(item, index) in permission"
        :key="index"
      >
        <div class="media">
          <div class="media-body text-left icon-state">
            <label class="switch">
              <input
                type="checkbox"
                :value="item"
                checked
                v-model="custom.permissinonChoose"
              />
              <span class="switch-state"></span>
            </label>
          </div>

          <div class="media-body text-right icon-state">
            <label class="col-form-label m-r-10" style="font-family: Cairo">
              {{ $t(item.name) }}
            </label>
          </div>
        </div>
      </div>
    </div>

    <div
      v-else
      class="row"
      style="
        max-width: 600px;
        margin: auto;
        padding: 0px 17px;
        height: 520px;
        overflow: scroll;
        background-color: #fff;
      "
    >
      <div
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
    </div>

    <div
      style="
        max-width: 600px;
        margin: auto auto 20px auto;
        background-color: #fff;
        padding: 20px;
      "
    >
      <button @click="handelSaveData" class="btn btn-outline-primary btn-pill">
        {{ $t("Save") }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      options: [],
      permission: [],
      custom: {
        permissinonChoose: [],
        user: "",
      },
      isLoading: false,
    };
  },

  beforeMount() {
    axios
      .get("createRole")
      .then((res) => {
        this.permission = res.data.permission;
        this.isLoading = true;
      })
      .catch((err) => {});

    axios
      .get("getAllUserToCustomPermission")
      .then((res) => {
        this.options = res.data.users;
      })
      .catch((err) => {});
  },
  methods: {
    handelSaveData() {
      if (this.custom.user == null || this.custom.user == "") {
        Toast.fire({
          icon: "error",
          title: this.$t("There are empty fields"),
        });
      } else {
        let formData = new FormData();

        formData.append(
          "permissions",
          JSON.stringify(this.custom.permissinonChoose)
        );
        formData.append("user", JSON.stringify(this.custom.user));

        axios
          .post("assignCustomPermissions", formData)
          .then((res) => {
            if (res.data.success) {
              Toast.fire({
                icon: "success",
                title: this.$t("Permissions allowed successfully"),
              });
            }
          })
          .catch((err) => {});
      }
    },

    getOldCustomPermission() {
      axios
        .get(`getOldCustomPermission/${this.custom.user.id}`)
        .then((res) => {
          if (res.data.success) {
            this.custom.permissinonChoose = [];
            res.data.oldPermission.map((v, k) => {
              this.custom.permissinonChoose.push(v.permission_relassion);
            });
          }
        })
        .catch((err) => {});
    },
  },
};
</script>
