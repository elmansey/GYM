<template>
  <div v-if="isLoadig">
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('class list')" />

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div
                v-if="can('delete-By-Select-Multi-Class')"
                style="float: right; margin-bottom: 10px"
              >
                <div>
                  <b-button-group style="height: auto">
                    <b-button size="sm" pill variant="dark">
                      <div>
                        <div
                          style="float: left; margin-top: 8px"
                          id="checkInput"
                        >
                          <input
                            :disabled="CheckDiseble"
                            type="checkbox"
                            @click="selectAll"
                            v-model="selectedAll"
                          />
                        </div>
                        <b-tooltip
                          v-if="CheckDiseble"
                          target="checkInput"
                          triggers="hover"
                          placement="top"
                          >data is empty</b-tooltip
                        >

                        <div style="float: right">
                          <b-dropdown
                            :disabled="emptyCheckData"
                            variant="dark"
                            size="sm"
                            right
                            id="dropdownMenuButton"
                          >
                            <b-dropdown-item @click="DeleteclassSelectedModal">
                              <feather
                                type="trash"
                                style="width: 20px"
                              ></feather>
                              {{ $t("delete") }}
                            </b-dropdown-item>
                          </b-dropdown>
                        </div>
                      </div>
                    </b-button>
                  </b-button-group>
                </div>
                <b-tooltip
                  target="dropdownMenuButton"
                  triggers="hover"
                  placement="top"
                  >select to choose</b-tooltip
                >
              </div>

              <div class="datatable-vue m-0">
                <div class="table-responsive vue-smart">
                  <b-table
                    id="tablePrint"
                    show-empty
                    stacked="md"
                    :items="classes"
                    :fields="tablefields"
                    :current-page="currentPage"
                    :per-page="perPage"
                  >
                    <template #cell(check)="data">
                      <input
                        type="checkbox"
                        :value="data.item.id"
                        v-model="selected"
                        v-if="can('delete-By-Select-Multi-Class')"
                      />
                    </template>

                    <template #cell(id)="data">
                      {{ ++data.index }}
                    </template>

                    <template
                      #cell(action)="data"
                      v-if="
                        can('edit-class-schedule' || 'delete-class-schedule')
                      "
                    >
                      <div>
                        <b-button-group class="btn-group-pill" size="sm">
                          <b-button
                            variant="outline-primary"
                            v-if="can('edit-class-schedule')"
                          >
                            <router-link
                              variant="outline-warning"
                              :to="{
                                name: 'updateClassSchedule',
                                params: { classScheduleId: data.item.id },
                              }"
                              v-if="can('edit-class-schedule')"
                            >
                              {{ $t("edit") }}
                            </router-link>
                          </b-button>
                          <b-button
                            variant="outline-danger"
                            @click="DeleteclassModal(data.item.id, data.index)"
                            v-if="can('delete-class-schedule')"
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
                  {{ $t("Delete class") }}
                </template>
                <div class="d-block text-center">
                  <h5>{{ $t("are you sure to delete this class") }}</h5>
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
                  @click="deleteclass"
                  >{{ $t("delete") }}</b-button
                >
              </b-modal>

              <b-modal id="bv-modal-select-item" hide-footer>
                <template #modal-title>
                  {{ $t("Delete selected class") }}
                </template>
                <div class="d-block text-center">
                  <h5>
                    {{ $t("are you sure to delete this selected class") }}
                  </h5>
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
                  @click="deleteSelectedItem"
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
        { check: this.$t("check") },
        { ID: this.$t("id") },
        {
          key: "staff_relation.name",
          label: this.$t("staff name"),
          sortable: false,
        },
        {
          key: "group_relation.name",
          label: this.$t("group Name"),
          sortable: false,
        },
        {
          key: "startingTime",
          label: this.$t("starting Time"),
          sortable: false,
        },
        { key: "endingTime", label: this.$t("ending Time"), sortable: false },
        {
          key: "trainingLocation",
          label: this.$t("training Location"),
          sortable: false,
        },
        { action: this.$t("action") },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],

      classes: [],
      selected: [],
      selectedAll: false,
      emptyCheckData: true,
      CheckDiseble: true,

      filter: {
        currentPage: 1,
        totalPages: 0,
      },

      id: "",
      kay: "",
      isLoadig: false,
    };
  },
  beforeCreate() {
    axios
      .get("classes")
      .then((res) => {
        this.classes = res.data.classes;
        this.CheckDiseble = res.data.classes.length < 1;
        this.totalRows = res.data.classes.length;
        this.isLoadig = true;
      })
      .catch((err) => {
        console.error(err);
      });
  },
  beforeMount() {},
  created() {},

  methods: {
    selectAll(event) {
      if (event.target.checked == false) {
        this.selected = [];
        this.emptyCheckData = true;
      } else {
        this.classes.forEach((element) => {
          this.selected.push(element.id);
        });
        this.emptyCheckData = false;
      }
    },

    DeleteclassSelectedModal() {
      this.$bvModal.show("bv-modal-select-item");
    },

    deleteSelectedItem() {
      axios
        .post("deleteSelectedItem", this.selected)
        .then((res) => {
          if (res.data.success) {
            axios
              .get("classes")
              .then((res) => {
                this.classes = res.data.classes;
                this.$bvModal.hide("bv-modal-select-item");
                this.selectedAll = false;
                this.selected = [];
                this.isLoadig = true;
                Toast.fire({
                  icon: "success",
                  title: this.$t("selected item  deleted successfully"),
                });
              })
              .catch((err) => {
                console.error(err);
              });
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },

    DeleteclassModal(id, key) {
      this.id = id;
      this.kay = key;
      this.$bvModal.show("bv-modal-example");
    },

    deleteclass() {
      axios
        .get(`deleteClass/${this.id}`)
        .then((res) => {
          if (res.data.success == true) {
            this.classes.splice(this.key, 1);
            this.id = "";
            this.kay = "";
            Toast.fire({
              icon: "success",
              title: this.$t("class deleted successfully"),
            });

            this.$bvModal.hide("bv-modal-example");
          }
        })
        .catch((err) => {});
    },
  },

  watch: {
    selected: function (selected) {
      this.CheckDiseble = this.classes.length < 1;
      this.emptyCheckData = selected.length < 1;
      this.selectedAll = selected.length === this.classes.length;
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
