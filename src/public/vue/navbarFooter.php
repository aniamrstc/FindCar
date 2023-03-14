<!-- 
    Projet : FindCar
    Auteur : Ania Marostica, Liliana Santos
    Date : 20.02.2023
 -->
<?php
session_start();

if (isset($_SESSION['connexion'])) {
    $connexion = $_SESSION['connexion'];
}
if (isset($_SESSION['connexionAdmin'])) {
    $connexionAdmin = $_SESSION['connexionAdmin'];
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
<style>
    .fa-solid {
        color: #9B95BF;
    }
</style>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="./index.php">
                <img src="../../assets/images/LogoMiniNom-removebg-preview.png" alt="" width="150" height="50">
            </a>
            <?php
            if (isset($connexion) && isset($connexionAdmin)) {
                if ($connexion == true && $connexionAdmin == false) { ?>
                    <a class="d-flex" href="./deconnexion.php">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                <?php } elseif ($connexion == false && $connexionAdmin == true) { ?>
                    <div class="d-flex">
                        <a class="mx-3" href="./gestionVehicules.php">
                            <i class="fa-solid fa-car-side"></i>
                        </a>
                        <a class="mx-3" href="./gestionUtilisateurs.php">
                            <i class="fa-solid fa-users"></i>
                        </a>
                        <a class="mx-3" href="./deconnexion.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </div>

                <?php }
            } else { ?>
                <a class="d-flex" href="./connexion.php">
                    <i class="fa-solid fa-user"></i>
                </a>
            <?php } ?>
        </div>
    </nav>

    <footer class="text-center text-white fixed-bottom bg-dark">

        <div class="container p-4">
            <img src="../../assets/images/LogoMiniNom-removebg-preview.png" width="150" height="50">
        </div>
        <section class="mb-4">
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                    class="fab fa-facebook-f"></i></a>

            <!-- Twitter -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

            <!-- Google -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                    class="fab fa-instagram"></i></a>

            <!-- Linkedin -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                    class="fab fa-linkedin-in"></i></a>

            <!-- Github -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
        </section>
        <div class="text-center p-3 bg-dark">
            © 2020 Copyright:
            <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
        </div>
    </footer>
</body>

</html>