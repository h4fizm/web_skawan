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

// Backup fallback: paksa hilang setelah 5 detik
setTimeout(() => {
  const preloader = document.getElementById("preloader");
  if (preloader) {
    preloader.style.display = "none";
  }
}, 5000);

// =============================
// DOM READY FUNCTION
// =============================
document.addEventListener("DOMContentLoaded", () => {
  // Burger Menu Toggle
  const toggleBtn = document.getElementById("mobile-menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  if (toggleBtn && mobileMenu) {
    toggleBtn.addEventListener("click", () => {
      const isHidden = mobileMenu.classList.contains("hidden");

      if (isHidden) {
        mobileMenu.classList.remove("hidden");

        // Force reflow for transition
        void mobileMenu.offsetWidth;

        mobileMenu.classList.add(
          "opacity-100",
          "translate-y-0",
          "pointer-events-auto"
        );
        mobileMenu.classList.remove(
          "opacity-0",
          "-translate-y-4",
          "invisible",
          "pointer-events-none"
        );
      } else {
        mobileMenu.classList.remove(
          "opacity-100",
          "translate-y-0",
          "pointer-events-auto"
        );
        mobileMenu.classList.add(
          "opacity-0",
          "-translate-y-4",
          "pointer-events-none"
        );

        setTimeout(() => {
          mobileMenu.classList.add("hidden", "invisible");
        }, 300); // Sesuai durasi transition
      }
    });
  }
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
