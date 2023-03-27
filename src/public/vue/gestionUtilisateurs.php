<!-- 
    Projet : FindCar
    Auteur : Liliana Santos
    Date : 07.03.2023
 -->
<?php
/* Inclus les fichiers BDD.php et navbarFooter.php */
require_once("../model/BDD.php");


/* Récupère tous les utilisateurs de la base de données. */
$utilisateurs = GetUSers();

/* Obtenir les valeurs du formulaire. */
$submitSearchBar = filter_input(INPUT_POST, 'searchBar', FILTER_SANITIZE_SPECIAL_CHARS);
$rechercheUtilisateur = filter_input(INPUT_POST, 'rechercherUtilisateur', FILTER_SANITIZE_SPECIAL_CHARS);
$delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
$activerDesactiver = filter_input(INPUT_POST, 'activerDesactiver', FILTER_SANITIZE_SPECIAL_CHARS);
$idUser = filter_input(INPUT_POST, 'idUtilisateur', FILTER_SANITIZE_SPECIAL_CHARS);
$status = filter_input(INPUT_POST, 'statusUser', FILTER_SANITIZE_SPECIAL_CHARS);


/* Supprime un utilisateur de la base de données. */
if (isset($delete)) {
    deleteUtilisateur($idUser);
    header("Refresh:0");
}

/* Changer le statut d'un utilisateur. */
if (isset($activerDesactiver)) {

    if ($status == "Actif") {
        $status = "Suspendu";
        $update = updateStatus($status, $idUser);
        header("Refresh:0");
    } else {
        $status = "Actif";
        $update = updateStatus($status, $idUser);
        header("Refresh:0");
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

    <form method="POST">
        <div class="row mt-5">
            <div class="col-md-5 mx-auto">
                <label for="rechercherUtilisateur">Rechercher un email :</label>
                <div class="input-group rounded mt-3 mx-auto">
                    <input type="search" name="rechercherUtilisateur" class="form-control rounded "
                        placeholder="Recherche" aria-label="Search" aria-describedby="search-addon">
                    <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                </div>

            </div>
        </div>
    </form>
    <div class="container-xl mt-4">
        <div class="table-responsive">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Numéro de permis </th>
                            <th>Date de naissance</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /* Vérifie si la barre de recherche est pas vide. */
                        if ($rechercheUtilisateur != "") {
                            /* Recherche l'utilisateur dans la base de données. */
                            $searchUtilisateur = searchUtilisateur($rechercheUtilisateur);

                            /* Vérifie si le résultat de la recherche n'est pas vide. */
                            if ($searchUtilisateur != null) {
                                /*Affichage des resultats de la barre de recherche*/
                                foreach ($searchUtilisateur as $utilisateurRecherche) { ?>

                                    <tr>
                                        <td>
                                            <?= $utilisateurRecherche['Email'] ?>
                                        </td>
                                        <td>
                                            <?= $utilisateurRecherche['NbPermis'] ?>
                                        </td>
                                        <td>
                                            <?= $utilisateurRecherche['Date'] ?>
                                        </td>
                                        <td>
                                            <?= $utilisateurRecherche['Admin'] ?>
                                        </td>
                                        <td>
                                            <?php if ($utilisateurRecherche['Actif'] == "Actif") { ?>

                                                <span class="status text-success">&bull;</span>
                                                <?= $utilisateurRecherche['Actif'] ?>

                                            <?php } else { ?>
                                                <span class="status text-danger">&bull;</span>
                                                <?= $utilisateurRecherche['Actif'] ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <form action="#" method="post">
                                                <button type="submit" class="border-0" name="activerDesactiver">
                                                    <i class="fa-solid fa-user-pen text-primary"></i>
                                                </button>
                                                <button class="border-0" type="submit" name="delete">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                                <input type="hidden" name="idUtilisateur"
                                                    value="<?= $utilisateurRecherche['IdUtilisateur'] ?>">
                                                <input type="hidden" name="statusUser"
                                                    value="<?= $utilisateurRecherche['Actif'] ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <p class="rechercheJeu">Aucun resultat</p>
                            <?php }
                        } /* Vérifier si la barre de recherche est vide. */
                        else if ($rechercheUtilisateur == "") {
                            /*Affichage des utilisateurs*/
                            foreach ($utilisateurs as $utilisateur) { ?>

                                    <tr>
                                        <td>
                                        <?= $utilisateur['Email'] ?>
                                        </td>
                                        <td>
                                        <?= $utilisateur['NbPermis'] ?>
                                        </td>
                                        <td>
                                        <?= $utilisateur['Date'] ?>
                                        </td>
                                        <td>
                                        <?= $utilisateur['Admin'] ?>
                                        </td>
                                        <td>
                                        <?php if ($utilisateur['Actif'] == "Actif") { ?>

                                                <span class="status text-success">&bull;</span>
                                            <?= $utilisateur['Actif'] ?>

                                        <?php } else { ?>
                                                <span class="status text-danger">&bull;</span>
                                            <?= $utilisateur['Actif'] ?>
                                        <?php } ?>
                                        </td>
                                        <td>
                                            <form action="#" method="post">
                                                <button type="submit" class="border-0" name="activerDesactiver">
                                                    <i class="fa-solid fa-user-pen text-primary"></i>
                                                </button>
                                                <button class="border-0" type="submit" name="delete">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                                <input type="hidden" name="idUtilisateur"
                                                    value="<?= $utilisateur['IdUtilisateur'] ?>">
                                                <input type="hidden" name="statusUser" value="<?= $utilisateur['Actif'] ?>">
                                            </form>
                                        </td>
                                    </tr>

                            <?php }
                        } ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>