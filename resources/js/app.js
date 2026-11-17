import flatpickr from "flatpickr";
import "./bootstrap";
import "flowbite";
import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import "@fortawesome/fontawesome-free/css/all.css";
import "simplebar/dist/simplebar.min.css";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();

const localeMeta = document.querySelector('meta[name="locale"]');
const locale = localeMeta ? localeMeta.getAttribute("content") : "en";

/** ---------------- CKEditor (SAFE) ---------------- */
class LaravelUploadAdapter {
    constructor(loader) { this.loader = loader; }
    upload() {
        return this.loader.file.then((file) => new Promise((resolve, reject) => {
            let formData = new FormData();
            formData.append("upload", file);
            axios.post(imageUploadRoute, formData, { headers: { "Content-Type": "multipart/form-data" } })
                .then((response) => resolve({ default: response.data.url }))
                .catch((error) => reject(error?.response?.data?.errors?.upload));
        }));
    }
}
function CustomUploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => new LaravelUploadAdapter(loader);
}
const ckeditorEl = document.querySelector("#ckeditor");
if (ckeditorEl) {
    ClassicEditor.create(ckeditorEl, { language: locale, extraPlugins: [CustomUploadAdapterPlugin] })
        .then((editor) => console.log("Editor was initialized", editor))
        .catch((error) => console.error(error));
}

/** ---------------- Search Icon Focus ---------------- */
const searchInputAny = document.querySelectorAll(".search-input");
const searchIconsAny = document.querySelectorAll(".search-icon");
if (searchInputAny.length && searchIconsAny.length) {
    searchInputAny.forEach(function (searchInput, index) {
        searchInput.addEventListener("focus", () => searchIconsAny[index]?.classList.add("rotate-icon"));
        searchInput.addEventListener("blur", () => searchIconsAny[index]?.classList.remove("rotate-icon"));
    });
}

/** ---------------- Full Screen Api (SAFE) ---------------- */
let myDocument = document.documentElement;
let fullscreenbtn = document.getElementById("fullscreenbtn");
let fullscreenicon = document.getElementById("fullscreenicon");
if (fullscreenbtn && fullscreenicon) {
    fullscreenbtn.onclick = function () {
        if (fullscreenbtn.ariaLabel == "Open") {
            if (myDocument.requestFullscreen) myDocument.requestFullscreen();
            fullscreenbtn.ariaLabel = "Close";
            fullscreenicon.setAttribute("class", "fa-solid fa-square-xmark text-lg");
            localStorage.setItem("fullscreen", "true");
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
            fullscreenbtn.ariaLabel = "Open";
            fullscreenicon.setAttribute("class", "fas fa-expand");
            localStorage.removeItem("fullscreen");
        }
    };
}

/** ---------------- CheckAll For Checkbox in tables ---------------- */
const headerCheckbox = document.getElementById("checkboxAll");
const bodyCheckboxes = document.querySelectorAll('#multiselect-table tbody input[type="checkbox"]');
if (headerCheckbox && bodyCheckboxes.length) {
    headerCheckbox.addEventListener("click", () => {
        bodyCheckboxes.forEach((checkbox) => { checkbox.checked = headerCheckbox.checked; });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const tableCheckboxes = document.querySelectorAll('#multiselect-table input[type="checkbox"]');
    if (tableCheckboxes.length) {
        tableCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                let isChecked = false;
                tableCheckboxes.forEach(function (cb) { if (cb.checked) isChecked = true; });
                let deleteAllButton = document.getElementById("deleteAllbtn");
                if (deleteAllButton) deleteAllButton.hidden = !isChecked;
            });
        });
    }
});

let deleteAllbtn = document.getElementById("delete-selected-btn");
let selected_ids = document.getElementById("selected_ids");
if (deleteAllbtn && selected_ids) {
    deleteAllbtn.onclick = function () {
        let selected = new Array();
        document.querySelectorAll('#multiselect-table input[type="checkbox"]:checked').forEach(function (checkbox) {
            selected.push(checkbox.value);
        });
        if (selected.length > 0) selected_ids.value = selected;
    };
}
