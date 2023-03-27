<!-- 
    Projet : FindCar
    Auteur : Ania Marostica
    Date : 07.03.2023
 -->
 <?php
/* Inclus les fichiers BDD.php et navbarFooter.php */
require_once("../model/BDD.php");


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
$transmission = filter_input(INPUT_POST, 'transmission');
$carburant = filter_input(INPUT_POST, 'carburant');
$type = filter_input(INPUT_POST, 'type');
$location = filter_input(INPUT_POST, 'location');
$nbPlace = filter_input(INPUT_POST, 'nbPlace');
$nbPorte = filter_input(INPUT_POST, 'nbPorte');
$marque = filter_input(INPUT_POST, 'marque');

/* Initialisation des variables erreur et succes */
$erreur = [];
$succes = "";


/* Vérifier si le formulaire a été soumis. */
if (isset($_POST['ajouter'])) {

    /* Obtenir le nom temporaire de l'image. */
    $image = $_FILES['image']['tmp_name'];

    /* Vérifier si tous les champs sont remplis. */
    if ($nom != "" && $prix != "" && $nbPlace != "" && $transmission != "" && $image != "" && $carburant != "" && $nbPorte != "" && $marque != "" && $location != "" && $type != "") {
       /* Obtenir le contenu du fichier. */
        $img = file_get_contents($image);

        /* Insere un nouveau véhicule */
        if (newVehicule($nom, $prix, $img, $nbPlace, $transmission, $carburant, $nbPorte, $marque, $location, $type)==true) {
          
            $succes = "La voiture a bien été ajouté";
        }
    
    } else {
        $erreur[] = "Vous devez remplir tous les champs ";
    }
}
require("./navbarFooter.php");
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
        <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Ajouter véhicule</h2>

        <form method="POST" class="px-md-2" style="margin:50px 150px" enctype="multipart/form-data">
            <div class="form-outline mb-4">
                <input type="text" name="NomVehicule" id="NomVehicule" placeholder="Nom Véhicule" class="form-control mb-3" required>

                <input type="number" name="prix" id="prix" placeholder="Prix Véhicule" class="form-control mb-3">
                <input type="file" name="image" id="image" placeholder="image du véhicule" class="form-control mb-3" accept="image/*">

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
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <select class="form-control" name="type" id="type-select">
                            <option value="">--Choissisez un type de vehicule--</option>
                            <?php foreach ($arrayType as $type) { ?>
                                <option value="<?= $type['IdType'] ?>"><?= $type['Type'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <select class="form-control" name="location" id="location-select">
                            <option value="">--Choissisez une localisation--</option>
                            <?php foreach ($arrayLocation as $location) { ?>
                                <option value="<?= $location['IdLocalisation'] ?>"><?= $location['Nom'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <select class="form-control" name="nbPlace" id="nbPlace-select">
                            <option value="">--Choissisez un nombre de place--</option>
                            <?php foreach ($arrayPlace as $place) { ?>
                                <option value="<?= $place['IdNbPlaces'] ?>"><?= $place['nbPlace'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <select class="form-control" name="nbPorte" id="nbPorte-select">
                            <option value="">--Choissisez un nombre de porte--</option>
                            <?php foreach ($arrayPorte as $porte) { ?>
                                <option value="<?= $porte['IdNbPorte'] ?>"><?= $porte['NbPorte'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <select class="form-control" name="marque" id="marque-select">
                            <option value="">--Choissisez une marque--</option>
                            <?php foreach ($arrayMarque as $marque) { ?>
                                <option value="<?= $marque['IdMarque'] ?>"><?= $marque['Marque'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-outline mb-4 d-flex justify-content-center align-items-center">
                <input type="submit" name="ajouter" id="ajouter" value="Ajouter" class="col-8 btn btn-primary">
            </div>

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
