// =============================
// PRELOADER (LOADING EFFECT)
// =============================
window.addEventListener("load", () => {
  const preloader = document.getElementById("preloader");
  if (preloader) {
    preloader.classList.add("opacity-0");
    setTimeout(() => {
      preloader.style.display = "none";
    }, 500);
  }
});

// =============================
// TOGGLE BUTTON LIGHT/DARK MODE
// =============================
const toggleButton = document.getElementById("theme-toggle");
const toggleCircle = document.getElementById("toggle-circle");
const themeLabel = document.getElementById("theme-label");

// Inisialisasi awal saat halaman dibuka
if (localStorage.getItem("theme") === "dark") {
  document.documentElement.classList.add("dark");
  toggleCircle.classList.add("translate-x-8");
  themeLabel.textContent = "Mode Gelap";
} else {
  document.documentElement.classList.remove("dark");
  toggleCircle.classList.remove("translate-x-8");
  themeLabel.textContent = "Mode Terang";
}

// Saat tombol diklik
toggleButton.addEventListener("click", () => {
  const html = document.documentElement;
  const isDark = html.classList.toggle("dark");
  toggleCircle.classList.toggle("translate-x-8");
  localStorage.setItem("theme", isDark ? "dark" : "light");
  themeLabel.textContent = isDark ? "Mode Gelap" : "Mode Terang";
});

// =============================
// DOM READY FUNCTION
// =============================
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("mobile-menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  if (toggleBtn && mobileMenu) {
    toggleBtn.addEventListener("click", () => {
      const isHidden = mobileMenu.classList.contains("opacity-0");

      if (isHidden) {
        mobileMenu.classList.remove(
          "hidden",
          "opacity-0",
          "pointer-events-none"
        );
        mobileMenu.classList.add("opacity-100", "pointer-events-auto");
      } else {
        mobileMenu.classList.remove("opacity-100", "pointer-events-auto");
        mobileMenu.classList.add("opacity-0", "pointer-events-none");
        setTimeout(() => {
          mobileMenu.classList.add("hidden");
        }, 300);
      }
    });
  }
});

// SWIPER HERO SECTION
document.addEventListener("DOMContentLoaded", function () {
  const heroSwiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    speed: 1000,
    effect: "fade", // opsional: efek fade antar slide
    fadeEffect: {
      crossFade: true,
    },
    keyboard: {
      enabled: true,
    },
    allowTouchMove: true, // bisa digeser manual di mobile
  });
});

// ===========================================
// PARALLAX EFFECT untuk .parallax-container
// ===========================================
window.addEventListener("scroll", () => {
  const parallaxContainers = document.querySelectorAll(".parallax-container");

  parallaxContainers.forEach((container) => {
    const img = container.querySelector(".parallax-img");
    if (!img) return;

    const rect = container.getBoundingClientRect();
    const scrollSpeed = 0.5; // kamu bisa ubah percepatannya
    const maxTranslate = 30;

    const offset = rect.top - window.innerHeight / 2;
    const rawTranslate = offset * scrollSpeed;
    const translateY = Math.max(
      -maxTranslate,
      Math.min(maxTranslate, rawTranslate)
    );

    img.style.transform = `translateY(${translateY}px)`;
  });
});

// SWIPPER JS SECTION TESTIMONIALS
const swiper = new Swiper(".testimonialSwiper", {
  loop: true,
  grabCursor: true,
  slidesPerView: 1,
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 5000,
  },
  breakpoints: {
    768: {
      slidesPerView: 1,
    },
  },
});

// BUTTON SCROLL TOP
const scrollToTopBtn = document.getElementById("scrollToTopBtn");

// Tampilkan tombol saat user scroll ke bawah 200px
window.addEventListener("scroll", () => {
  if (window.scrollY > 200) {
    scrollToTopBtn.classList.remove("hidden");
  } else {
    scrollToTopBtn.classList.add("hidden");
  }
});

// Scroll smooth ke atas saat tombol ditekan
scrollToTopBtn.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
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

// upload edit user photo profile
function previewPhoto(event) {
  const image = document.querySelector("img[alt='Foto Profil']");
  image.src = URL.createObjectURL(event.target.files[0]);
}

// dropdown menu user profile
const avatarBtn = document.getElementById("avatar-btn");
const dropdown = document.getElementById("avatar-dropdown");

avatarBtn.addEventListener("click", function (e) {
  e.stopPropagation();
  dropdown.classList.toggle("hidden");
});

document.addEventListener("click", function (e) {
  if (!avatarBtn.contains(e.target)) {
    dropdown.classList.add("hidden");
  }
});
