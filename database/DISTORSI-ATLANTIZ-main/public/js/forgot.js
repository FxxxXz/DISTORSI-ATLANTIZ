"use strict";

document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector(".needs-validation");
    const alertBox = document.getElementById("errorAlert");
    const errorList = document.getElementById("errorList");
    const successAlert = document.getElementById("successAlert");

    const btnSubmit = document.getElementById("btnSubmit");
    const btnSpinner = document.getElementById("btnSpinner");
    const btnText = document.getElementById("btnText");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        alertBox.classList.add("d-none");
        successAlert.classList.add("d-none");
        errorList.innerHTML = "";

        const email = document.getElementById("email");
        let errors = [];

        if (!email.value.trim()) {
            errors.push("Email wajib diisi.");
        } else if (!email.validity.valid) {
            errors.push("Format email tidak valid.");
        }

        if (errors.length > 0) {
            errors.forEach(err => {
                const li = document.createElement("li");
                li.textContent = err;
                errorList.appendChild(li);
            });

            alertBox.classList.remove("d-none");
            form.classList.add("was-validated");
            return;
        }

        kirimLink();
    });

    function kirimLink() {

        btnSubmit.disabled = true;
        btnSpinner.classList.remove("d-none");
        btnText.textContent = "Mengirim...";

        // simulasi request backend
        setTimeout(() => {

            successAlert.classList.remove("d-none");

            btnSpinner.classList.add("d-none");
            btnText.textContent = "TERKIRIM ✓";

        }, 2000);
    }

});