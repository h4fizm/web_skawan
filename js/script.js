// burger button
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("mobile-menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  toggleBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });

  // Hero Carousel Swiper
  const heroSwiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 3000, // 3 detik
      disableOnInteraction: false,
    },
    effect: "fade",
    speed: 800,
  });

  // Testimonial Swiper
  const testimonialSwiper = new Swiper(".testimonialSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });

  // scroll top button
  const scrollToTopBtn = document.getElementById("scrollToTopBtn");

  // Tampilkan tombol saat user scroll ke bawah 300px
  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      scrollToTopBtn.classList.remove("hidden");
    } else {
      scrollToTopBtn.classList.add("hidden");
    }
  });

  // Scroll ke atas saat tombol diklik
  scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
});

// change image detail_product
function changeMainImage(thumbnail) {
  const mainImage = document.getElementById("mainImage");
  const newSrc = thumbnail.getAttribute("data-img");

  // Tambahkan efek fade-out
  mainImage.classList.add("opacity-0");

  setTimeout(() => {
    mainImage.src = newSrc;
    // Setelah gambar diganti, fade-in lagi
    mainImage.classList.remove("opacity-0");
  }, 200); // tunggu 200ms untuk animasi
}
