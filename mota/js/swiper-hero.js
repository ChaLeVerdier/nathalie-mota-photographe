jQuery(document).ready(function($) {
    var swiper = new Swiper('.swiper-hero', {
        loop: true,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
