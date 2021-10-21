<template>
    <div v-if="isLoading">
        <Breadcrumbs main="Dashboard" title="Details" />
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ data.role }}</h5>
                        </div>
                        <div class="card-body">
                            <b-list-group
                                tag="ul"
                                v-for="(item, index) in data.permission"
                                :key="index"
                            >
                                <b-list-group-item tag="li"
                                    ><span
                                        class="badge badge-primary"
                                        style="font-size: 14px;"
                                        >{{ item.name }}</span
                                    ></b-list-group-item
                                >
                            </b-list-group>
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
        style="margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);"
    >
        <h6 class="sub-title mb-0 text-center"></h6>
        <div class="loader-box">
            <div class="loader-3"></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tab_panel: "home",
            data: "",
            isLoading: false
        };
    },
    created() {
        this.data = this.$store.getters.roleDataToShow;
        this.isLoading = true;
    },
    methods: {
        show_panel: function(tab_pane) {
            this.tab_panel = tab_pane;
        }
    }
};
</script>
