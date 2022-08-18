let form = document.querySelector("#Submit");
let email = document.getElementById("Email");
let error = document.querySelector(".error");

form.addEventListener(
  "click",
  function (event) {
    if (!email.validity.valid) {
      error.innerHTML = "Vérifiez votre adresse email.";
      event.preventDefault();
    } else error.innerHTML = "";
  },
  false
);

let btnGameRequired = document.querySelector("#GameRequired");

if (btnGameRequired !== null) {
  btnGameRequired.addEventListener(
    "click",
    function (event) {
      error.innerHTML =
        "Jouez au jeu ci-dessus avant de valider votre formulaire !";
    },
    false
  );
}

let optinSMS = document.querySelector("#Optin3");
let inputTel = document.querySelector("#Telephone");
let labelTel = document.querySelector(".span-Telephone");

optinSMS.addEventListener("click", (e) => {
  if (optinSMS.checked == true) {
    inputTel.required = true;
    labelTel.innerHTML += "*";
  } else {
    inputTel.required = false;
    labelTel.innerHTML = labelTel.innerHTML.slice(0, -1);
  }
});
