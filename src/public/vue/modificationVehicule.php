<!-- 
    Projet : FindCar
    Auteur : Ania Marostica
    Date : 06.03.2023
 -->
 <?php
  /* Inclus les fichiers BDD.php et navbarFooter.php */
require("../model/BDD.php");
require("./navbarFooter.php");

$arrayVehiculeById = getVehiculeById($_SESSION['idVehicule']);

/* Obtient les données de la base de données. */
$arrayCarburant = getCarburant();
$arrayTransmission = getTransmission();
$arrayLocation = getInfoLocation();
$arrayType = getInfoType();
$arrayPlace = getNbplaces();
$arrayPorte = getNbPorte();
$arrayMarque = getMarque();

/* Obtenir les valeurs du formulaire. */
$nom = filter_input(INPUT_POST, 'NomVehicule');
$prix = filter_input(INPUT_POST, 'prix');
$marque = filter_input(INPUT_POST, 'marque');
$transmission = filter_input(INPUT_POST, 'transmission');
$carburant = filter_input(INPUT_POST, 'carburant');
$type = filter_input(INPUT_POST, 'type');
$location = filter_input(INPUT_POST, 'location');
$nbPlace = filter_input(INPUT_POST, 'nbPlace');
$nbPorte = filter_input(INPUT_POST, 'nbPorte');

/* Initialisation des variables erreur et succes */
$erreur = [];
$succes = "";

/* Vérifier si le bouton "modifier" a été cliqué. */
if (isset($_POST['modifier'])) {

    foreach ($arrayVehiculeById as $vehiculebyid) {
        /* Vérifier si l'utilisateur a modifié la valeur de la sélection. Sinon, il conservera
        l'ancienne valeur.*/
        if ($transmission == "") {
            $transmission = $vehiculebyid['IdTransmission'];
        }
        if ($nbPlace == "") {
            $nbPlace = $vehiculebyid['IdNbPlaces'];
        }
        if ($carburant == "") {
            $carburant = $vehiculebyid['IdCarburant'];
        }
        if ($type == "") {
            $type = $vehiculebyid['IdType'];
        }
        if ($location == "") {
            $location = $vehiculebyid['IdLocalisation'];
        }
        if ($nbPorte == "") {
            $nbPorte = $vehiculebyid['IdNbPortes'];
        }
        if ($marque == "") {

            $marque = $vehiculebyid['IdMarque'];
        }
    }

   /* Mise à jour du véhicule. */
    if (updateVehicule($nom, $prix, $nbPlace, $transmission, $carburant, $nbPorte, $marque, $location, $type, $_SESSION['idVehicule']) == true) {
        $arrayVehiculeById = getVehiculeById($_SESSION['idVehicule']);
        $succes = "Le vehicule a bien été modifié";
    }
}
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
    <title>Document</title>
</head>

<body>
    <div class="card-body p-4 p-md-5 ">
        <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Modifier un véhicule</h2>

        <form method="POST" class="px-md-2" style="margin:50px 150px" enctype="multipart/form-data">
            <?php foreach ($arrayVehiculeById as $vehiculebyid) { ?>
                <div class="form-outline mb-4">
                    <input type="text" name="NomVehicule" id="NomVehicule" placeholder="Nom Véhicule" class="form-control mb-3" required value="<?= $vehiculebyid['nomVehicule'] ?>">

                    <input type="number" name="prix" id="prix" placeholder="Prix Véhicule" class="form-control mb-3" value="<?= $vehiculebyid['prixJour'] ?>">


                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <select class="form-control" name="transmission" id="transmission-select">
                                <option selected disabled value="<?= $vehiculebyid['IdTransmission'] ?>"><?= $vehiculebyid['typeTransmission'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayTransmission as $transmission) { ?>
                                    <option value="<?= $transmission['IdTransmission'] ?>"><?= $transmission['typeTransmission'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="carburant" id="carburant-select">
                                <option selected disabled value=""><?= $vehiculebyid['typeCarburant'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayCarburant as $carburant) { ?>
                                    <option value="<?= $carburant['IdCarburant'] ?>"><?= $carburant['typeCarburant'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <select class="form-control" name="type" id="type-select">
                                <option selected disabled value=""><?= $vehiculebyid['Type'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayType as $type) { ?>
                                    <option value="<?= $type['IdType'] ?>"><?= $type['Type'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="location" id="location-select">
                                <option selected disabled value=""><?= $vehiculebyid['Nom'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayLocation as $location) { ?>
                                    <option value="<?= $location['IdLocalisation'] ?>"><?= $location['Nom'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <select class="form-control" name="nbPlace" id="nbPlace-select">
                                <option selected disabled value=""><?= $vehiculebyid['nbPlace'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayPlace as $place) { ?>
                                    <option value="<?= $place['IdNbPlaces'] ?>"><?= $place['nbPlace'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="nbPorte" id="nbPorte-select">
                                <option selected disabled value=""><?= $vehiculebyid['NbPorte'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayPorte as $porte) { ?>
                                    <option value="<?= $porte['IdNbPorte'] ?>"><?= $porte['NbPorte'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <select class="form-control" name="marque" id="marque-select">
                                <option selected disabled value=""><?= $vehiculebyid['Marque'] ?></option>
                                <option disabled value="">---------------</option>
                                <?php foreach ($arrayMarque as $marque) { ?>
                                    <option value="<?= $marque['IdMarque'] ?>"><?= $marque['Marque'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4 d-flex justify-content-center align-items-center">
                    <input type="submit" name="modifier" id="modifier" value="Modifier" class="col-8 btn btn-primary">
                </div>
            <?php } ?>
        </form>
        <?php
        if (!empty($erreur)) {
            if ($erreur != 0) { ?>
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="alert alert-danger w-50 mt-3 col-12 text-center" role="alert">
                        <?php
                        foreach ($erreur as $messageError) {
                            echo $messageError;
                        }

                        ?>
                    </div>
                </div>
            <?php }
        }
        if (!empty($succes)) {
            if ($succes != 0) {
            ?>
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="alert alert-success w-50 mt-3 col-12 text-center" role="alert">
                        <?php echo $succes; ?>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>