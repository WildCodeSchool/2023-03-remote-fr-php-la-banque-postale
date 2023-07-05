document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carouselExample');
    // eslint-disable-next-line no-undef
    const carouselInstance = new bootstrap.Carousel(carousel);

    const validateButton = document.querySelectorAll('#carouselExample .carousel-item button[type="submit"]');
    const prevButton = document.querySelector('.carousel-control-prev');

    validateButton.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const currentItem = carousel.querySelector('.carousel-item.active');
            const nextItem = currentItem.nextElementSibling;

            if (nextItem !== null) {
                carouselInstance.next();
            } else {
                button.setAttribute('type', 'submit');
            }
        });
    });

    prevButton.addEventListener('click', function (event) {
        event.preventDefault();
        carouselInstance.prev();
    });
});
