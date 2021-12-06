import { getDirection } from "../../constants/config";
import Layout from "../../data/layout";

const state = {
    layout: Layout,
    sidebarType: localStorage.getItem("SidebarType") || "default"
};

// getters
const getters = {};

// mutations
const mutations = {
    set: state => {
        document.body.classList.add(state.layout.color.mix_layout);

        const direction = getDirection();
        if (direction.isRtl) {
            document.body.classList.add("rtl");
            document.dir = "rtl";
            document.body.classList.remove("ltr");
            document.body.setAttribute("main-theme-layout", "rtl");
            console.log(direction);
        } else {
            document.body.classList.add("ltr");
            document.dir = "ltr";
            document.body.classList.remove("rtl");
            console.log("ltr");
            document.body.setAttribute("main-theme-layout", "ltr");
        }

        document.getElementsByTagName("html")[0];
        var primaryColor =
            localStorage.getItem("primary_color") ||
            state.layout.color.primary_color;
        var secondaryColor =
            localStorage.getItem("secondary_color") ||
            state.layout.color.secondary_color;
        var layoutVersion =
            localStorage.getItem("layoutVersion") ||
            state.layout.color.layout_version;
        if (primaryColor || secondaryColor) {
            addStyle(primaryColor, secondaryColor);
            if (layoutVersion) {
                document.body.classList.add(layoutVersion);
            }
        }
    },

    setLayout: (state, payload) => {
        document.body.classList.remove("dark-only");
        document.body.classList.remove("light-only");
        document.body.classList.add(payload);

        let currentMode = "";
        if (document.body.classList.contains("dark-only")) {
            currentMode = "dark-only";
            localStorage.setItem("mode", currentMode);
        } else {
            currentMode = "light-only";
            localStorage.setItem("mode", currentMode);
        }
    },
    setColorScheme: (state, payload) => {
        setColor(state, payload);
        state.primaryColor = payload.primary;
        state.secondaryColor = payload.secondary;
        state.layout.color.layout_version = "light";
        localStorage.setItem(
            "layoutVersion",
            state.layout.color.layout_version
        );
    },
    setColorDarkScheme: (state, payload) => {
        setColor(state, payload);
        state.layout.color.layout_version = "dark-only";
        localStorage.setItem(
            "layoutVersion",
            state.layout.color.layout_version
        );
    },
    setCustomizeSidebarType: (state, payload) => {
        localStorage.setItem("SidebarType", payload);
        window.location.reload();
    }
};

// actions
const actions = {
    set: context => {
        context.commit("set");
    },

    setLayout: (context, payload) => {
        context.commit("setLayout", payload);
    },
    setColorScheme: (context, payload) => {
        context.commit("setColorScheme", payload);
    },
    setColorDarkScheme: (context, payload) => {
        context.commit("setColorDarkScheme", payload);
    },
    setCustomizeSidebarType: (context, payload) => {
        context.commit("setCustomizeSidebarType", payload);
    }
};

function addStyle(primary, secondary) {
    document.documentElement.style.setProperty("--theme-deafult", primary);
    document.documentElement.style.setProperty("--theme-secondary", secondary);
}

function setColor(state, color) {
    addStyle(color.primary, color.secondary);
    console.log(color.primary, color.secondary);
    localStorage.setItem("primary_color", color.primary);
    localStorage.setItem("secondary_color", color.secondary);
    window.location.reload();
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
