//* Function scope
const togglePassword = function () {
  const input = document.getElementById("password");
  const icon = document.getElementById("icon-login");
  const myImage = document.querySelector("#icon-login");

  // Function expression untuk toggle password
  icon.onclick = function () {
    if (input.type === "password") {
      input.type = "text";
      myImage.src = "images/eye.svg";
    } else {
      input.type = "password";
      myImage.src = "images/eye-slash.svg";
    }
  };
};
// Panggil fungsi setelah didefinisikan
togglePassword();
