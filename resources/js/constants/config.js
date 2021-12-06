export const defaultDirection = "ltr";
export const getDirection = () => {
    let direction = defaultDirection;
    if (localStorage.getItem("direction")) {
        const localValue = localStorage.getItem("direction");
        if (localValue === "rtl" || localValue === "ltr") {
            direction = localValue;
        }
    }
    return {
        direction,
        isRtl: direction === "rtl"
    };
};

export const setDirection = localValue => {
    let direction = "ltr";
    if (localValue === "rtl" || localValue === "ltr") {
        direction = localValue;
    }
    localStorage.setItem("direction", direction);
};

export const defaultLocale = "en";

export const localeOptions = [
    { id: "en", name: "English",  direction: "ltr" },
    { id: "ar", name: "Arabic", direction: "rtl" }
];
