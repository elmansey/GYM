<template>
  <div v-if="isLoading">
    <Breadcrumbs :main="$t('Dashboard')" :title="$t('Invoice details')" />
    <!-- Container-fluid starts-->

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="card" id="invoice">
            <div class="card-body">
              <div>
                <div>
                  <div>
                    <div class="row">
                      <div class="col-sm-6">
                        <h3>{{ $store.getters.SETTINGS.Gym_name }}</h3>
                        <p>
                          <span>
                            {{ $t("seller name :") }}
                            {{ invoice.seller_relation.name }} <br />
                            {{ $t("seller RF code :") }}
                            {{ invoice.seller_relation.RF_code }}
                          </span>
                        </p>
                      </div>
                      <div class="col-sm-6">
                        <div class="text-md-right">
                          <h2>{{ $t("invoice number") }}</h2>
                          <h4 class="digits counter">
                            {{ invoice.invoice_number }}
                          </h4>

                          <p>
                            {{ $t("date") }}:
                            <span class="digits">{{ invoice.date }}</span>
                            <br />{{ $t("time") }}:
                            <span class="digits">{{ invoice.time }}</span>
                          </p>
                        </div>
                        <!-- End Title-->
                      </div>
                    </div>
                  </div>
                  <hr />
                  <!-- End InvoiceTop-->
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8"></div>
                  </div>
                  <!-- End Invoice Mid-->
                  <div>
                    <div class="table-responsive invoice-table">
                      <table class="table table-bordered table-striped">
                        <tbody>
                          <tr>
                            <td class="Hours">
                              <h6 class="p-2 mb-0">{{ $t("product name") }}</h6>
                            </td>
                            <td class="Rate">
                              <h6 class="p-2 mb-0">{{ $t("unit price") }}</h6>
                            </td>

                            <td class="Rate">
                              <h6 class="p-2 mb-0">
                                {{ $t("product quantity") }}
                              </h6>
                            </td>

                            <td class="subtotal">
                              <h6 class="p-2 mb-0">{{ $t("Total") }}</h6>
                            </td>
                          </tr>

                          <tr
                            v-for="(item, index) in invoice.invoice_details"
                            :key="index"
                          >
                            <td>
                              <p class="m-0">
                                {{ item.product_name.name }}
                              </p>
                            </td>
                            <td>
                              <p class="itemtext digits">
                                {{ item.unit_price }}
                              </p>
                            </td>
                            <td>
                              <p class="itemtext digits">
                                {{ item.product_quantity }}
                              </p>
                            </td>

                            <td>
                              <p class="itemtext digits">
                                {{ item.recourd_total }}
                              </p>
                            </td>
                          </tr>

                          <tr>
                            <td></td>
                            <td></td>
                            <td class="Rate">
                              <h6 class="mb-0 p-2">
                                <b>{{ $t("Total") }}</b>
                              </h6>
                            </td>
                            <td class="payment digits">
                              <h6 class="mb-0 p-2">
                                <b>{{ invoice.invoice_total }}</b>
                              </h6>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- End InvoiceBot-->
                </div>
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
      invoice: [],
      isLoading: false,
    };
  },

  beforeMount() {
    if (this.$route.params.invoiceId) {
      axios
        .get(`getInvoiceById/${this.$route.params.invoiceId}`)
        .then((res) => {
          this.invoice = res.data.invoice;
          this.isLoading = true;
        })
        .catch((err) => {});
    }
  },
  methods: {},
};
</script>
