var parameters = location.search.substring(1).split("&");//Récupère l'url et découpe les paramètres
var theme = parameters[0].split("=");
theme = theme[1];
var level = parameters[1].split("=");
level = level[1];

var transportLevel1 = ['velo;Transport à 2 roues où il faut pédaler',
  'trottinette;Transport à deux roues où il faut pousser avec le pied',
  'moto;Transport à deux roues à moteur',
  'voiture;Transport à 4 roues à moteur',
  'bus;Transport en commun à 4 roues',
  'avion;Transport volant',
  'bateau;Transport marin',
  'train;Transport ferrovier',
  'fusee;Transport dans l\'espace',
  'cheval;Transport animalier à 4 pattes'];
var transportLevel2 = ['peniche;Transport de cargaison fluvial',
  'tgv;Train grande vitesse',
  'ascenseur;Transporte d\'un étage à l\'autre',
  'charrette;Ancien moyen de transport à 2 roues constitué d\'un plateau',
  'dirigeable;Aéronef léger',
  'limousine;Très longue voiture',
  'sous-marin;Transport allant sous l\'eau',
  'roller;Transport à roulettes montées sur chaussure',
  'ski;Transport sur neige',
  'pedalo;Transport naval se propulsant avec les pieds'];
var transportLevel3 = ['yacht;bateau de plaisance',
  'trireme;bateau grec à 3 rangs de rames',
  'funiculaire;Remontée mécanique sur rail',
  'diligence;Voiture à cheval pour transport de voyageur',
  'catamaran;Transport naval possédant 2 coques et une voile',
  'luge;Transport de glisse sur neige',
  'telepherique;Remontée mécanique par cable aérien',
  'skateboard;Une planche et 4 roues',
  'hydravion;Avion capable de déjauger',
  'camionnette;Petit camion'];
var animalsLevel1 = ['girafe;Long cou',
  'chien;Ouaf',
  'loup;C\'est pour mieux te manger mon enfant',
  'poule;Cot cot',
  'araignee;Moche avec 8 yeux',
  'chenille;Se transforme en jolie papillon',
  'autruche;Faire l\'...',
  'cochon;Gruik gruik',
  'dauphin;Flipper',
  'orque;Sauvez Willy !'];
var animalsLevel2 = ['pingouin;Oiseau de l\'hémisphère nord blanc et noir',
  'bison;Bovidé d\'amérique du nord',
  'baleine;Le plus grand des cétacés',
  'hirondelle;Oiseau migrateur très connus',
  'gnou;Bovidé d\'afrique',
  'zebre;Cheval code barre',
  'mygale;Araignée poilue',
  'tapir;Mammifère à trompe',
  'babouin;Singe d\'Afrique',
  'kangourou;Marsupial d\'australie'];
var animalsLevel3 = ['gavial;Reptile du Nil',
  'crotale;Seul viperidae trouvable en Amérique ',
  'lynx;Félin des forêts boréales',
  'dodo;Malheur à vous',
  'hase;Femelle du lièvre',
  'hyene;Ricane',
  'wapiti;Cervidés d\'amérique du nord',
  'narval;Licorne des mers',
  'jaguar;Félin d\'Amérique du sud',
  'fennec;Renard des sables'];

var indication = document.getElementById('indication');
var points = document.getElementById('points');
var timer = document.getElementById('timer');
var remainingWords = document.getElementById('remainingWords');
var letters = document.getElementById('letters');
var response = document.getElementById('response');
var help = document.getElementById('help');
var skip = document.getElementById('skip');
var playingArray = new Array;
var time = 0;
var helped = false;

response.focus();

switch (theme) {
  case 'transport':
    switch (level) {
      case '1':
        playingArray = transportLevel1;
        time = 100;
        break;
      case '2':
        time = 150;
        playingArray = transportLevel2;
        break;
      case '3':
        time = 200;
        playingArray = transportLevel3;
        break;
    }
    break;
  case 'animals':
    switch (level) {
      case '1':
        time = 100;
        playingArray = animalsLevel1;
        break;
      case '2':
        time = 150;
        playingArray = animalsLevel2;
        break;
      case '3':
        time = 200;
        playingArray = animalsLevel3;
        break;
    }
    break;
}

var indice = 0;
var word = "";
var pts = 0;
var gain = 100;
var helpCount = 0;
var helpArray;
var lettersArray;

