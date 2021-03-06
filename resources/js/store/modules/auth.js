import axios from "axios";
import router from "@/router/index";

//to save
const state = {
    isAuth: false,
    user: [],
    errors: "",
    token: localStorage.getItem("token"),
    authUserRole: [],
    authCustomPermission: []
};

// to show item saved in state
const getters = {
    authentication(state) {
        return state.isAuth;
    },

    AllError(state) {
        return state.errors;
    },

    USER(state) {
        return state.user;
    },

    AUTH_TOKEN(state) {
        return state.token;
    },

    authUserRole(state) {
        return state.authUserRole;
    },

    authCustomPermission(state) {
        return state.authCustomPermission;
    }
};

// to chang value in state and do every thing
const mutations = {
    setAuthentecation(state, status) {
        state.isAuth = status;
    },

    loginSuccess(state, token, user) {
        localStorage.setItem("token", token);
        state.token = token;
        state.isAuth = true;
        state.errors = "";
        state.user = user;
        router.push({
            name: "main"
        });
    },

    setToken(state, token) {
        state.token = token;
        state.isAuth = true;
        localStorage.setItem("token", token);
    },

    SET_USER(state, user) {
        state.user = user;
        window.Echo.connector.pusher.config.auth.headers[
            "Authorization"
        ] = `Bearer ${state.token}`;
        window.Echo.connector.options.auth.headers[
            "Authorization"
        ] = `Bearer ${state.token}`;
    },

    loginFailed(state, error) {
        state.token = "";
        state.isAuth = false;
        state.errors = error;
    },

    logOut(state) {
        localStorage.removeItem("token");
        state.isAuth = false;
        state.user = [];
        state.token = "";
        state.authUserRole = [];
        state.authCustomPermission = [];
        router.push({
            name: "login"
        });
    },

    USER_INFO_SUCCESS(state, data) {
        state.isAuth = true;
        state.user = data;
        state.errors = "";
    },

    USER_INFO_FAILD(state) {
        localStorage.removeItem("token");
        state.isAuth = false;
        state.token = null;
        state.user = null;
        state.authUserRole = [];
        state.authCustomPermission = [];
    },

    authUserRole(state, payload) {
        state.authUserRole = payload;
    },

    authCustomPermission(state, payload) {
        state.authCustomPermission.push(payload);
    }
};

// do conection with api and call mutations
const actions = {
    SET_USER({ commit }, payload) {
        commit("SET_USER", payload);
    },

    loginUser({ commit }, payload) {
        axios
            .post("login", {
                email: payload.email,
                password: payload.password
            })
            .then(res => {
                if (res.data.status == 400) {
                    commit("loginFailed", res.data.message);
                } else if (res.data.status == 401) {
                    Toast.fire({
                        icon: "error",
                        title: "!! Wrong In Email Or Password"
                    });
                } else {
                    commit("SET_USER", res.data.data.user);
                    commit(
                        "loginSuccess",
                        res.data.data.access_token,
                        res.data.data.user
                    );

                    axios
                        .get("info")
                        .then(res => {
                            commit("USER_INFO_SUCCESS", res.data.data);
                            commit("authUserRole", res.data.roleAndPermission);

                            res.data.customPermission.map((v, k) => {
                                commit(
                                    "authCustomPermission",
                                    v.permission_relassion
                                );
                            });
                        })
                        .catch(err => {
                            commit("USER_INFO_FAILD");
                        });
                }
            })
            .catch(err => {
                console.log(err.message);
            });
    },

    async userLogout({ commit }) {
        await axios
            .post("logout")
            .then(res => {
                commit("authUserRole", []);
                commit("logOut");
            })
            .catch(err => {
                console.log(err.message);
            });
    },

    async userInfo({ commit }) {
        try {
            const res = await axios.get("info");

            await commit("USER_INFO_SUCCESS", res.data.data);

            commit("authUserRole", res.data.roleAndPermission);
            res.data.customPermission.map((v, k) => {
                commit("authCustomPermission", v.permission_relassion);
            });
        } catch (err) {
            commit("USER_INFO_FAILD");
            commit("authUserRole", []);
        }
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
