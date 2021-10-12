<template>
    <div>
        <Breadcrumbs main="Dashboard" title="permissions" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="datatable-vue m-0">

                                <button id="default-outline-primary-sm" type="button" class="btn btn-pull btn-outline-primary btn-outline-primary btn-sm mb-3">

                                    <router-link :to="{name : 'addRole'}">add Role</router-link>

                                </button>

                                <div class="table-responsive vue-smart">
                                    <v-table
                                        :data="roles"
                                        class="table"
                                        :currentPage.sync="filter.currentPage"
                                        :pageSize="5"
                                        @totalPagesChanged="filter.totalPages = $event"

                                    >
                                        <thead slot="head">

                                        <th sortKey="id">ID</th>
                                        <th sortKey="name">name</th>
                                        <th sortKey="options">options</th>
                                        </thead>

                                        <tbody slot="body" slot-scope="{ displayData }">
                                        <tr v-for="(row, index) in displayData" :key="index">
                                            <td>{{ row.id }}</td>
                                            <td>{{ row.name }}</td>
                                            <td>
                                                <div>
                                                    <b-button-group class="btn-container ">

                                                        <router-link
                                                            class="custom-color"
                                                            :to="{name: '',params: { id: row.id } }" >
                                                            <b-button
                                                                squared
                                                                variant="outline-warning"
                                                                class="btn-sm btn-child"
                                                            >
                                                                <i class="icon-pencil-alt"></i>
                                                            </b-button>
                                                        </router-link>

                                                        <b-button
                                                            squared
                                                            variant="outline-danger"
                                                            @click=""
                                                            class="btn-sm btn-child"
                                                        ><i class="fa fa-trash"></i
                                                        ></b-button>





                                                    </b-button-group>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </v-table>
                                </div>

                                <div >
                                    <smart-pagination

                                        :currentPage.sync="filter.currentPage"
                                        :totalPages="filter.totalPages"
                                    />
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";


export default {
    data() {
        return {
            roles: [],
            filter: {
                currentPage: 1,
                totalPages: 0,
            },

        };
    },
    beforeMount() {
        axios.get("roles")
            .then((res) => {
                this.roles = res.data.roles;
            })
            .catch((err) => {
                console.log(err);
            });
    },
    methods: {

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
