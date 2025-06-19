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
      }, 300); // sesuai transition
    }
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
