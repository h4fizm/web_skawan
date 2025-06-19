// =============================
// PRELOADER (LOADING EFFECT)
// =============================
function hidePreloader() {
  const preloader = document.getElementById("preloader");
  if (preloader) {
    preloader.classList.add("opacity-0");
    setTimeout(() => {
      preloader.style.display = "none";
    }, 500);
  }
}

// Saat DOM siap: sembunyikan preloader
document.addEventListener("DOMContentLoaded", hidePreloader);
// Backup fallback: paksa hilang setelah 5 detik
setTimeout(hidePreloader, 5000);

// =============================
// DOM READY FUNCTION
// =============================
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("mobile-menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  toggleBtn.addEventListener("click", () => {
    const isHidden = mobileMenu.classList.contains("hidden");

    if (isHidden) {
      // Show menu with smooth effect
      mobileMenu.classList.remove("hidden");

      // Force reflow to enable transition
      void mobileMenu.offsetWidth;

      mobileMenu.classList.add("opacity-100", "translate-y-0");
      mobileMenu.classList.remove("opacity-0", "-translate-y-4");
    } else {
      // Hide menu with transition, then remove from DOM flow
      mobileMenu.classList.remove("opacity-100", "translate-y-0");
      mobileMenu.classList.add("opacity-0", "-translate-y-4");

      // Delay `hidden` until animation ends
      setTimeout(() => {
        mobileMenu.classList.add("hidden");
      }, 300); // match `transition duration-300`
    }
  });

  // ---------------------------------------
  // 2. HERO SECTION: Swiper Carousel
  // ---------------------------------------
  const heroSwiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    effect: "fade",
    speed: 800,
  });

  // ---------------------------------------
  // 3. PARALLAX EFFECT: Untuk gambar dalam card
  // ---------------------------------------
  const parallaxContainers = document.querySelectorAll(".parallax-container");

  window.addEventListener("scroll", () => {
    parallaxContainers.forEach((container) => {
      const img = container.querySelector(".parallax-img");
      const rect = container.getBoundingClientRect();
      const scrollSpeed = 0.2;
      const maxTranslate = 40;

      const offset = rect.top - window.innerHeight / 2;
      const rawTranslate = offset * scrollSpeed;
      const translateY = Math.max(
        -maxTranslate,
        Math.min(maxTranslate, rawTranslate)
      );

      if (img) img.style.transform = `translateY(${translateY}px)`;
    });
  });

  // ---------------------------------------
  // 4. TESTIMONIAL SWIPER
  // ---------------------------------------
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

  // ---------------------------------------
  // 5. SCROLL TO TOP BUTTON
  // ---------------------------------------
  const scrollToTopBtn = document.getElementById("scrollToTopBtn");

  window.addEventListener("scroll", () => {
    if (scrollToTopBtn) {
      if (window.scrollY > 300) {
        scrollToTopBtn.classList.remove("hidden");
      } else {
        scrollToTopBtn.classList.add("hidden");
      }
    }
  });

  if (scrollToTopBtn) {
    scrollToTopBtn.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  // ---------------------------------------
  // 6. MODAL POPUP: Info Button
  // ---------------------------------------
  const infoBtn = document.getElementById("infoButton");
  const infoModal = document.getElementById("infoModal");

  if (infoBtn && infoModal) {
    infoBtn.addEventListener("click", () => {
      infoModal.classList.remove("hidden");
    });
  }
});

// =============================
// GANTI GAMBAR (DETAIL PRODUCT)
// =============================
function changeMainImage(thumbnail) {
  const mainImage = document.getElementById("mainImage");
  const newSrc = thumbnail.getAttribute("data-img");

  if (mainImage && newSrc) {
    mainImage.classList.add("opacity-0");
    setTimeout(() => {
      mainImage.src = newSrc;
      mainImage.classList.remove("opacity-0");
    }, 200);
  }
}

// =============================
// COPY LINK (CHECKOUT PAGE)
// =============================
function copyLink() {
  const input = document.getElementById("linkDesain");
  const message = document.getElementById("copyMessage");

  if (input && message) {
    input.select();
    input.setSelectionRange(0, 99999); // Untuk mobile
    document.execCommand("copy");

    message.classList.remove("hidden");
    setTimeout(() => {
      message.classList.add("hidden");
    }, 2000);
  }
}
