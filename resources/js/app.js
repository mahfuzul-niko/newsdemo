import "./bootstrap";
import Alpine from "alpinejs";
import "../scss/app.scss"; // Import your custom SCSS
import "toastr/build/toastr.min.js"; // Import Bootstrap JS bundle
import "bootstrap/dist/js/bootstrap.bundle.min.js"; // Import Bootstrap JS bundle

import Swiper from "swiper/bundle";

import toastr from "toastr/build/toastr.min.js";
import {
    error
} from "toastr";
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-center",
    "preventDuplicates": true,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


const toast = (type, messaage) => {


    return;
    switch (type) {
        case 'error':
            toastr.error(messaage)
            break;
        default:
            toastr.success(messaage)
    }
}

window.toast = toast;
window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const swiper = new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});

console.log('asdasd');
const lazyLoad = () => {
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');

    const imageObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                const lazyImage = entry.target;
                lazyImage.src = lazyImage.dataset.src;

                lazyImage.onload = function () {
                    lazyImage.removeAttribute("data-src");
                    lazyImage.removeAttribute("loading");
                };
                observer.unobserve(lazyImage);
            }
        });
    });

    lazyImages.forEach(function (lazyImage) {
        imageObserver.observe(lazyImage);
    });
}

window.lazyLoad = lazyLoad;
document.addEventListener("DOMContentLoaded", function () {
    window.lazyLoad()
});
