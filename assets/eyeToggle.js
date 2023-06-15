let eyeToggle = document.getElementById("eyeIcon");
let password = document.getElementById("inputPassword");

eyeToggle.onclick = function (event) {
    event.preventDefault();
    if (password.type == "password") {
        password.type = "text";
        eyeToggle.className = "fa-solid fa-eye text-secondary";
    } else {
        password.type = "password";
        eyeToggle.className = "fa-regular fa-eye-slash text-secondary";
    }
}
