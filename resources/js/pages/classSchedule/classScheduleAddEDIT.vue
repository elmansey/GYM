<template>
    <div v-if="isLoading">
        <Breadcrumbs
            main="dashboard"
            :title="edit ? 'edit class' : 'add class'"
        />
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="select2-drpdwn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <form @submit.prevent="handelData" id="form">
                                    <div class="row">
                                        <div
                                            class="mb-2 col-md-6 col-lg-6 col-sm-12"
                                        >
                                            <div class="col-form-label">
                                                class Name
                                            </div>

                                            <input
                                                name="className"
                                                v-model="data.className"
                                                :class="[
                                                    'form-control',
                                                    error.className
                                                        ? 'is-invalid'
                                                        : ''
                                                ]"
                                            />
                                            <small
                                                style="color: red"
                                                v-if="error.className"
                                                >{{ error.className[0] }}</small
                                            >
                                        </div>

                                        <div
                                            class="mb-2 col-md-6 col-lg-6 col-sm-12"
                                        >
                                            <div style="float: right ">
                                                <label>select all days</label>
                                                <input
                                                    type="checkbox"
                                                    @change="check($event)"
                                                />
                                            </div>
                                            <div class="col-form-label">
                                                select day
                                            </div>

                                            <multiselect
                                                :disabled="selectAllDay"
                                                v-model="data.days"
                                                tag-placeholder="Add this as new tag"
                                                placeholder="Search or add a tag"
                                                :class="[
                                                    error.days ? 'is-invalid' : '']"
                                                label="name"
                                                track-by="id"
                                                @search-change="asyncFind"
                                                :options="options"
                                                :multiple="true"
                                                :taggable="true"
                                                @tag="addTag"
                                            >
                                            </multiselect>
                                            <small
                                                style="color: red"
                                                v-if="error.days"
                                                >{{ error.days[0] }}</small
                                            >
                                        </div>

                                        <div
                                            class="mb-2 col-md-6 col-lg-6 col-sm-12"
                                        >
                                            <div class="col-form-label">
                                                captain Name
                                            </div>

                                            <select
                                                name="coachName"
                                                v-model="data.captainName"
                                                :class="[
                                                    'form-control',
                                                    error.captainName
                                                        ? 'is-invalid'
                                                        : ''
                                                ]"
                                            >
                                                <option
                                                    v-for="(item,
                                                    index) in captain"
                                                    :key="index"
                                                    :value="id(item.id)"
                                                >
                                                    {{
                                                        item.firstName +
                                                            " " +
                                                            item.middleName +
                                                            " " +
                                                            item.lastName
                                                    }}
                                                </option>
                                            </select>
                                            <small
                                                style="color: red"
                                                v-if="error.captainName"
                                                >{{
                                                    error.captainName[0]
                                                }}</small
                                            >
                                        </div>

                                        <div
                                            class="mb-2 col-md-6 col-lg-6 col-sm-12"
                                        >
                                            <div class="col-form-label">
                                                starting Time
                                            </div>

                                            <input
                                                name="startingTime"
                                                pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$"
                                                type="time"
                                                v-model="data.startingTime"
                                                :class="[
                                                    'form-control',
                                                    error.startingTime
                                                        ? 'is-invalid'
                                                        : ''
                                                ]"
                                            />
                                            <small
                                                style="color: red"
                                                v-if="error.startingTime"
                                                >{{
                                                    error.startingTime[0]
                                                }}</small
                                            >
                                        </div>

                                        <div
                                            class="mb-2 col-md-6 col-lg-6 col-sm-12"
                                        >
                                            <div class="col-form-label">
                                                ending Time
                                            </div>

                                            <input
                                                name="endingTime"
                                                pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$"
                                                type="time"
                                                v-model="data.endingTime"
                                                :class="[
                                                    'form-control',
                                                    error.endingTime
                                                        ? 'is-invalid'
                                                        : ''
                                                ]"
                                            />
                                            <small
                                                style="color: red"
                                                v-if="error.endingTime"
                                                >{{
                                                    error.endingTime[0]
                                                }}</small
                                            >
                                        </div>

                                        <div
                                            class="mb-2 col-md-6 col-lg-6 col-sm-12"
                                        >
                                            <div class="col-form-label">
                                                training Location
                                            </div>

                                            <input
                                                name="trainingLocation"
                                                v-model="data.trainingLocation"
                                                :class="[
                                                    'form-control',
                                                    error.trainingLocation
                                                        ? 'is-invalid'
                                                        : ''
                                                ]"
                                            />
                                            <small
                                                style="color: red"
                                                v-if="error.trainingLocation"
                                                >{{
                                                    error.trainingLocation[0]
                                                }}</small
                                            >
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary mt-3"
                                        v-if="!edit"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-success mt-3"
                                        v-if="edit"
                                    >
                                        update
                                    </button>
                                </form>
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
        style="margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);"
    >
        <h6 class="sub-title mb-0 text-center"></h6>
        <div class="loader-box">
            <div class="loader-3"></div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Multiselect from "vue-multiselect";