display(indice);

timer.innerHTML = time;
timer.style.visibility = "visible";//Permet d'initialiser le timer dès l'affichage de la page

refreshTimer = setInterval(function(){
  time--;
  timer.innerHTML = time;
},1000);

timeout = setTimeout(function () {
  clearInterval(refreshTimer);
  display(-2);
}, time*1000+300);//le + 300 permet de bien afficher le 0 avant la fin

response.onkeyup = function() {//Pour chaque caractère tapé dans l'input
  var tmp = response.value;
  tmp = tmp.replace(/[éè]/g,'e');//remplace les accents
  if (word == tmp.toLowerCase()){//On met tout en petit
    indice++;
    pts += gain;
    if (gain!= 100) gain = 100;//Si pénalité de point à cause d'un help on réinitialise le gain 'normal' de point
    helped = false;//Réinitialise l'aide
    if (indice < playingArray.length) {//On parcourt le tableau de mots
      display(indice);
    }
    else {
      display(-1);//C'est gagné
    }
  }
}

help.onclick = function() {//Permet d'afficher une lettre aléatoire pour aider
  helped = true;//Bloque le skip
  var tmp = "";
  if (helpCount > 0) {
    gain -= Math.floor(100/word.length);//Pour chaque help sur un mot, réduit le nombre de point gagner après l'avoir trouvé
    randomLetter();
    helpCount--;
    for (var i = 0 ; i < word.length ; i++) {
      tmp = tmp+lettersArray[i];
    }
    letters.innerHTML = tmp;
  }
}

skip.onclick = function() {//Permet de skip un mot et le placer à la fin
  if (indice < playingArray.length-1 && !helped) {
    insertQueueArray();
  }
}

function insertQueueArray() {
  var tmp = playingArray[indice];//On récupère l'élément à skip
  playingArray.splice(indice,1);//On le supprime du tableau
  playingArray.splice(playingArray.length,0,tmp);//On l'ajoute à la fin
  display(indice);//On réaffiche l'écran avec le nouveau mot
}

function randomLetter() {
  var i = Math.floor(Math.random() * (word.length-1 - 0 +1)) + 0;
  while(helpArray[i] != undefined) {//Tant que l'indice aléatoire est le même qu'un qui a déjà été tiré on recommence
    i = Math.floor(Math.random() * (word.length-1 - 0 +1)) + 0;
  }
  helpArray[i] = true;
  lettersArray[i] = word[i]+" ";//Affiche un caractère aléatoire pour aider
}

function display(i) {//Affiche les éléments à l'écran
  if (i == -2) {//C'EST PERDU
    indication.innerHTML = "";
    remainingWords.innerHTML = "";
    response.disabled = true;
    clearInterval(refreshTimer);
    letters.innerHTML = "";
    points.innerHTML = "";
    displayModal(0);
  }
  else if (i == -1) {//C'EST GAGNE
    indication.innerHTML = "";
    remainingWords.innerHTML = "";
    response.disabled = true;
    clearTimeout(timeout);
    clearInterval(refreshTimer);
    letters.innerHTML = "";
    points.innerHTML = "";
    pts += timer.innerHTML*25;
    displayModal(1);
  }
  else {//On change de mot
    var tmp = playingArray[i].split(";");
    word = tmp[0];
    indication.innerHTML = tmp[1];
    remainingWords.innerHTML = (10-i)+" mots restants";
    response.value = null;
    helpCount = word.length-1;
    helpArray = new Array(word.length);
    lettersArray = new Array(word.length);
    var tmp2 = "";
    for (var j = 0 ; j < word.length ; j++) {
      lettersArray[j] = "_ ";
      tmp2 = tmp2+"_ ";
    }
    letters.innerHTML = tmp2;
    points.innerHTML = pts+" points";
    //console.log("word : "+word);
  }
}

function displayModal(i) {
  var resultModal = document.getElementById('resultModal');
  var winloose = document.getElementById('resultat');
  var pointsSpan = document.getElementById('pts');

  resultModal.classList.add("show");
  resultModal.style.display = "block";
  if (i == 0) {
    winloose.innerHTML = "C\'EST PERDU !"
  }
  else {
    winloose.innerHTML = "C\'EST GAGNE !"
  }
  pointsSpan.innerHTML = pts;
}
