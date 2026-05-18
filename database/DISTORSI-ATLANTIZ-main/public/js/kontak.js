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

/* ================= CONTACT FORM ================= */
const contactForm = document.getElementById("contactForm");

if (contactForm) {
  contactForm.addEventListener("submit", function(e) {
    e.preventDefault();
    
    const btn = this.querySelector(".btn-submit");
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>TERKIRIM!';
    btn.style.background = "#4CAF50";
    
    setTimeout(() => {
      btn.innerHTML = originalText;
      btn.style.background = "";
      this.reset();
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
});

/* ================= LOGOUT ================= */
function logout() {
  localStorage.removeItem("isLogin");
  localStorage.removeItem("username");
  window.location.href = window.location.origin;
}