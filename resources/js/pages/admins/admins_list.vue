


<template>
  <div v-if="isLoadig">
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('admin list')" />
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="datatable-vue m-0">
                <div class="table-responsive vue-smart">
                  <b-table
                    id="tablePrint"
                    show-empty
                    stacked="md"
                    :items="admins"
                    :fields="tablefields"
                    :current-page="currentPage"
                    :per-page="perPage"
                  >
                    <template #cell(id)="data">
                      {{ ++data.index }}
                    </template>

                    <template #cell(profile_picture)="data">
                      <img
                        style="width: 40px; height: 40px; border-radius: 50%"
                        :src="
                          data.item.profile_picture
                            ? '../../profile_pictures/' +
                              data.item.profile_picture
                            : '../../profile_pictures/DefaultProfile.jpg'
                        "
                      />
                    </template>

                    <template #cell(QR_code)="data">
                      <img
                        style="width: 45px; height: 45px"
                        :src="'../../' + data.item.qr_code"
                      />
                    </template>

                    <template #cell(role)="data">
                      <span
                        class="badge badge-success"
                        v-for="(v, k) in data.item.role"
                        :key="k"
                      >
                        {{ v.name }}
                      </span>
                    </template>

                    <template
                      #cell(action)="data"
                      v-if="
                        can('edit-class-schedule' || 'delete-class-schedule')
                      "
                    >
                      <div>
                        <b-button-group class="btn-container">
                          <b-button
                            squared
                            variant="outline-primary"
                            class="btn-sm btn-child"
                          >
                            <router-link
                              squared
                              variant="outline-warning"
                              class="btn-sm btn-child"
                              :to="{
                                name: 'updateAdmin',
                                params: { adminId: data.item.id },
                              }"
                              v-if="can('edit-member-from-team')"
                            >
                              {{ $t("edit") }}
                            </router-link>
                          </b-button>
                          <b-button
                            squared
                            variant="outline-danger"
                            class="btn-sm btn-child"
                            @click="DeleteAdminModal(data.item.id, data.index)"
                            v-if="can('delete-member-from-team')"
                          >
                            {{ $t("delete") }}
                          </b-button>
                        </b-button-group>
                      </div>
                    </template>
                  </b-table>
                </div>

                <b-col md="6" class="my-1">
                  <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    class="my-0"
                  ></b-pagination>
                </b-col>
              </div>

              <b-modal id="bv-modal-example" hide-footer>
                <template #modal-title>
                  {{ $t("Delete Team member") }}
                </template>
                <div class="d-block text-center">
                  <h5>{{ $t("are you sure to delete this Admin") }}</h5>
                </div>
                <b-button
                  class="mt-3"
                  v-b-modal.modal-sm
                  variant="default"
                  @click="$bvModal.hide('bv-modal-example')"
                  >{{ $t("Cancel") }}</b-button
                >
                <b-button
                  class="mt-3"
                  v-b-modal.modal-sm
                  variant="danger"
                  @click.prevent="deleteAdmin"
                  >{{ $t("delete") }}</b-button
                >
              </b-modal>
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
      tablefields: [
        { id: this.$t("id") },
        { profile_picture: this.$t("profile_picture") },
        {
          key: "Personal_uuid",
          label: this.$t("Personal uuid"),
          sortable: false,
        },
        { key: "name", label: this.$t("name"), sortable: false },
        { QR_code: this.$t("QR") },
        { key: "user_name", label: this.$t("user name"), sortable: false },
        { key: "email", label: this.$t("email"), sortable: false },
        { key: "phone", label: this.$t("phone"), sortable: false },
        { role: this.$t("role") },
        { action: this.$t("action") },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],

      admins: null,
      filter: {
        currentPage: 1,
        totalPages: 0,
      },
      id: "",
      key: "",
      isLoadig: false,
      path: "~/profile_pictures/",
      defaultImg: "@/assets/images/dashboard/DefaultProfile.jpg",
    };
  },
  beforeMount() {
    axios
      .get("users")
      .then((res) => {
        if (res.data.success == true) {
          this.admins = res.data.admins;
          this.totalRows = res.data.admins.lenght;
          this.isLoadig = true;
        }
      })
      .catch((err) => {});
  },
  created() {},
  methods: {
    async EditAdmin(admin) {
      this.$router.push({ name: "updateAdmin", params: { admin } });
    },
    DeleteAdminModal(id, key) {
      this.id = id;
      this.key = key;
      this.$bvModal.show("bv-modal-example");
    },
    deleteAdmin() {
      axios
        .get("userDelete/" + this.id)
        .then((res) => {
          if (res.data.success == true) {
            this.admins.splice(this.key, 1);

            this.id = "";
            this.key = "";
            Toast.fire({
              icon: "success",
              title: this.$t("admin deleted successfully"),
            });

            this.$bvModal.hide("bv-modal-example");
          }
        })
        .catch((err) => {});
    },
  },
};
</script>
<style lang="scss">
.btn-container {
  .btn-child {
    padding: 0.2rem 0.8rem !important;
  }
}
.custom-color {
  color: inherit;
  padding: 0;
  margin: 0;
  border-radius: 0;
  margin-left: -1px;
  &:hover {
    color: inherit;
  }
}
</style>


