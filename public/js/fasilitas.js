"use strict";

/* ================= REVEAL ANIMATION ================= */
window.addEventListener("load", () => {
  const reveals = document.querySelectorAll(".reveal");
  
  reveals.forEach((el, index) => {
    setTimeout(() => {
      el.classList.add("active");
    }, 300 + index * 200);
  });
});

/* ================= NAVBAR SCROLL ================= */
const navbar = document.querySelector(".custom-navbar");

window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});

/* ================= PRICE CALCULATION ================= */
const harga = {
  regular: 75000,
  premium: 150000,
  recording: 500000
};

const studioType = document.getElementById("studioType");
const durasi = document.getElementById("durasi");
const totalPrice = document.getElementById("totalPrice");

function updatePrice() {
  const type = studioType.value;
  const jam = parseInt(durasi.value);
  
  if (type && harga[type]) {
    const total = harga[type] * jam;
    totalPrice.textContent = "Rp " + total.toLocaleString("id-ID");
  }
}

if (studioType) studioType.addEventListener("change", updatePrice);
if (durasi) durasi.addEventListener("change", updatePrice);

/* ================= OPEN BOOKING ================= */
function openBooking(type) {
  const bookingSection = document.getElementById("booking");
  const studioSelect = document.getElementById("studioType");
  
  if (studioSelect) {
    studioSelect.value = type;
    updatePrice();
  }
  
  bookingSection.scrollIntoView({ behavior: "smooth" });
}

/* ================= BOOKING FORM ================= */
const bookingForm = document.getElementById("bookingForm");

if (bookingForm) {
  bookingForm.addEventListener("submit", function(e) {
    e.preventDefault();
    
    const btn = this.querySelector(".btn-submit");
    const originalText = btn.textContent;
    
    btn.textContent = "BOOKING BERHASIL ✓";
    btn.style.background = "#4CAF50";
    
    setTimeout(() => {
      btn.textContent = originalText;
      btn.style.background = "";
      this.reset();
      updatePrice();
    }, 3000);
  });
}

/* ================= USER AREA ================= */
document.addEventListener("DOMContentLoaded", () => {
  const userArea = document.getElementById("userArea");
  const isLogin = localStorage.getItem("isLogin");
  const username = localStorage.getItem("username") || "Guest";

  if (isLogin === "true") {
    userArea.innerHTML = `
      <div class="dropdown">
        <div class="d-flex align-items-center gap-2 user-profile" data-bs-toggle="dropdown" style="cursor:pointer;">
          <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" />
          <span>${username}</span>
        </div>
        <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(0,0,0,0.9); backdrop-filter: blur(10px);">
          <li><a class="dropdown-item" href="#" style="color: white;">Dashboard</a></li>
          <li><button class="dropdown-item" id="logoutBtn" style="color: white;">Logout</button></li>
        </ul>
      </div>
    `;
    
    document.getElementById("logoutBtn").addEventListener("click", logout);
  } else {
    userArea.innerHTML = `<a href="${window.location.origin}/login" class="btn btn-outline-light btn-sm">Login</a>`;
  }
  
  updatePrice();
});

/* ================= LOGOUT ================= */
function logout() {
  localStorage.removeItem("isLogin");
  localStorage.removeItem("username");
  window.location.href = window.location.origin;
}