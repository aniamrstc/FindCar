<?php
require("../model/BDD.php");
session_start();
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password2 = filter_input(INPUT_POST, 'Retypepassword', FILTER_SANITIZE_SPECIAL_CHARS);
$numPermis = filter_input(INPUT_POST, 'numPermis', FILTER_SANITIZE_SPECIAL_CHARS);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$inscription = filter_input(INPUT_POST, 'inscription', FILTER_SANITIZE_SPECIAL_CHARS);
$connexion = filter_input(INPUT_POST, 'connexion', FILTER_SANITIZE_SPECIAL_CHARS);
$messageError = "";
$userExists = userExists($email);

if (isset($connexion)) {
    header("location:connexion.php");
}

if (isset($inscription)) {
    if ($email != "" && $password != "" && $password2 != "" && $numPermis != "" && $date != "") {
        if ($password == $password2) {
            if ($userExists['email_exists'] === 1) {
                $messageError = "Cette adresse mail est déjà utilisée.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                newUser($email, $passwordHash, $numPermis, $date);
                $_SESSION['IdUtilisateur'] = getIdUserByEmail($email);
            }
        }
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
    <script src="../../assets/js/showMyPassword.js"></script>
    <title>Inscription</title>
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
    <div>
        <div class="card-body p-4 p-md-5">
            <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Inscription
            </h2>
            <form method="POST" class="px-md-2 " style="margin:50px 150px">

                <div class="form-outline mb-4">
                    <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">

                        <input type="password" name="password" id="password" placeholder="Mot de passe"
                            class="form-control">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="password" name="Retypepassword" id="Retypepassword" placeholder=" Confirmer le mot de passe" class="form-control">
                    </div>
                    <label for="showPassWord" id="showMyPassword">
                        <input type="checkbox" name="showMyPassword" id="showMyPassword" onclick="ShowMyPassword()">
                        <span class="ml-2">Afficher le mot de passe</span>
                    </label>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 mb-4">
                        <input type="text" name="numPermis" id="numPermis" placeholder="Numéro de permis"
                            class="form-control">
                    </div>
                    <div class="col-md-6 mb-4">
                        <input type="date" name="date" id="date" placeholder="Date de naissance " class="form-control">
                    </div>
                </div>
                <div class="form-outline mb-4 d-flex justify-content-center align-items-center">
                    <input type="submit" name="inscription" id="inscription" value="Inscription"
                        class="col-8 btn btn-primary">
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <p>Ou</p>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <input type="submit" name="connexion" id="connexion" value="Connexion"
                        class="btn btn-primary col-6">
                </div>
            </form>
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