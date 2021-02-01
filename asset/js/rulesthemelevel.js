var rule1 = document.getElementById('rule1');//On récupère le span dans règles
var rule2 = document.getElementById('rule2');
var rule3 = document.getElementById('rule3');

var levelLeft = document.getElementById('levelLeft');//On récupère les flèches du carousel
var levelRight = document.getElementById('levelRight');

var level;

levelLeft.onclick = function() {
  timeout = setTimeout(function () {//Le timeout permet de ne pas récupérer l'ID trop tôt le temps de l'animation de slide du carousel
    var id = recupID();
    displayRule(id);
  }, 750);
}

levelRight.onclick = function() {
  timeout = setTimeout(function () {
    var id = recupID();
    displayRule(id);
  }, 750);
}

function displayRule(id) {//On affiche les valeurs
  switch (id) {
    case '1' :
      rule1.innerHTML = "100";
      rule2.innerHTML = "10";
      rule3.innerHTML = "20";
      break;
    case '2' :
      rule1.innerHTML = "150";
      rule2.innerHTML = "12";
      rule3.innerHTML = "30";
      break;
    case '3' :
      rule1.innerHTML = "200";
      rule2.innerHTML = "15";
      rule3.innerHTML = "40";
      break;
  }
}

function recupID() {//On récupère l'ID actif dans le carousel 
  var levelCarousel = document.getElementById('carouselLevelControls');
  var levelCarouselActiveArray = levelCarousel.getElementsByClassName('carousel-item');
  var levelCarouselActive;
  for (var j = 0 ; j < levelCarouselActiveArray.length ; j++) {
    if (levelCarouselActiveArray[j].classList.contains("active")) {
      levelCarouselActive = levelCarouselActiveArray[j];
    }
  };
  level = levelCarouselActive.querySelector('input');
  return(level.id[level.id.length-1]);
}
