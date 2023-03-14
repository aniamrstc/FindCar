<?php
require("../model/BDD.php");
require("./navbarFooter.php");

$arrayCarburant = getCarburant();
$arrayTransmission = getTransmission();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://kit.fontawesome.com/865258096d.js" crossorigin="anonymous"></script>
    <title>Ajouter Véhicule</title>
</head>

<body>   
    <div class="card-body p-4 p-md-5 ">
        <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Ajouter Véhicule</h2>

        <form method="POST" class="px-md-2" style="margin:50px 150px">
            <div class="form-outline mb-4">
                <input type="text" name="NomVehicule" id="NomVehicule" placeholder="Nom Véhicule" class="form-control mb-3" required>

                <input type="number" name="prix" id="prix" placeholder="Prix Véhicule" class="form-control mb-3">

                <textarea name="Description" id="Description" cols="30" rows="10" class="form-control mb-3"></textarea>


                <input type="file" name="image" id="image" placeholder="image du véhicule" class="form-control mb-3">

                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <select class="form-control" name="transmission" id="transmission-select">
                            <option value="">--Choissisez une trasnmission--</option>
                            <?php foreach ($arrayTransmission as $transmission) { ?>
                                <option value="<?= $transmission['IdTransmission'] ?>"><?= $transmission['typeTransmission'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <select class="form-control" name="carburant" id="carburant-select">
                            <option value="">--Choissisez un carburant--</option>
                            <?php foreach ($arrayCarburant as $carburant) { ?>
                                <option value="<?= $carburant['IdCarburant'] ?>"><?= $carburant['typeCarburant'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-outline mb-4 d-flex justify-content-center align-items-center">
                <input type="submit" name="ajouter" id="ajouter" value="Ajouter" class="col-8 btn btn-primary">
            </div>

        </form>
    </div>
</body>
</html>