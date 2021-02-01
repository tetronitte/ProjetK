var startGame = document.getElementById('startGame');
var url = "../html/jeu.html?"
var themeURL = "theme=";
var levelURL = "level=";
var theme;
var level;

startGame.onclick = function() {
  selectVariable();
  setTheme();
  setLevel();
  window.location.assign(url+themeURL+"&"+levelURL);//On créer l'URL du jeu et on lance la page
  return false;
  };

function selectVariable() {
  var themeCarousel = document.getElementById('carouselThemeControls');//On récupère le carousel des thèmes
  var levelCarousel = document.getElementById('carouselLevelControls');
  var themeCarouselActiveArray = themeCarousel.getElementsByClassName('carousel-item');//On récupère les éléments du carousel
  var levelCarouselActiveArray = levelCarousel.getElementsByClassName('carousel-item');
  var themeCarouselActive;
  var levelCarouselActive;

  for (var i = 0 ; i < themeCarouselActiveArray.length ; i++) {//On récupère l'élément actif du carousel
    if (themeCarouselActiveArray[i].classList.contains("active")) {
        themeCarouselActive = themeCarouselActiveArray[i];
      }
  };

  for (var j = 0 ; j < levelCarouselActiveArray.length ; j++) {
    if (levelCarouselActiveArray[j].classList.contains("active")) {
      levelCarouselActive = levelCarouselActiveArray[j];
    }
  };
  theme = themeCarouselActive.querySelector('input');//On récupère le radio dans l'élément actif du carousel
  level = levelCarouselActive.querySelector('input');
}

function setTheme() {
  themeURL += theme.id;
}

function setLevel() {
  var id = level.id;
  levelURL += id[id.length-1];
}
