$(document).ready(function () {
    $("#carousel1").owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 4000, // Waktu tunggu antara slide (dalam milidetik)
        autoplayHoverPause: true,
        dots: true,
    });

    $("#carousel3").owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 4000, // Waktu tunggu antara slide (dalam milidetik)
        autoplayHoverPause: false,
        dots: false,
    });

    $("#carousel2").owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5500, // Waktu tunggu antara slide (dalam milidetik)
        autoplayHoverPause: true,
        dots: true,
    });
});
