
<template>

    <div v-if="isLoadig">

        <Breadcrumbs main="Dashboard" title="attendance table" />
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">

                           <div class="row">

                            <div class="col-md-3" style="margin-bottom: 40px;">
                                <label>attendance from</label>
                                <input class="form-control" type="date"  @change="filters"  v-model="showFilter.from"  />
                            </div>

                            <div class="col-md-3" style="margin-bottom: 40px;">
                                <label>attendance to</label>
                                <input class="form-control" type="date"  @change="filters"  v-model="showFilter.to" />
                            </div>

                            <div class="col-md-3" style="margin-bottom: 40px;">
                                <label>RF code</label>
                                <input class="form-control" type="text"  placeholder="RF code"    v-model="RF_Filter"  />
                            </div>

                            <div class="col-md-3" style="margin-bottom: 40px;">
                                <label>name</label>
                                <input class="form-control" type="text" placeholder="name"   v-model="nameFilter"  />
                            </div>

                           </div>

                                 <div class="row">
                                        <div  style="display:inline-block;margin-bottom: 10px;margin-left:50px">
                                            <div>
                                                <b-button-group style="height:auto;">
                                                    <b-button size="sm"  variant="dark" style="padding: 2px 7px;">
                                                        <div>
                                                            <div
                                                                style="float: left;margin-top: 8px;"
                                                                id="checkInput"
                                                            >
                                                                <input

                                                                    type="checkbox"
                                                                    @click="selectAll"
                                                                     v-model="selectedAll"



                                                                />
                                                            </div>


                                                            <div style="float: right;">
                                                                <b-dropdown

                                                                    variant="dark"
                                                                    size="sm"
                                                                    right
                                                                    id="dropdownMenuButton"
                                                                     :disabled="emptyCheckData"
                                                                >
                                                                    <b-dropdown-item
                                                                    @click="DeleteAttendanceSelectedModal"
                                                                    >
                                                                        <feather
                                                                            type="trash"
                                                                            style="width: 20px;"
                                                                        ></feather>
                                                                        delete
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

                                     <div style="margin-left: 4px;">
                                        <b-dropdown size="small" text="Action"  variant="dark" style="margin-bottom: 14px;">
                                                <b-dropdown-item><i style="font-size:15px" class="fa fa-file-excel-o" @click.prevent="AttendanceExport"></i> export excel</b-dropdown-item>
                                                <b-dropdown-item><i style="font-size:15px" class="fa fa-print" @click.prevent="printNow"></i> Print </b-dropdown-item>

                                        </b-dropdown>
                                     </div>




                                    <b-col md="6" style="display:inline-block">
                                        <b-form-group label-cols="2" label="Per page" class="mb-0 datatable-select">
                                            <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                                        </b-form-group>
                                    </b-col>

                                 </div>
                            <div class="datatable-vue m-0">


                                <div class="table-responsive vue-smart">
                                    <b-table
                                        id="tablePrint"
                                        show-empty
                                        stacked="md"
                                        :items="nFilter"
                                        :fields="tablefields"
                                        :current-page="currentPage"
                                        :per-page="perPage"


                                    >
                                       <template #cell(ID)="data">
                                            {{ data.index + 1 }}
                                        </template>

                                       <template #cell(status)="data">
                                            <feather type="check-square"></feather>
                                        </template>

                                       <template #cell(check)="data">
                                            <input  type="checkbox" :value="data.item.id" v-model="selected" />
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




                             <b-modal id="bv-modal-selected" hide-footer>
                                <template #modal-title>
                                    Delete selected attendance
                                </template>
                                <div class="d-block text-center">
                                    <h5>
                                        are you sure to delete this selected
                                        attendance
                                    </h5>
                                </div>
                                <b-button
                                    class="mt-3"
                                    v-b-modal.modal-sm
                                    variant="default"
                                    @click="$bvModal.hide('bv-modal-selected')"
                                    >Cancel</b-button
                                >
                                <b-button
                                    class="mt-3"
                                    v-b-modal.modal-sm
                                    variant="danger"
                                    @click="deleteSelectedAttendance"
                                    >delete</b-button
                                >
                            </b-modal>



                        </div>

                    </div>
                </div>
            </div>
        </div>



    </div>

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

            tablefields: [
                'check',
                'ID',
                { key: 'userRelation.name', label: 'name', sortable: false, },
                { key: 'userRelation.RF_code', label: 'RF code', sortable: false, },
                { key: 'date', label: 'attendance', sortable: false, },
                { key: 'come_time', label: 'come time', sortable: false, },
                { key: 'leave_time', label: 'leave time', sortable: false, },
                 'status'
            ],
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [5, 10, 15],
            attendance:[],
            showFilter:{
                from:'',
                to:''
            },
            RF_Filter:'',
            nameFilter:'',
            isLoadig:false,
            selected:[],
            selectedAll:false,
            emptyCheckData:true

        };
    },
    beforeMount() {
        axios.get('attendance')
        .then(res => {
            this.attendance = Object.values(res.data.attendance)
               this.totalRows = this.attendance.length
               this.isLoadig = true

        })
        .catch(err => {
            console.error(err);
        })
    },
    mounted() {



    },

    computed:{



        nFilter(){

            if(this.nameFilter.length > 0){
                    return  this.attendance.filter(item => {
                                                    //match
                    return item.userRelation.name.includes((this.nameFilter ).toLowerCase())
                })

            }else {

                return  this.attendance.filter(item => {
                                                //match
                    return item.userRelation.RF_code.includes((this.RF_Filter ).toLowerCase())
                })
            }







        },


    },

    methods: {

        DeleteAttendanceSelectedModal(){

            this.$bvModal.show("bv-modal-selected");

        },


         deleteSelectedAttendance() {
            axios
                .post("attendanceSelectedToDelete", this.selected)
                .then(res => {
                    if (res.data.success) {

                            axios.get('attendance')
                            .then(res => {
                                this.attendance = Object.values(res.data.attendance)
                                this.totalRows = this.attendance.length


                                 this.$bvModal.hide("bv-modal-selected");
                                this.selectedAll = false;
                                this.selected = [];
                                this.isLoadig = true;
                                Toast.fire({
                                    icon: "success",
                                    title: "selected item  deleted successfully"
                                });

                            })
                            .catch(err => {
                                console.error(err);
                            })



                    }
                })
                .catch(err => {
                    console.error(err);
                });
        },

         selectAll(event) {
            if (event.target.checked == false) {
                this.selected = [];
                 this.emptyCheckData = true;
            } else {
                this.attendance.forEach(element => {
                    this.selected.push(element.id);
                });
                 this.emptyCheckData = false;
            }
        },


        printNow(){

            printJS('tablePrint', 'html')
        },



        filters(){

            let formData = new FormData();
            formData.append("from",this.showFilter.from)
            formData.append("to",this.showFilter.to)

            axios.post('attendanceFilter',formData)
            .then(res => {

                if(res.data.success){
                    this.attendance = Object.values(res.data.attendance)
                    this.totalRows = this.attendance.length
                }


            })
            .catch(err => {
                console.error(err);
            })
        }
    },


      watch: {
        selected: function(selected) {

            this.selectedAll = selected.length === Object.values(this.attendance).length;
            this.emptyCheckData = selected.length < 1;
            this.selectedAll = selected.length === Object.values(this.attendance).length;
        }
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
