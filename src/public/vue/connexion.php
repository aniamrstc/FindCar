<!-- 
    Projet : FindCar
    Auteur : Ania Marostica
    Date : 06.03.2023
 -->
<?php
require("../model/BDD.php");
require("./navbarFooter.php");

$submit = filter_input(INPUT_POST, 'connexion');
$erreur = [];

if (isset($_POST['inscription'])) {
    header("location:inscription.php");
    exit;
}

if ($submit == "Connexion") {

    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'MotDePasse');

    /* Il vérifie si l'e-mail et le mot de passe ne sont pas vides. */
    if ($email != "" && $password != "") {


        if (getIdUserByEmail($email)) {

            $_SESSION['IdUtilisateur'] = getIdUserByEmail($email);

            foreach ($_SESSION['IdUtilisateur'] as $idUser) {
                $utilisateur = GetInfoUsersById($idUser['IdUtilisateur']);
            }

            /* Vérification du mot de passe. */
            if (password_verify($password, $utilisateur['MotDePasse'])) {
                if ($email == EMAIL_ADMIN && $password == MDP_ADMIN) {
                    $_SESSION['connexionAdmin'] = true;

                    $_SESSION['connexion'] = false;
                    header("location:index.php");
                    exit;
                } else {
                    $_SESSION['connexion'] = true;
                    $_SESSION['connexionAdmin'] = false;
                    header("location:index.php");
                    exit;
                }
            } else {
                $_SESSION['connexionAdmin'] = false;
                $_SESSION['connexion'] = false;
                $erreur[] = "Mot de passe incorrect. ";
            }
        } else {
            $erreur[] = "Email incorrect. ";
        }
    } else {
        $erreur[] = "Saisissez votre email et mot de passe.";
    }
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
    <script src="https://kit.fontawesome.com/865258096d.js" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>

<body>
    <div>
        <div class="card-body p-4 p-md-5 ">
            <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Connexion
            </h2>
            <form method="POST" class="px-md-2" style="margin:50px 150px">

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="email">Votre email :</label>
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="email">Votre mot de passe :</label>
                        <input type="password" name="MotDePasse" id="password" placeholder="Mot de passe"
                            class="form-control">
                    </div>
                </div>
                <div class="form-outline mb-4 d-flex justify-content-center align-items-center">
                    <input type="submit" name="connexion" id="Connexion" value="Connexion"
                        class="col-8 btn btn-primary">
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <p>Ou</p>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <input type="submit" name="inscription" id="Inscription" value="Inscription"
                        class="btn btn-primary col-6">
                </div>
            </form>
        </div>
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
        ?>
    </div>
</body>

</html>