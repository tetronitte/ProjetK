<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quizz</title>
    <link href="assets/css/font-awesome/css/all.min.css?ver=1.2.0" rel="stylesheet">
    <link href="assets/css/bootstrap.css?ver=1.2.0" rel="stylesheet">
    <link href="assets/css/aos.css?ver=1.2.0" rel="stylesheet">
    <link href="assets/css/main.css?ver=1.2.0" rel="stylesheet">
    <noscript>
      <style>
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
  </head>
  <body>
  <!-- Début de la navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <img src="assets/images/logo.svg" width="32px" height="32px" class="ms-5" alt="Logo du site quizz"><a href="#" class="logo-image border-text text-white"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <form action="action.php" method="post">
        <div class="collapse navbar-collapse me-5 py-2" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active">
              <a class="nav-link text-white border-text me-3 py-1" href="#">Se connecter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white border-bg px-4 py-1 " href="#">S'enregistrer</a>
            </li>
          </ul>
        </div>
      </form>
    </div>
  </nav>
  <!-- Fin de la navbar -->
  <!-- Début container -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 main text-center">
        <h1 class="mt-2 title-decoration">Choisir un sujet</h1>
      </div>
    </div>

    <div class="row justify-content-center d-flex align-items-center">
      <div class="col-2 page-prev me-3 bg-dark align-bottom d-flex align-items-center">
        <div>
          <i class="fas fa-chevron-left fa-fw" aria-hidden="true" style="color: white;" aria-hidden="true"></i>
        </div>
      </div> 
      <div class="col-9 text-center">
        <div class="row gx-1 gy-2">
          <div class="col-8">
          <div class="p-3">
            <div class="row ms-4 gx-4">
              <div class="col-6">
                <div class="mt-4 box-brown text-center-div">Histoire</div>
              </div>
              <div class="col-6">
                <div class="box-light-blue text-center-div">Science</div>
              </div>
            </div>
          </div>
          </div>
          <div class="col-4">
            <div>
              <div class="row mt-4 gy-4">
                <div class="col-12">
                <div class="box-grey text-center-div">Techno</div>
                </div>
                <div class="col-12">
                  <div class="box-dark-blue text-center-div">Géo</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 gx-5">
            <div class="box-green text-center-div">Nature</div>
          </div>
        </div>
      </div>
      <div class="col-2 ms-2 page-suiv bg-dark d-flex align-items-center">
        <div>
          <i class="fas fa-chevron-right fa-fw" aria-hidden="true" style="color: white;"></i>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-6 bg-diff">
        <div class="text-center text-center-create">-> Choisir la <span id="difficulty">difficulté</span> :</div>
      </div>
      <div class="col-12">
        <div class="text-center text-center-create"></div>
      </div>
    </div>
  </div>
    <script src="assets/scripts/bootstrap.bundle.js?ver=1.2.0"></script>
    <script src="assets/scripts/aos.js?ver=1.2.0"></script>
    <script src="assets/scripts/main.js?ver=1.2.0"></script>
  </body>
</html>