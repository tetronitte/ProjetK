var password = document.getElementById('signinPassword');
var verifPassword = document.getElementById('verifPassword');
var nickname = document.getElementById('nickname');
var signin = document.getElementById('signin');
var signinError = document.getElementById('signinError');
var email = document.getElementById('email');
var signinModal = document.getElementById('signinModal');
var body = document.getElementById('body');

var user = "toto";
var mail = "toto@gmail.com";
var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

signin.onclick = function() {
  if (password.value != verifPassword.value) {
    signinError.innerHTML = "Vérification de mot de passe érronée";
  }
  else if (nickname.value == user) {
    signinError.innerHTML = "Ce pseudo est déjà utilisé";
  }
  else if (email.value == mail) {
    signinError.innerHTML = "Cette adresse est déjà utilisée";
  }
  else if (!regex.test(email.value)) {
    signinError.innerHTML = "Adresse email non valide";
  }
  else {
    signing();
  }
}

function signing() {
  signinModal.style.display = "none";
  console.log("Vous êtes bien inscrit !");
  body.style.overflowY = "visible";
}
