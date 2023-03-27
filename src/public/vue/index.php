<!-- 
    Projet : FindCar
    Auteur : Ania Marostica, Liliana Santos
    Date : 20.02.2023
 -->
 <?php
require("../model/BDD.php");
require("./navbarFooter.php");

$arrayLocation = getInfoLocation();
$arrayType = getInfoType();

$lieuDepartRetour = filter_input(INPUT_POST, 'lieuDepartRetour');
$dateDepart = filter_input(INPUT_POST, 'dateDepart');
$dateRetour = filter_input(INPUT_POST, 'dateRetour');
$type = filter_input(INPUT_POST, 'typeVehicule');

if (isset($_POST['rechercher'])) {
    $_SESSION['arrayVehicules'] = GetVehiculeByFiltre($type, $lieuDepartRetour, $dateDepart, $dateRetour);
    $_SESSION['lieu']=$lieuDepartRetour;
    $_SESSION['dateDepart'] = $dateDepart;
    $_SESSION['dateRetour'] = $dateRetour;
    header("location:selection.php");

}
?>
<!DOCTYPE html>
<html lang="fr">

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
    <title>Accueil</title>
</head>

<body>
    <div class="container mt-5">
        <form method="POST">
            <div class="col-sm-12 selectVehicle">
                <p>
                    Quel type de véhicule ?
                </p>

                <div class="btn-group mb-3" role="group" aria-label="Basic example">

                    <select class="form-control" name="typeVehicule" id="typeVehicule-select">
                        <option value="">--Choissisez une option--</option>
                        <?php foreach ($arrayType as $type) { ?>
                            <option value="<?= $type['IdType'] ?>"><?= $type['Type'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="lieuDepart">Lieu de départ et de retour :</label>
                    <select class="form-control" name="lieuDepartRetour" id="depart/retour-select" required>
                        <option value="">--Choissisez une option--</option>
                        <?php foreach ($arrayLocation as $location) { ?>
                            <option value="<?= $location['IdLocalisation'] ?>"><?= $location['Nom'] ?></option>
                        <?php } ?>
                    </select>


                </div>

            </div>
            <div class="row mt-3">
                <div class="col">

                    <label for="email">Date de départ :</label>
                    <input type="date" name="dateDepart" id="date" placeholder="Date de naissance "
                        class="form-control" required>
                </div>
                <div class="col">
                    <label for="email">Date de retour :</label>
                    <input type="date" name="dateRetour" id="date" placeholder="Date de naissance "
                        class="form-control" required>
                </div>
            </div>
            <div>
                <input class="btn btn-primary mt-3 float-end" name="rechercher" type="submit" value="Rechercher">
            </div>
        </form>
    </div>

</body>

</html>