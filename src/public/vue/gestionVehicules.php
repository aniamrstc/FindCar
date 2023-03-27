<!-- 
    Projet : FindCar
    Auteur : Ania Marostica
    Date : 07.03.2023
 -->
<?php
/* Inclus les fichiers BDD.php et navbarFooter.php */
require("../model/BDD.php");
require("./navbarFooter.php");

/* Récupère tous les voitures de la base de données. */
$arrayVehicule = getAllVehicule();

/* Obtenir les valeurs du formulaire. */
$idVehicule = filter_input(INPUT_POST, 'idVehicule');
$search = filter_input(INPUT_POST, 'search');

/* Supprime un véhicule de la base de données. */
if (isset($_POST['supprimer'])) {
  deleteVehicule($idVehicule);
  header("refresh:0");
}

/* Vérifier si le bouton modifier est cliqué. S'il est cliqué, il définira la session idVehicule
sur l'idVehicule et redirigera vers la page modificationVehicule.php. */
if (isset($_POST['modifier'])) {

  $_SESSION['idVehicule'] = $idVehicule;
  header("location:modificationVehicule.php");
}

/* Redirection vers la page AjoutVehicules.php. */
if (isset($_POST['ajouter'])) {

  header("location:AjoutVehicules.php");
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
  <title>Gestion Véhicules</title>
</head>

<body>
  <div class="w-100 ">
    <form method="POST">
      <div class="input-group rounded mt-3 w-50 mx-auto">
        <input type="search" name="search" class="form-control rounded " placeholder="Search" aria-label="Search"
          aria-describedby="search-addon" />
        <span class="input-group-text border-0" id="search-addon">
          <i class="fas fa-search"></i>
        </span>
      </div>
    </form>
    <form method="POST">
      <input class="btn btn-primary ml-5" type="submit" name="ajouter" id="ajouter" value="Ajouter un vehicule">
    </form>
    <?php
     /* Vérifier si le champ de recherche est pas vide. */
    if ($search != "") {
      /* Recherche la voiture dans la base de données. */
      $Recherche = searchCar($search);

      /* Vérifier si le champ de recherche est vide. */
      if ($search != null) { ?>
        <div class="card-group">
          <?php
          /*Affichage de voitures selon le données de la barre de recherche*/
          foreach ($Recherche as $uneRecherche) { ?>
            <form method="POST">

              <div class="card m-5" style="width: 18rem;">
                <?php echo '<img  class="w-100 card-img-top" src="data:image/jpeg;base64,' . base64_encode($uneRecherche['imageVoiture']) . '"/>'; ?>
                <div class="card-body">
                  <h5 class="card-title">
                    <?= $uneRecherche['nomVehicule'] ?>
                  </h5>
                  <input type="hidden" name="idVehicule" value="<?= $uneRecherche['IdVehicule'] ?>">

                  <input class="btn btn-primary" type="submit" name="modifier" id="modifier" value="Modifier">
                  <input class="btn btn-danger" type="submit" name="supprimer" id="supprimer" value="Supprimer">
                </div>
              </div>
            </form>

          <?php } ?>
        </div>
        <?php
      }
      ?>

    <?php } 
    /* Si la barre de recherche est vide, on affiche toutes les voitures*/
    else { ?>
      <div class="card-group">

        <?php foreach ($arrayVehicule as $vehicule) { ?>
          <form method="POST">

            <div class="card m-5" style="width: 18rem;">
              <?php echo '<img  class="w-100 card-img-top" src="data:image/jpeg;base64,' . base64_encode($vehicule['imageVoiture']) . '"/>'; ?>
              <div class="card-body">
                <h5 class="card-title">
                  <?= $vehicule['nomVehicule'] ?>
                </h5>
                <input type="hidden" name="idVehicule" value="<?= $vehicule['IdVehicule'] ?>">

                <input class="btn btn-primary" type="submit" name="modifier" id="modifier" value="Modifier">
                <input class="btn btn-danger" type="submit" name="supprimer" id="supprimer" value="Supprimer">
              </div>
            </div>
          </form>
        <?php }
    } ?>
    </div>
  </div>
</body>

</html>