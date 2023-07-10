import Swiper from 'swiper/bundle';
import 'swiper/css/bundle'
import './styles/swiper.scss'

const swiper = new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
    },
    navigation: {
        nextEl: ".button-next",
        prevEl: ".button-prev",
    },
});

const swiper2 = new Swiper(".mySwiperFavorite", {
    cssMode: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination-favorite",
    },
    mousewheel: true,
    keyboard: true,
});
