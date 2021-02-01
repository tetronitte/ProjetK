var username = document.getElementById('identifiant');
var login = document.getElementById('login');
var loginError = document.getElementById('loginError');
var welcomeNickname = document.getElementById('welcomeNickname');
var logout = document.getElementById('logout');
var admin = document.getElementById('admin');
var log_in = document.getElementById('log_in');
var loginModal = document.getElementById('loginModal');
var body = document.getElementById('body');

//========== Sert de DB =========================//
var pwdToto = "jesuistoto";
var usernameToto = "toto|toto@gmail.com";

var pwdJonas = "jesuisjonas";
var usernameJonas = "jonas|jonas@gmail.com";
//===============================================//

login.onclick = function() {
  var password = document.getElementById('loginPassword');
  if (password.value == pwdToto || password.value == pwdJonas) {
    var tmpToto = usernameToto.split("|");
    var tmpJonas = usernameJonas.split("|");
    if (username.value == tmpToto[0] || username.value == tmpToto[1] || username.value == tmpJonas[0] || username.value == tmpJonas[1]) {
      loging();
    }
    else {
      loginError.innerHTML = "Identifiant incorrect";
    }
  }
  else {
    loginError.innerHTML = "Mot de passe incorrect";
  }
}

function loging() {
  if (username.value == "toto" || username.value == "toto@gmail.com") {
    admin.style.display = "block";
  }
  welcomeNickname.style.display = "block";
  welcomeNickname.innerHTML = username.value;
  logout.style.display = "block";
  log_in.style.display = "none";
  loginModal.style.display = "none";
  body.style.overflowY = "visible";
}

logout.onclick = function() {
  welcomeNickname.style.display = "none";
  welcomeNickname.innerHTML = null;
  logout.style.display = "none";
  log_in.style.display = "block";
  admin.style.display = "none";
}
