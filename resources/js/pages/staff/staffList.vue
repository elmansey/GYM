


<template>
  <div v-if="isLoadig">
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('staff list')" />
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="datatable-vue m-0">
                <div class="row" style="width: 80%">
                  <div
                    class="col-xl-4 col-sm-12"
                    style="margin-bottom: 10px; margin-top: 32px"
                  >
                    <div>
                      <input
                        class="form-control"
                        type="text"
                        placeholder="search by phone number"
                        v-model="Filter_text"
                        style="width: 80%"
                      />
                    </div>
                  </div>
                  <div
                    class="col-xl-4 col-sm-12"
                    style="margin-bottom: 10px; margin-top: 32px"
                  >
                    <div>
                      <input
                        class="form-control"
                        type="text"
                        placeholder="search by  name"
                        v-model="Filter_name"
                        style="width: 80%"
                      />
                    </div>
                  </div>
                </div>
                <div class="table-responsive vue-smart">
                  <b-table
                    id="tablePrint"
                    show-empty
                    stacked="md"
                    :items="staffPersonSearch"
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
                            ? `../../profile_pictures/${data.item.profile_picture}`
                            : '../../profile_pictures/DefaultProfile.jpg'
                        "
                      />
                    </template>

                    <template #cell(qr_code)="data">
                      <img
                        style="width: 40px; height: 40px; border-radius: 50%"
                        :src="'../../' + data.item.qr_code"
                      />
                    </template>

                    <template #cell(role)="data">
                      <span
                        class="badge badge-success"
                        v-for="(v, k) in data.item.roles"
                        :key="k"
                      >
                        {{ v.name }}
                      </span>
                    </template>

                    <template #cell(active)="data">
                      <span
                        class="badge badge-success"
                        v-if="data.item.isActive"
                      >
                        active
                      </span>
                      <span
                        class="badge badge-danger"
                        v-if="!data.item.isActive"
                      >
                        not Active
                      </span>
                    </template>

                    <template #cell(action)="data">
                      <div>
                        <b-button-group class="btn-group-pill" size="sm">
                          <b-button variant="outline-primary">
                            <router-link
                              variant="outline-warning"
                              :to="{
                                name: 'editPersonInStaff',
                                params: { staffPersonId: data.item.id },
                              }"
                              v-if="can('edit-member-from-team')"
                            >
                              {{ $t("edit") }}
                            </router-link>
                          </b-button>
                          <b-button
                            variant="outline-danger"
                            @click="DeletestaffModal(data.item.id, data.index)"
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
                <template #modal-title> Delete Team member </template>
                <div class="d-block text-center">
                  <h5>are you sure to delete this person from staff</h5>
                </div>
                <b-button
                  class="mt-3"
                  v-b-modal.modal-sm
                  variant="default"
                  @click="$bvModal.hide('bv-modal-example')"
                  >Cancel</b-button
                >
                <b-button
                  class="mt-3"
                  v-b-modal.modal-sm
                  variant="danger"
                  @click.prevent="deletePersonInStaff"
                  >delete</b-button
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
        { qr_code: this.$t("QR") },
        { key: "user_name", label: this.$t("user name"), sortable: false },
        { key: "email", label: this.$t("email"), sortable: false },
        { key: "phone", label: this.$t("phone"), sortable: false },
        { role: this.$t("role") },
        { active: this.$t("active") },
        { action: this.$t("action") },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],

      staffPerson: [],
      filter: {
        currentPage: 1,
        totalPages: 0,
      },
      id: "",
      key: "",
      isLoadig: false,
      Filter_text: "",
      Filter_name: "",
    };
  },
  beforeMount() {
    axios
      .get("staff")
      .then((res) => {
        if (res.data.success == true) {
          this.staffPerson = res.data.staff;
          this.isLoadig = true;
        }
      })
      .catch((err) => {});
  },
  created() {},
  computed: {
    staffPersonSearch() {
      if (this.Filter_text.length > 0) {
        return this.staffPerson.filter((item) => {
          //match
          return item.phone.includes(this.Filter_text.toLowerCase());
        });
      } else if (this.Filter_name.length > 0) {
        return this.staffPerson.filter((item) => {
          //match
          return item.name.includes(this.Filter_name.toLowerCase());
        });
      } else {
        return this.staffPerson;
      }
    },
  },
  methods: {
    DeletestaffModal(id, key) {
      this.id = id;
      this.key = key;
      this.$bvModal.show("bv-modal-example");
    },

    deletePersonInStaff() {
      axios
        .get("deleteItemInStaff/" + this.id)
        .then((res) => {
          if (res.data.success == true) {
            this.staffPerson.splice(this.key, 1);

            this.id = "";
            this.key = "";
            this.$bvModal.hide("bv-modal-example");

            Toast.fire({
              icon: "success",
              title: "deleted this person from staff successfully",
            });
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


