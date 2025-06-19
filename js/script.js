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

  // Parallax Effect
  const parallaxContainers = document.querySelectorAll(".parallax-container");

  window.addEventListener("scroll", () => {
    parallaxContainers.forEach((container) => {
      const img = container.querySelector(".parallax-img");
      const rect = container.getBoundingClientRect();
      const scrollSpeed = 0.2; // Lebih ringan
      const maxTranslate = 40; // Maksimal gerakan 40px

      const offset = rect.top - window.innerHeight / 2;
      const rawTranslate = offset * scrollSpeed;
      const translateY = Math.max(
        -maxTranslate,
        Math.min(maxTranslate, rawTranslate)
      );

      img.style.transform = `translateY(${translateY}px)`;
    });
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

// copylink design checkout page
function copyLink() {
  const input = document.getElementById("linkDesain");
  const message = document.getElementById("copyMessage");

  input.select();
  input.setSelectionRange(0, 99999); // Mobile support
  document.execCommand("copy");

  // Tampilkan pesan berhasil
  message.classList.remove("hidden");
  setTimeout(() => {
    message.classList.add("hidden");
  }, 2000);
}

// modal pop-up
document.getElementById("infoButton").addEventListener("click", () => {
  document.getElementById("infoModal").classList.remove("hidden");
});
