import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

function normalizeHex(hex) {
    hex = hex.replace("#", "");
    return hex.length === 3
        ? "#" + hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2]
        : "#" + hex;
}

window.normalizeHex = normalizeHex;
