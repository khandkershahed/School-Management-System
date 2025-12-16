// // sidenav transition-burger

// var sidenav = document.querySelector("aside");
// var sidenav_trigger = document.querySelector("[sidenav-trigger]");
// var sidenav_close_button = document.querySelector("[sidenav-close]");
// var burger = sidenav_trigger.firstElementChild;
// var top_bread = burger.firstElementChild;
// var bottom_bread = burger.lastElementChild;

// sidenav_trigger.addEventListener("click", function () {
//   if (page == "virtual-reality") {
//     sidenav.classList.toggle("xl:left-[18%]");
//   }
//   sidenav_close_button.classList.toggle("hidden");
//   sidenav.classList.toggle("translate-x-0");
//   sidenav.classList.toggle("shadow-soft-xl");
//   if (page == "rtl") {
//     top_bread.classList.toggle("-translate-x-[5px]");
//     bottom_bread.classList.toggle("-translate-x-[5px]");
//   } else {
//     top_bread.classList.toggle("translate-x-[5px]");
//     bottom_bread.classList.toggle("translate-x-[5px]");
//   }
// });
// sidenav_close_button.addEventListener("click", function () {
//   sidenav_trigger.click();
// });

// window.addEventListener("click", function (e) {
//   if (!sidenav.contains(e.target) && !sidenav_trigger.contains(e.target)) {
//     if (sidenav.classList.contains("translate-x-0")) {
//       sidenav_trigger.click();
//     }
//   }
// });

// resources/js/sidenav-burger.js

function initSidenavBurger() {
    var sidenav = document.querySelector("aside");
    var sidenav_trigger = document.querySelector("[sidenav-trigger]");
    var sidenav_close_button = document.querySelector("[sidenav-close]");

    if (!sidenav || !sidenav_trigger || !sidenav_close_button) return;

    var burger = sidenav_trigger.firstElementChild;
    var top_bread = burger ? burger.firstElementChild : null;
    var bottom_bread = burger ? burger.lastElementChild : null;

    // prevent double-binding if Vite HMR or partial reload
    if (sidenav_trigger.dataset.bound === "1") return;
    sidenav_trigger.dataset.bound = "1";

    sidenav_trigger.addEventListener("click", function () {
        if (typeof page !== "undefined" && page == "virtual-reality") {
            sidenav.classList.toggle("xl:left-[18%]");
        }

        sidenav_close_button.classList.toggle("hidden");
        sidenav.classList.toggle("translate-x-0");
        sidenav.classList.toggle("shadow-soft-xl");

        if (top_bread && bottom_bread) {
            if (typeof page !== "undefined" && page == "rtl") {
                top_bread.classList.toggle("-translate-x-[5px]");
                bottom_bread.classList.toggle("-translate-x-[5px]");
            } else {
                top_bread.classList.toggle("translate-x-[5px]");
                bottom_bread.classList.toggle("translate-x-[5px]");
            }
        }
    });

    sidenav_close_button.addEventListener("click", function () {
        sidenav_trigger.click();
    });

    window.addEventListener("click", function (e) {
        if (!sidenav.contains(e.target) && !sidenav_trigger.contains(e.target)) {
            if (sidenav.classList.contains("translate-x-0")) {
                sidenav_trigger.click();
            }
        }
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSidenavBurger);
} else {
    initSidenavBurger();
}

