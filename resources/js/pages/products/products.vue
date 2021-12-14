


<template>
  <div v-if="isLoadig">
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('products')" />
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
                    :items="products"
                    :fields="tablefields"
                    :current-page="currentPage"
                    :per-page="perPage"
                  >
                    <template #cell(id)="data">
                      {{ ++data.index }}
                    </template>

                    <template #cell(product_img)="data">
                      <img
                        style="width: 70px; height: 70px"
                        :src="
                          data.item.product_img
                            ? '../../product_img/' + data.item.product_img
                            : '../../product_img/no-image.png'
                        "
                      />
                    </template>

                    <template #cell(action)="data">
                      <div>
                        <b-button-group class="btn-group-pill" size="sm">
                          <b-button variant="outline-dark">
                            <router-link
                              :to="{
                                name: 'updateProduct',
                                params: { productId: data.item.id },
                              }"
                              v-if="can('edit-product')"
                            >
                              {{ $t("edit") }}
                            </router-link>
                          </b-button>
                          <b-button
                            variant="outline-danger"
                            @click="
                              DeleteProductModal(data.item.id, data.index)
                            "
                            v-if="can('delete-product')"
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
                  {{ $t("Delete product") }}
                </template>
                <div class="d-block text-center">
                  <h5>{{ $t("are you sure to delete this product") }}</h5>
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
                  @click.prevent="deleteProduct"
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
        {
          key: "product_name",
          label: this.$t("product name"),
          sortable: false,
        },
        {
          key: "product_price",
          label: this.$t("product price"),
          sortable: false,
        },
        { product_img: this.$t("product img") },
        {
          key: "Production_Date",
          label: this.$t("Production Date"),
          sortable: false,
        },
        { key: "Expiry_date", label: this.$t("Expiry date"), sortable: false },
        {
          key: "Product_Quantity",
          label: this.$t("Product Quantity"),
          sortable: false,
        },
        { action: this.$t("action") },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],

      products: [],

      filter: {
        currentPage: 1,
        totalPages: 0,
      },

      id: "",
      elkey: "",
      isLoadig: false,
    };
  },
  beforeMount() {
    axios
      .get("products")
      .then((res) => {
        this.products = res.data.products;
        this.isLoadig = true;
      })
      .then((err) => {});
  },
  mounted() {},
  methods: {
    DeleteProductModal(id, key) {
      this.id = id;
      this.elkey = key;
      this.$bvModal.show("bv-modal-example");
    },

    deleteProduct() {
      axios
        .get(`deleteProduct/${this.id}`)
        .then((res) => {
          if (res.data.success) {
            this.products.splice(this.elkey, 1);
            this.id = "";
            this.elkey = "";
            Toast.fire({
              icon: "success",
              title: this.$t("product deleted successfully"),
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
