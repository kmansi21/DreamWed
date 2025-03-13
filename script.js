// Swiper for home slider
var homeSlider = new Swiper(".home-slider", {
  loop: true,
  spaceBetween: 20,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 5000, // Auto-play with 5 seconds delay
    disableOnInteraction: false, // Continue autoplay after user interactions
  },
});

// Swiper for service slider with breakpoints
var serviceSlider = new Swiper(".service-slider", {
  loop: true,
  spaceBetween: 20,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    450: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1000: {
      slidesPerView: 3,
    },
  },
});

// Swiper for reviews slider with breakpoints
var reviewsSlider = new Swiper(".reviews-slider", {
  loop: true,
  spaceBetween: 20,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    450: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1000: {
      slidesPerView: 3,
    },
  },
});
