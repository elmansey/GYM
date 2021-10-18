


<template>

<!--    <div v-if="isLoadig">-->

<!--        <Breadcrumbs main="Dashboard" title="member list" />-->
<!--        <div class="container-fluid">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <div class="card">-->
<!--                        <div class="card-body">-->
<!--                            <div class="datatable-vue m-0">-->


<!--                                <div class="table-responsive vue-smart">-->
<!--&lt;!&ndash;                                    <v-table&ndash;&gt;-->
<!--&lt;!&ndash;                                        :data="members"&ndash;&gt;-->
<!--&lt;!&ndash;                                        class="table"&ndash;&gt;-->
<!--&lt;!&ndash;                                        :currentPage.sync="filter.currentPage"&ndash;&gt;-->
<!--&lt;!&ndash;                                        :pageSize="5"&ndash;&gt;-->
<!--&lt;!&ndash;                                        @totalPagesChanged="filter.totalPages = $event"&ndash;&gt;-->

<!--&lt;!&ndash;                                    >&ndash;&gt;-->
<!--&lt;!&ndash;                                        <thead slot="head">&ndash;&gt;-->

<!--&lt;!&ndash;                                        <th></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        <th sortKey="name"></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        <th sortKey="name"></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        <th sortKey="name" ></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        <th sortKey="options"></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        <th sortKey="options"></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        <th sortKey="options"></th>&ndash;&gt;-->
<!--&lt;!&ndash;                                        </thead>&ndash;&gt;-->

<!--&lt;!&ndash;                                        <tbody slot="body" slot-scope="{ displayData }">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <tr v-for="(row, index) in displayData" :key="index">&ndash;&gt;-->
<!--&lt;!&ndash;                                            <td></td>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <td></td>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <td></td>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <td></td>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <td></td>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <td></td>&ndash;&gt;-->

<!--&lt;!&ndash;                                            <td>&ndash;&gt;-->
<!--&lt;!&ndash;                                                <div>&ndash;&gt;-->
<!--&lt;!&ndash;                                                    <b-button-group class="btn-container ">&ndash;&gt;-->


<!--&lt;!&ndash;                                                        <router-link&ndash;&gt;-->
<!--&lt;!&ndash;                                                            squared&ndash;&gt;-->
<!--&lt;!&ndash;                                                            variant="outline-warning"&ndash;&gt;-->
<!--&lt;!&ndash;                                                            class="btn-sm btn-child"&ndash;&gt;-->
<!--&lt;!&ndash;                                                            to=""&ndash;&gt;-->
<!--&lt;!&ndash;                                                            v-if="can('')"&ndash;&gt;-->
<!--&lt;!&ndash;                                                        >&ndash;&gt;-->
<!--&lt;!&ndash;                                                            Edit&ndash;&gt;-->
<!--&lt;!&ndash;                                                        </router-link>&ndash;&gt;-->


<!--&lt;!&ndash;                                                        <b-button&ndash;&gt;-->
<!--&lt;!&ndash;                                                            squared&ndash;&gt;-->
<!--&lt;!&ndash;                                                            variant="outline-danger"&ndash;&gt;-->

<!--&lt;!&ndash;                                                            class="btn-sm btn-child"&ndash;&gt;-->
<!--&lt;!&ndash;                                                            v-if="can('')"&ndash;&gt;-->
<!--&lt;!&ndash;                                                        >&ndash;&gt;-->

<!--&lt;!&ndash;                                                            Delete&ndash;&gt;-->
<!--&lt;!&ndash;                                                        </b-button>&ndash;&gt;-->





<!--&lt;!&ndash;                                                    </b-button-group>&ndash;&gt;-->
<!--&lt;!&ndash;                                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                                            </td>&ndash;&gt;-->
<!--&lt;!&ndash;                                        </tr>&ndash;&gt;-->
<!--&lt;!&ndash;                                        </tbody>&ndash;&gt;-->
<!--&lt;!&ndash;                                    </v-table>&ndash;&gt;-->
<!--                                </div>-->

<!--                                <div >-->
<!--                                    <smart-pagination-->

<!--                                        :currentPage.sync="filter.currentPage"-->
<!--                                        :totalPages="filter.totalPages"-->
<!--                                    />-->
<!--                                </div>-->


<!--                            </div>-->




<!--                            <b-modal id="bv-modal-example" hide-footer>-->
<!--                                <template #modal-title>-->
<!--                                    Delete Team member-->
<!--                                </template>-->
<!--                                <div class="d-block text-center">-->
<!--                                    <h5>are you sure to delete this Admin</h5>-->
<!--                                </div>-->
<!--                                <b-button class="mt-3"  v-b-modal.modal-sm variant="default" @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>-->
<!--                                <b-button class="mt-3"  v-b-modal.modal-sm variant="danger"  @click.prevent="">delete</b-button>-->
<!--                            </b-modal>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->



<!--    </div>-->

    <div v-else class="col-md-3" style="margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);">
        <h6 class="sub-title mb-0 text-center"></h6>
        <div class="loader-box" >
            <div class="loader-3"></div>
        </div>
    </div>



</template>

<script>
import axios from "axios";


export default {
    data() {
        return {
            members: [],

        };
    },
    beforeMount() {


    },
    created() {



    },
    methods: {




    }
}

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


