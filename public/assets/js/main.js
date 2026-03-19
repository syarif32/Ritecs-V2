(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($("#spinner").length > 0) {
                $("#spinner").removeClass("show");
            }
        }, 1);
    };
    spinner(0);

    // Initiate the wowjs
    new WOW().init();

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $(".nav-bar").addClass("sticky-top shadow-sm").css("top", "0px");
        } else {
            $(".nav-bar")
                .removeClass("sticky-top shadow-sm")
                .css("top", "-100px");
        }
    });

    // Header carousel
    $(".header-carousel").owlCarousel({
        animateOut: "fadeOut",
        items: 1,
        margin: 0,
        stagePadding: 0,
        autoplay: true,
        smartSpeed: 500,
        dots: true,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-right"></i>',
            '<i class="bi bi-arrow-left"></i>',
        ],
    });

    // testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: false,
        dots: false,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="fa fa-arrow-right"></i>',
            '<i class="fa fa-arrow-left"></i>',
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 2,
            },
        },
    });

    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 5,
        time: 2000,
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".back-to-top").fadeIn("slow");
        } else {
            $(".back-to-top").fadeOut("slow");
        }
    });
    $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1000, "easeInOutExpo");
        return false;
    });
})(jQuery);

// modal

// login

// const modalLoginEl = document.getElementById("modalLogin");

// modalLoginEl.addEventListener("click", function (event) {
//     if (event.target === modalLoginEl) {
//         const modalDialog = modalLoginEl.querySelector(".modal-dialog");

//         modalDialog.classList.add("modal-shake");

//         setTimeout(function () {
//             modalDialog.classList.remove("modal-shake");
//         }, 500);
//     }
// });
// Register
// document.addEventListener('DOMContentLoaded', function () {
//     const authContainer = document.querySelector('.auth-container');
//     const showRegisterLink = document.getElementById('showRegister');
//     const showLoginLink = document.getElementById('showLogin');

//     showRegisterLink.addEventListener('click', function (e) {
//         e.preventDefault();
//         authContainer.classList.add('is-flipped');
//     });

//     showLoginLink.addEventListener('click', function (e) {
//         e.preventDefault();
//         authContainer.classList.remove('is-flipped');
//     });
// });

