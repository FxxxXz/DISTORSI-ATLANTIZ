"use strict";

console.log("Dashboard loaded");

/* =========================
   FADE REVEAL PAGE LOAD
========================= */
window.addEventListener("load", () => {
  const reveals = document.querySelectorAll(".reveal");

  reveals.forEach((el, index) => {
    setTimeout(
      () => {
        el.classList.add("active");
      },
      300 + index * 200,
    );
  });
});

/* =========================
   NAVBAR SCROLL EFFECT
========================= */
const navbar = document.querySelector(".custom-navbar");

window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});

/* =========================
   USER NAVBAR SYSTEM
========================= */
document.addEventListener("DOMContentLoaded", () => {
  const userArea = document.getElementById("userArea");

  const isLogin = localStorage.getItem("isLogin");
  const username = localStorage.getItem("username") || "Guest";

  // ===== USER LOGIN =====
  if (isLogin === "true") {
    userArea.innerHTML = `
      <div class="dropdown">
        <div class="d-flex align-items-center gap-2 user-profile"
             data-bs-toggle="dropdown"
             style="cursor:pointer;">

          <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
               class="profile-icon">

          <span>${username}</span>
        </div>

        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Dashboard</a></li>
          <li><button class="dropdown-item" id="logoutBtn">Logout</button></li>
        </ul>
      </div>
    `;

    // Ganti dari logout langsung ke confirmLogout
    document.getElementById("logoutBtn").addEventListener("click", confirmLogout);
  }

  // ===== GUEST MODE =====
  else {
    userArea.innerHTML = `
      <a href="${window.location.origin}/login" class="btn btn-outline-light btn-sm">
        Login
      </a>
    `;
  }
});

/* =========================
   LOGOUT DENGAN KONFIRMASI
========================= */
function confirmLogout() {
  // Cek apakah SweetAlert tersedia
  if (typeof Swal !== 'undefined' && Swal) {
    // Gunakan SweetAlert yang lebih keren
    Swal.fire({
      title: 'Yakin ingin keluar?',
      text: 'Anda akan diarahkan ke halaman utama.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#ff4d4d',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Keluar!',
      cancelButtonText: 'Batal',
      background: '#1a1a1a',
      color: '#fff',
      iconColor: '#ff4d4d'
    }).then((result) => {
      if (result.isConfirmed) {
        // Tampilkan animasi sukses logout
        Swal.fire({
          title: 'Berhasil Keluar!',
          text: 'Sampai jumpa lagi!',
          icon: 'success',
          confirmButtonColor: '#ff4d4d',
          background: '#1a1a1a',
          color: '#fff',
          timer: 1500,
          showConfirmButton: false
        });
        setTimeout(() => {
          logout();
        }, 1500);
      }
    });
  } else {
    // Fallback ke confirm bawaan browser
    const yakin = confirm("Apakah Anda yakin ingin keluar?");
    if (yakin) {
      logout();
    }
  }
}

/* =========================
   LOGOUT FUNCTION
========================= */
function logout() {
  localStorage.removeItem("isLogin");
  localStorage.removeItem("username");
  window.location.href = window.location.origin;
}
