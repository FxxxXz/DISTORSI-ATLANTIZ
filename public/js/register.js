"use strict";

/* =========================
   TOGGLE PASSWORD VISIBILITY
========================= */
function togglePassword(inputId, iconId) {
  const password = document.getElementById(inputId);
  const icon = document.getElementById(iconId);

  if (password.type === "password") {
    password.type = "text";
    icon.classList.remove("bi-eye-slash");
    icon.classList.add("bi-eye");
  } else {
    password.type = "password";
    icon.classList.remove("bi-eye");
    icon.classList.add("bi-eye-slash");
  }
}

/* =========================
   FORM VALIDATION & SUBMIT
========================= */
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registerForm");
  const alertBox = document.getElementById("errorAlert");
  const errorList = document.getElementById("errorList");
  const successAlert = document.getElementById("successAlert");
  const btnSubmit = document.getElementById("btnSubmit");
  const btnSpinner = document.getElementById("btnSpinner");
  const btnText = document.getElementById("btnText");

  // Regex untuk validasi email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    event.stopPropagation();

    // Reset alert
    errorList.innerHTML = "";
    alertBox.classList.add("d-none");
    successAlert.classList.add("d-none");

    // Ambil elemen
    const namaLengkap = document.getElementById("namaLengkap");
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const konfirmasiPassword = document.getElementById("konfirmasiPassword");

    let errors = [];

    // Validasi Nama Lengkap
    if (!namaLengkap.value.trim()) {
      errors.push("Nama lengkap wajib diisi.");
    } else if (namaLengkap.value.trim().length < 3) {
      errors.push("Nama lengkap minimal 3 karakter.");
    }

    // Validasi Username
    if (!username.value.trim()) {
      errors.push("Username wajib diisi.");
    } else if (username.value.trim().length < 5) {
      errors.push("Username minimal 5 karakter.");
    } else if (!/^[a-zA-Z0-9_]+$/.test(username.value)) {
      errors.push("Username hanya boleh huruf, angka, dan underscore.");
    }

    // Validasi Email
    if (!email.value.trim()) {
      errors.push("Email wajib diisi.");
    } else if (!emailRegex.test(email.value)) {
      errors.push("Format email tidak valid.");
    }

    // Validasi Password
    if (!password.value) {
      errors.push("Password wajib diisi.");
    } else if (password.value.length < 6) {
      errors.push("Password minimal 6 karakter.");
    }

    // Validasi Konfirmasi Password
    if (!konfirmasiPassword.value) {
      errors.push("Konfirmasi password wajib diisi.");
    } else if (password.value !== konfirmasiPassword.value) {
      errors.push("Password dan konfirmasi password tidak cocok.");
    }

    // Jika ada error
    if (errors.length > 0) {
      errors.forEach((err) => {
        const li = document.createElement("li");
        li.textContent = err;
        errorList.appendChild(li);
      });
      alertBox.classList.remove("d-none");
      form.classList.add("was-validated");
      return;
    }

    // Jika valid → Proses register
    form.classList.add("was-validated");
    prosesRegister();
  });

  function prosesRegister() {
    btnSubmit.disabled = true;
    btnSpinner.classList.remove("d-none");
    btnText.textContent = "Loading...";

    // Simulasi AJAX request
    setTimeout(() => {
      successAlert.classList.remove("d-none");

      // Redirect ke login setelah 2 detik
      setTimeout(() => {
        window.location.href = window.location.origin + "/login";
      }, 2000);
    }, 2000);
  }
});