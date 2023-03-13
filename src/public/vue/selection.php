<?php
require("../model/BDD.php");
session_start();
$arrayCarburant = getCarburant();
$arrayTransmission = getTransmission();

$rechercher = filter_input(INPUT_POST, 'apliquerFiltre', FILTER_SANITIZE_SPECIAL_CHARS);

$dateRetour = new DateTime($_SESSION['dateRetour']);
$dateDepart = new DateTime($_SESSION['dateDepart']);
$nbJour = $dateRetour->diff($dateDepart);

if ($rechercher = "Rechercher") {

  $filtreCarburant = filter_input(INPUT_POST, 'carburant', FILTER_SANITIZE_SPECIAL_CHARS);
  $filtrePrixJour = filter_input(INPUT_POST, 'prixJour', FILTER_SANITIZE_SPECIAL_CHARS);
  $filtreTransmission = filter_input(INPUT_POST, 'transmission', FILTER_SANITIZE_SPECIAL_CHARS);

  $arrayVehiculeByFilter = filterPageSelection($filtreCarburant, $filtrePrixJour, $filtreTransmission);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://kit.fontawesome.com/865258096d.js" crossorigin="anonymous"></script>
  <title>selection</title>
</head>

<body>

  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="./index.php">
        <img src="../../assets/images/LogoMiniNom-removebg-preview.png" alt="" width="150" height="50">
      </a>
      <a class="d-flex" href="./connexion.php">
        <i class="fa-solid fa-user"></i>
      </a>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
          <form action="#" method="post">
            <legend>Type de carburant</legend>
            <div class="form-check">
              <?php foreach ($arrayCarburant as $carburant) { ?>
                <input class="form-check-input" name="carburant" type="checkbox"
                  value="<?= $carburant['typeCarburant'] ?>" id="<?= $carburant['IdCarburant'] ?>"><?= $carburant['typeCarburant'] ?><br>
              <?php } ?>
            </div>

            <legend>Prix par jour</legend>
            <div class="form-group mt-3">

              <input class="form-control" type="number" name="prixJour" id="prixJour" min="0" max="300">

            </div>

            <legend>Transmission</legend>
            <div class="form-check">
              <?php foreach ($arrayTransmission as $transmission) { ?>
                <input class="form-check-input" name="transmission" type="checkbox"
                  value="<?= $transmission['typeTransmission'] ?>" id="<?= $transmission['IdTransmission'] ?>"><?= $transmission['typeTransmission'] ?><br>
              <?php } ?>
            </div>
            <input type="submit" name="apliquerFiltre" id="apliquerFiltre" value="Rechercher"
              class="btn btn-primary mt-5 float-end">
          </form>
        </div>
      </div>
      <div class="col py-3">
        <section style="background-color: #eee;">
          <?php if (!empty($arrayVehiculeByFilter)) {
            foreach ($arrayVehiculeByFilter as $vehicules) { ?>
              <div class="container py-5">
                <div class="row justify-content-center mb-3">
                  <div class="col-md-12 col-xl-10">
                    <div class="card shadow-0 border rounded-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                            <div class="bg-image hover-zoom ripple rounded ripple-surface">
                              <?php echo '<img  class="w-100" src="data:image/jpeg;base64,' . base64_encode($vehicules['imageVoiture']) . '"/>'; ?>
                              <a href="#!">
                                <div class="hover-overlay">
                                  <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                </div>
                              </a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-6 col-xl-6">
                            <h5>
                              <?= $vehicules['Marque'] . " " . $vehicules['nomVehicule'] ?>
                            </h5>

                            <div class="mt-1 mb-0 text-muted small">
                              <span>
                                <?= $vehicules['typeTransmission'] ?>
                              </span>
                              <span class="text-primary"> • </span>
                              <span>Nombres de places :
                                <?= $vehicules['nbPlace'] ?>
                              </span>
                              <span class="text-primary"> • </span>
                              <span>Nombres de portes :
                                <?= $vehicules['NbPorte'] ?>
                              </span>
                              <span class="text-primary"> • </span>
                              <span>
                                <?= $vehicules['typeCarburant'] ?>
                              </span>
                            </div>
                          </div>

                        </div>
                          <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                            <div class="d-flex flex-row align-items-center mb-1">
                              <h4 class="mb-1 me-1">
                                <?= $vehicules['prixJour'] ?> CHF/Jour
                              </h4>
                              <h4 class="mb-1 me-1">
                                <?= $vehicules['prixJour']?> CHF/Total
                              </h4>
                            </div>


                            <div class="d-flex flex-column mt-4">
                              <button class="btn btn-primary btn-sm" type="button">Sélectionner -></button>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }
          } else {
            foreach ($_SESSION['arrayVehicules'] as $vehicule) { ?>
                <div class="container py-5">
                  <div class="row justify-content-center mb-3">
                    <div class="col-md-12 col-xl-10">
                      <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                              <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                <?php echo '<img  class="w-100" src="data:image/jpeg;base64,' . base64_encode($vehicule['imageVoiture']) . '"/>'; ?>
                                <a href="#!">
                                  <div class="hover-overlay">
                                    <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                  </div>
                                </a>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6">
                              <h5>
                                <?= $vehicule['Marque'] . " " . $vehicule['nomVehicule'] ?>
                              </h5>

                              <div class="mt-1 mb-0 text-muted small">
                                <span>
                                  <?= $vehicule['typeTransmission'] ?>
                                </span>
                                <span class="text-primary"> • </span>
                                <span>Nombres de places :
                                  <?= $vehicule['nbPlace'] ?>
                                </span>
                                <span class="text-primary"> • </span>
                                <span>Nombres de portes :
                                  <?= $vehicule['NbPorte'] ?>
                                </span>
                                <span class="text-primary"> • </span>
                                <span>
                                  <?= $vehicule['typeCarburant'] ?>
                                </span>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                              <div class="d-flex flex-row align-items-center mb-1">
                                <h4 class="mb-1 me-1">
                                  <?= $vehicule['prixJour'] ?> CHF/Jour
                                </h4>
                                <h4 class="mb-1 me-1">
                                  <?= $vehicule['prixJour']?> CHF/Total
                                </h4>
                              </div>

                              <div class="d-flex flex-column mt-4">
                                <button class="btn btn-primary btn-sm" type="button">Sélectionner -></button>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }
          } ?>
        </section>
      </div>
    </div>
  </div>
</body>
<footer class="text-center text-white fixed-bottom bg-dark">

  <div class="container p-4">
    <img src="../../assets/images/LogoMiniNom-removebg-preview.png" width="150" height="50">
  </div>
  <section class="mb-4">
    <!-- Facebook -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

    <!-- Twitter -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

    <!-- Google -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

    <!-- Instagram -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

    <!-- Linkedin -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

    <!-- Github -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
  </section>
  <div class="text-center p-3 bg-dark">
    © 2020 Copyright:
    <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>
</footer>

</html>