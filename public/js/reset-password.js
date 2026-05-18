const password = document.getElementById("newPassword");
const confirmPassword = document.getElementById("confirmPassword");

const passwordError = document.getElementById("passwordError");
const confirmError = document.getElementById("confirmError");

/* VALIDASI PASSWORD */
password.addEventListener("input", () => {

  if (password.value.length < 6) {
    password.classList.add("is-invalid");
    password.classList.remove("is-valid");
    passwordError.textContent = "Minimal 6 karakter";
  } else {
    password.classList.remove("is-invalid");
    password.classList.add("is-valid");
    passwordError.textContent = "";
  }

  checkMatch();
});

/* VALIDASI KONFIRMASI */
confirmPassword.addEventListener("input", checkMatch);

function checkMatch() {

  if (confirmPassword.value === "") return;

  if (confirmPassword.value !== password.value) {
    confirmPassword.classList.add("is-invalid");
    confirmPassword.classList.remove("is-valid");
    confirmError.textContent = "Password tidak sama";
  } else {
    confirmPassword.classList.remove("is-invalid");
    confirmPassword.classList.add("is-valid");
    confirmError.textContent = "";
  }
}