// Auth Modal
document.addEventListener("DOMContentLoaded", function () {
    const authContainer = document.querySelector(".auth-container");
    const authFlipper = document.querySelector(".auth-flipper");
    const authModalEl = document.getElementById("authModal");
    const authModal = new bootstrap.Modal(authModalEl);

    const showRegisterLink = document.getElementById("showRegister");
    const showLoginLink = document.getElementById("showLogin");

    const openLoginBtn = document.getElementById("openLoginBtn");
    const openRegisterBtn = document.getElementById("openRegisterBtn");

    function adjustFlipperHeight() {
        setTimeout(() => {
            const frontPanel = document.querySelector(".auth-panel-front");
            const backPanel = document.querySelector(".auth-panel-back");

            const activePanel = authContainer.classList.contains("is-flipped")
                ? backPanel
                : frontPanel;

            if (authFlipper && activePanel) {
                authFlipper.style.height = activePanel.scrollHeight + "px";
            }
        }, 300);
    }

    authModalEl.addEventListener("shown.bs.modal", function () {
        adjustFlipperHeight();
    });

    if (showRegisterLink) {
        showRegisterLink.addEventListener("click", function (e) {
            e.preventDefault();
            authContainer.classList.add("is-flipped");
            adjustFlipperHeight();
        });
    }

    if (showLoginLink) {
        showLoginLink.addEventListener("click", function (e) {
            e.preventDefault();
            authContainer.classList.remove("is-flipped");
            adjustFlipperHeight();
        });
    }

    if (openLoginBtn) {
        openLoginBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (authContainer.classList.contains("is-flipped")) {
                authContainer.classList.remove("is-flipped");
            }
            authModal.show();
        });
    }

    if (openRegisterBtn) {
        openRegisterBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (!authContainer.classList.contains("is-flipped")) {
                authContainer.classList.add("is-flipped");
            }
            authModal.show();
        });
    }
});
// Lokasi
document.addEventListener("DOMContentLoaded", function () {
    const locationText = document.getElementById("location-text");
    function findLocationOnLoad() {
        if (navigator.geolocation) {
            locationText.textContent = "Mencari lokasi...";
            navigator.geolocation.getCurrentPosition(
                successCallback,
                errorCallback
            );
        } else {
            locationText.textContent =
                "Geolocation tidak didukung browser ini.";
        }
    }

    async function successCallback(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`
            );
            const data = await response.json();

            if (data && data.address) {
                const city =
                    data.address.city ||
                    data.address.town ||
                    data.address.village ||
                    "";
                const country = data.address.country || "";

                locationText.textContent = `${city}, ${country}`;
            } else {
                locationText.textContent = "Alamat tidak ditemukan.";
            }
        } catch (error) {
            console.error("Error saat fetch alamat:", error);
            locationText.textContent = "Gagal mengambil nama lokasi.";
        }
    }

    function errorCallback(error) {
        let message = "";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                message = "Semarang";
                break;
            case error.POSITION_UNAVAILABLE:
                message = "Informasi lokasi tidak tersedia.";
                break;
            case error.TIMEOUT:
                message = "Permintaan lokasi timeout.";
                break;
            default:
                message = "Terjadi kesalahan tidak diketahui.";
                break;
        }
        locationText.textContent = message;
    }

    findLocationOnLoad();
});
// pop up
document.addEventListener('DOMContentLoaded', function() {
    const popupContainer = document.getElementById('journal-floating-container');
    
    if (!popupContainer) {
        return; 
    }

    const closeBtn = document.getElementById('close-journal-fab');
    if (localStorage.getItem('journalFabClosed') !== 'true') {
        setTimeout(() => {
            popupContainer.classList.add('show');
        }, 2000); 
    }
    // closeBtn.addEventListener('click', function() {
    //     popupContainer.classList.remove('show');
    //     localStorage.setItem('journalFabClosed', 'true');
    // });
});
// document.addEventListener("DOMContentLoaded", function() {

//     const ojsModalElement = document.getElementById('ojsPopupModal');
//     if (ojsModalElement) {
//         const ojsModal = new bootstrap.Modal(ojsModalElement);
//         setTimeout(function() {
//             ojsModal.show();
//         }, 3000);
//     }

// });
// document.addEventListener("DOMContentLoaded", function () {
//     if (!sessionStorage.getItem("popupShown")) {
//         const ojsModalElement = document.getElementById("ojsPopupModal");
//         if (ojsModalElement) {
//             const ojsModal = new bootstrap.Modal(ojsModalElement);
//             setTimeout(function () {
//                 ojsModal.show();
//                 sessionStorage.setItem("popupShown", "true");
//             }, 3000);
//         }
//     }
// });
// auth cek

document.addEventListener("DOMContentLoaded", function () {
    console.log("");
    const loginRequiredMessage = document.body.dataset.loginRequired;
    console.log("", loginRequiredMessage);
    if (loginRequiredMessage) {
        // Tes 3: Apakah kondisi 'if' terpenuhi?
        console.log("Menampilkan SweetAlert...");

        Swal.fire({
            icon: "warning",
            title: "Akses Ditolak!",
            text: loginRequiredMessage,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Login Sekarang",
        }).then((result) => {
            if (result.isConfirmed) {
                var authModal = new bootstrap.Modal(
                    document.getElementById("authModal")
                );
                authModal.show();
            }
        });
    }
});
// Menjalankan script setelah seluruh halaman HTML selesai dimuat
document.addEventListener("DOMContentLoaded", function () {
    // --- BAGIAN 1: Menangani Notifikasi "Harus Login" ---
    const loginRequiredMessage = document.body.dataset.loginRequired;

    if (loginRequiredMessage) {
        Swal.fire({
            icon: "warning",
            title: "Akses Ditolak!",
            text: loginRequiredMessage,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Login Sekarang",
        }).then((result) => {
            if (result.isConfirmed) {
                var authModal = new bootstrap.Modal(
                    document.getElementById("authModal")
                );
                authModal.show();
            }
        });
    }

    // const hasValidationError = document.body.dataset.validationError;
    // const isRegisterError = document.body.dataset.errorIsRegister;
    // const loginErrorMessage = document.body.dataset.loginErrorMessage;
    // if (hasValidationError === "true") {
    //     var authModal = new bootstrap.Modal(
    //         document.getElementById("authModal")
    //     );
    //     if (isRegisterError === "true") {
    //         document
    //             .querySelector(".auth-container")
    //             .classList.add("is-flipped");
    //     }
    //     authModal.show();
    // }
    // if (loginErrorMessage) {
    //     Swal.fire({
    //         icon: "error",
    //         title: "Login Gagal!",
    //         text: loginErrorMessage,
    //     });
    // }
});
// searc journal page journal
document.addEventListener("DOMContentLoaded", function () {
    const sortBySelect = document.getElementById("sortBy");

    if (sortBySelect) {
        sortBySelect.addEventListener("change", function () {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("sort", this.value);
            window.location.href = currentUrl.toString();
        });
    }
});
