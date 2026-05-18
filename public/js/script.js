"use strict";

/* TOGGLE PASSWORD */
function togglePassword(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);

  if (input.type === "password") {
    input.type = "text";
    icon.classList.replace("bi-eye-slash", "bi-eye");
  } else {
    input.type = "password";
    icon.classList.replace("bi-eye", "bi-eye-slash");
  }
}

/* =========================
   FORM VALIDATION & SUBMIT
========================= */
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".needs-validation");
  const alertBox = document.getElementById("errorAlert");
  const errorList = document.getElementById("errorList");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email");
    const password = document.getElementById("password");

    alertBox.classList.add("d-none");
    errorList.innerHTML = "";

    email.classList.remove("is-valid", "is-invalid");
    password.classList.remove("is-valid", "is-invalid");

    let errors = [];

    if (!email.value.trim() || !email.validity.valid) {
      errors.push("Email tidak valid");
      email.classList.add("is-invalid");
    } else {
      email.classList.add("is-valid");
    }

    if (!password.value.trim() || password.value.length < 6) {
      errors.push("Password minimal 6 karakter");
      password.classList.add("is-invalid");
    } else {
      password.classList.add("is-valid");
    }

    if (errors.length > 0) {
      errors.forEach((err) => {
        const li = document.createElement("li");
        li.textContent = err;
        errorList.appendChild(li);
      });
      alertBox.classList.remove("d-none");
      return;
    }

    form.submit(); // kirim ke Laravel
  });

  function prosesLogin() {
    // Disable tombol & tampilkan loading
    btnSubmit.disabled = true;
    btnSpinner.classList.remove("d-none");
    btnText.textContent = "Loading...";

    // Simulasi AJAX request (ganti dengan fetch/axios ke backend Anda)
    setTimeout(() => {
      // Sukses
      successAlert.classList.remove("d-none");

      // Redirect setelah 1.5 detik
      setTimeout(() => {
        console.log("Redirect ke dashboard...");
      }, 1500);
    }, 2000);
  }
});

// ================= LOGIN SIMULATION =================
const form = document.getElementById("loginForm");

if (form) {
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    const errorAlert = document.getElementById("errorAlert");
    const successAlert = document.getElementById("successAlert");
    const errorList = document.getElementById("errorList");

    errorList.innerHTML = "";
    errorAlert.classList.add("d-none");

    let errors = [];

    // VALIDASI
    if (email === "") errors.push("Email wajib diisi.");
    if (password === "") errors.push("Password wajib diisi.");

    if (errors.length > 0) {
      errors.forEach((err) => {
        errorList.innerHTML += `<li>${err}</li>`;
      });

      errorAlert.classList.remove("d-none");
      return;
    }

    // ================= LOGIN BERHASIL =================
    successAlert.classList.remove("d-none");

    // simpan username (ambil sebelum @)
    const username = email.split("@")[0];

    localStorage.setItem("username", username);
    localStorage.setItem("isLogin", "true");

    // redirect delay biar smooth
    setTimeout(() => {
      window.location.href = window.location.origin;
    }, 1200);
  });
}