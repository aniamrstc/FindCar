<?php
require("../model/BDD.php");
require("./navbarFooter.php");

$utilisateurs = GetUSers();
$submitSearchBar = filter_input(INPUT_POST, 'searchBar', FILTER_SANITIZE_SPECIAL_CHARS);
$rechercheUtilisateur = filter_input(INPUT_POST, 'rechercherUtilisateur', FILTER_SANITIZE_SPECIAL_CHARS);
$delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
$activerDesactiver = filter_input(INPUT_POST, 'activerDesactiver', FILTER_SANITIZE_SPECIAL_CHARS);
$idUser = filter_input(INPUT_POST, 'idUtilisateur', FILTER_SANITIZE_SPECIAL_CHARS);
$status = filter_input(INPUT_POST, 'statusUser', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($delete)) {
    deleteUtilisateur($idUser);
    header("Refresh:0");
}

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
                <div class="input-group">

                    <input id="search" class="border-0 rounded shadow" type="Search" placeholder="Recherche"
                        name="rechercherUtilisateur">

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
                        if ($rechercheUtilisateur != "") {
                            $searchUtilisateur = searchUtilisateur($rechercheUtilisateur);
                            if ($searchUtilisateur != null) {
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
                        } else if ($rechercheUtilisateur == "") {
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
                <!-- <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#">Previous</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item active"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link">Next</a></li>
                        </ul>
                    </div> -->
            </div>
        </div>
    </div>

</body>

</html>