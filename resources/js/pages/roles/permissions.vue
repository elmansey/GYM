<template>
  <div v-if="isLoadig">
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('Permissions')" />
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
                    :items="roles"
                    :fields="tablefields"
                    :current-page="currentPage"
                    :per-page="perPage"
                  >
                    <template #cell(id)="data">
                      {{ ++data.index }}
                    </template>

                    <template #cell(permissions)="data">
                      <span
                        class="badge badge-success"
                        style="cursor: pointer"
                        @click.prevent="showRole(data.item)"
                        >{{ data.item.role }}
                      </span>
                    </template>

                    <template #cell(options)="data">
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
                                name: 'editRole',
                                params: { roleId: data.item.id },
                              }"
                              v-if="can('edit-role')"
                            >
                              {{ $t("edit") }}
                            </router-link>
                          </b-button>
                          <b-button
                            squared
                            variant="outline-danger"
                            class="btn-sm btn-child"
                            @click="twoEvent(data.item.id, data.index)"
                            v-if="can('delete-role')"
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
                  >
                  </b-pagination>
                </b-col>
              </div>

              <b-modal id="bv-modal-example" hide-footer>
                <template #modal-title>
                  {{ $t("Delete Role") }}
                </template>
                <div class="d-block text-center">
                  <h5>{{ $t("are you sure to delete this Role") }}</h5>
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
                  @click="destroy"
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
        { key: "role", label: this.$t("name"), sortable: false },
        { permissions: this.$t("Permissions") },
        { options: this.$t("options") },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],

      roles: [],

      filter: {
        currentPage: 1,
        totalPages: 0,
      },
      id: "",
      key: "",
      isLoadig: false,
    };
  },
  beforeMount() {
    axios
      .get("roles")
      .then((res) => {
        this.roles = res.data.RoleAndPermission;
        this.totalRows = res.data.RoleAndPermission.lenght;
        this.isLoadig = true;
      })
      .catch((err) => {
        console.log(err);
      });
  },
  mounted() {},
  methods: {
    // async edit(roleData) {
    //     await this.$store.dispatch('EDIT')
    //     await this.$store.dispatch('ROLEDATATOEDIT', roleData)
    //     this.$router.push('role')
    // },
    // async add() {
    //     await this.$store.dispatch('ADD')
    //     this.$router.push('role')
    // },

    showPermission() {},
    twoEvent(id, key) {
      this.id = id;
      this.key = key;
      this.$bvModal.show("bv-modal-example");
    },

    destroy() {
      axios
        .get("roleDelete/" + this.id)
        .then((res) => {
          if (res.data.success == true) {
            this.id = "";
            this.key = "";
            this.roles.splice(this.key, 1);
            Toast.fire({
              icon: "success",
              title: this.$t("Role deleted successfully"),
            });

            this.$bvModal.hide("bv-modal-example");
          }
        })
        .catch((err) => {
          console.log(err.message);
        });
    },

    async showRole(data) {
      await this.$store.dispatch("roleDataToShow", data);
      this.$router.push("showRole");
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
