"use strict";

/* ================= REVEAL ANIMATION ================= */
window.addEventListener("load", () => {
  const reveals = document.querySelectorAll(".reveal");

  reveals.forEach((el, index) => {
    setTimeout(() => {
      el.classList.add("active");
    }, 300 + index * 200);
  });

  createDots();
});

/* ================= NAVBAR SCROLL ================= */
const navbar = document.querySelector(".custom-navbar");

window.addEventListener("scroll", () => {
  if (navbar) {
    if (window.scrollY > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  }
});

/* ================= ABOUT SLIDER (TANPA TOMBOL PANAH) ================= */
let currentSlide = 0;
const slides = document.querySelectorAll(".about-slide");
const totalSlides = slides.length;

function createDots() {
  const dotsContainer = document.getElementById("sliderDots");
  if (!dotsContainer) return;

  dotsContainer.innerHTML = "";

  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement("span");
    dot.className = "slider-dot" + (i === 0 ? " active" : "");
    dot.onclick = () => goToSlide(i);
    dotsContainer.appendChild(dot);
  }
}

function updateSlides() {
  slides.forEach((slide, index) => {
    slide.classList.toggle("active", index === currentSlide);
  });

  const dots = document.querySelectorAll(".slider-dot");
  dots.forEach((dot, index) => {
    dot.classList.toggle("active", index === currentSlide);
  });
}

function goToSlide(index) {
  currentSlide = index;
  updateSlides();
}

// Fungsi nextSlide dan prevSlide sudah TIDAK DIPERLUKAN LAGI
// Tombol panah sudah dihapus dari HTML dan CSS

/* ================= TEAM GRID (STATIS, BUKAN SLIDER) ================= */
// Team sekarang menggunakan grid statis, tidak memerlukan JavaScript untuk slider
// Semua fungsi team slider sudah dihapus

/* ================= USER AREA ================= */
document.addEventListener("DOMContentLoaded", () => {
  const userArea = document.getElementById("userArea");
  const isLogin = localStorage.getItem("isLogin");
  const username = localStorage.getItem("username") || "Guest";

  if (userArea) {
    if (isLogin === "true") {
      userArea.innerHTML = `
        <div class="dropdown">
          <div class="d-flex align-items-center gap-2 user-profile" data-bs-toggle="dropdown" style="cursor:pointer;">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User" />
            <span>${username}</span>
          </div>
          <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(0,0,0,0.9); backdrop-filter: blur(10px);">
            <li><a class="dropdown-item" href="#" style="color: white;">Dashboard</a></li>
            <li><button class="dropdown-item" id="logoutBtn" style="color: white;">Logout</button></li>
          </ul>
        </div>
      `;

      const logoutBtn = document.getElementById("logoutBtn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", logout);
      }
    } else {
      userArea.innerHTML = `<a href="${window.location.origin}/login" class="btn btn-outline-light btn-sm">Login</a>`;
    }
  }
});

/* ================= LOGOUT ================= */
function logout() {
  localStorage.removeItem("isLogin");
  localStorage.removeItem("username");
  window.location.href = window.location.origin;
}
