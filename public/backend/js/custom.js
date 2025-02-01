// custom.js

// Toggle the side navigation
$("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
    };
});

// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
$('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
        var e0 = e.originalEvent,
            delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
    }
});

// Scroll to top button appear
$(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
        $('.scroll-to-top').fadeIn();
    } else {
        $('.scroll-to-top').fadeOut();
    }
});

// Smooth scrolling using jQuery easing
$(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
});

document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll(".form-control");

    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.nextElementSibling.classList.add("active");
        });

        input.addEventListener("blur", function () {
            if (this.value === "") {
                this.nextElementSibling.classList.remove("active");
            }
        });

        // Pastikan label tetap di atas jika ada nilai saat halaman dimuat ulang
        if (input.value !== "") {
            input.nextElementSibling.classList.add("active");
        }
    });
});
