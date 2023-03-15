<?php
require("../model/BDD.php");
require("./navbarFooter.php");

// https://bbbootstrap.com/snippets/bootstrap-5-vehicle-features-payment-details-36075039

$vehicules = getVehiculeById($_SESSION['idVehiculeSelection']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume et paiement</title>
</head>

<body>
    <div class="container">
        <div class="row ">
            <div class="col-lg-7 pb-5 pe-lg-5">
                <div class="row">
                    <?php
                    foreach ($vehicules as $vehicule) { ?>
                        <div class="col-12 p-5 w-75">
                            <?php echo '<img  class="w-100" src="data:image/jpeg;base64,' . base64_encode($vehicule['imageVoiture']) . '"/>'; ?>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-4 col-6 ps-30 pe-0 my-4">
                                <p class="text-muted">Marque</p>
                                <p class="h5"><?=$vehicule['Marque']?></p>
                            </div>
                            <div class="col-md-4 col-6 ps-30 my-4">
                                <p class="text-muted">Modele</p>
                                <p class="h5 m-0"><?=$vehicule['nomVehicule']?></p>
                            </div>
                            <div class="col-md-4 col-6 ps-30 my-4">
                                <p class="text-muted">Transmission</p>
                                <p class="h5 m-0"><?=$vehicule['typeTransmission']?></p>
                            </div>
                            <div class="col-md-4 col-6 ps-30 my-4">
                                <p class="text-muted">Carburant</p>
                                <p class="h5 m-0"><?=$vehicule['typeCarburant']?></p>
                            </div>
                            <div class="col-md-4 col-6 ps-30 my-4">
                                <p class="text-muted">Lieu et date de départ</p>
                                <p class="h5 m-0"><?=$vehicule['Nom']."<br>".$_SESSION['dateDepart']?></p>
                            </div>
                            <div class="col-md-4 col-6 ps-30 my-4">
                                <p class="text-muted">Lieu et date de retour</p>
                                <p class="h5 m-0"><?=$vehicule['Nom']."<br>".$_SESSION['dateRetour']?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-5 p-0 ps-lg-4">
                <div class="row m-0">
                    <div class="col-12 px-0">
                        <div class="row bg-light m-0 mt-5">
                            <div class="col-12 px-4 my-4">
                                <p class="fw-bold">Paiement</p>
                            </div>
                            <div class="col-12 px-4">
                                <div class="d-flex  mb-4">
                                    <span class="">
                                        <p class="text-muted">Numéro de la carte</p>
                                        <input class="form-control" type="text" placeholder="1234 5678 9012 3456">
                                    </span>
                                    <div class=" w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">Date d'expiration</p>
                                        <input class="form-control2" type="text"  placeholder="MM/YYYY">
                                    </div>
                                </div>
                                <div class="d-flex mb-5">
                                    <span class="me-5">
                                        <p class="text-muted">Nom du titulaire</p>
                                        <input class="form-control" type="text" placeholder="Nom">
                                    </span>
                                    <div class="w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">CVC</p>
                                        <input class="form-control3" type="text" placeholder="XXX">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0 mt-2 float-end">
                            <div class="col-12  mb-4 p-0">
                                <div class="btn btn-primary">Payer<span class="fas fa-arrow-right ps-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>