export default {
    data() {
        return {
            data: {
                className: "",
                captainName: "",
                startingTime: "",
                endingTime: "",
                trainingLocation: "",
                days: ""
            },

            options: [
                { id: 1, name: "Saturday" },
                { id: 2, name: "Sunday" },
                { id: 3, name: "Monday" },
                { id: 4, name: "Tuesday" },
                { id: 5, name: "Wednesday" },
                { id: 6, name: "Thursday" },
                { id: 7, name: "Friday" }
            ],
            captain: [],
            error: "",
            edit: true,
            isLoading: false,
            selectAllDay: false
        };
    },

    components: {
        Multiselect
    },
    beforeCreate() {
        axios
            .get(`getAllCaptainToCreateClass`)
            .then(res => {
                this.captain = res.data.captain;
            })
            .catch(err => {
                console.error(err);
            });
    },

    beforeMount() {
        if (this.$route.params.classScheduleId) {
            this.edit = true;

            axios
                .get(`getClassById/${this.$route.params.classScheduleId}`)
                .then(res => {
                    // var startime = res.data.class.startingTime.split(' ');
                    this.edit = true;
                    this.data.className = res.data.class.className;
                    this.data.captainName = res.data.class.captainName;
                    this.data.startingTime = res.data.class.startingTime;
                    this.data.endingTime = res.data.class.endingTime;
                    this.data.trainingLocation =
                        res.data.class.trainingLocation;
                    this.data.days = res.data.class.days;
                    this.isLoading = true;
                })
                .catch(err => {
                    console.log(err);
                });
        } else {
            this.edit = false;
            this.isLoading = true;
        }
    },

    methods: {
        id(id) {
            return id;
        },

        handelData() {
            if (this.edit == false) {
                let formData = new FormData();
                formData.append("className", this.data.className);
                formData.append("captainName", this.data.captainName);
                formData.append("startingTime", this.data.startingTime);
                formData.append("endingTime", this.data.endingTime);
                formData.append("trainingLocation", this.data.trainingLocation);
                formData.append("days", this.data.days);

                axios
                    .post("addClass", formData)
                    .then(res => {
                        if (res.data.success == false) {
                            this.error = res.data.message;
                        }
                        if (res.data.success) {
                            Toast.fire({
                                icon: "success",
                                title: "class adedd successfully"
                            });
                            this.$router.push({ name: "classList" });
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }

            if (this.edit) {
                let formData = new FormData();
                formData.append("className", this.data.className);
                formData.append("captainName", this.data.captainName);
                formData.append("startingTime", this.data.startingTime);
                formData.append("endingTime", this.data.endingTime);
                formData.append("trainingLocation", this.data.trainingLocation);
                formData.append("days", JSON.stringify(this.data.days));

                axios
                    .post(
                        `updateClass/${this.$route.params.classScheduleId}`,
                        formData
                    )
                    .then(res => {
                        if (res.data.success == false) {
                            this.error = res.data.message;
                        }
                        if (res.data.success) {
                            Toast.fire({
                                icon: "success",
                                title: "class updated successfully"
                            });
                            this.$router.push({ name: "classList" });
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        },
        check(event) {
            if (event.target.checked) {
                this.selectAllDay = true;
                this.data.days = this.options;
            } else {
                this.selectAllDay = false;
                this.data.days = "";
            }
        },

        asyncFind(query) {
            this.options = findService(query);
        },

        addTag(newTag) {
            const tag = {
                name: newTag,
                code:
                    newTag.substring(0, 2) +
                    Math.floor(Math.random() * 10000000)
            };
            this.taggingOptions.push(tag);
            this.taggingSelected.push(tag);
        }
    },

    watch: {
        $route(to, from) {
            if (to.name == "addClassSchedule") {
                this.isLoading = true;
                this.edit = false;
                this.data.className = "";
                this.data.captainName = "";
                this.data.startingTime = "";
                this.data.endingTime = "";
                this.data.trainingLocation = "";
                this.data.days = "";
            }
        }
    }
};
</script>
<style></style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
