<!-- 
    Projet : FindCar
    Auteur : Liliana Santos
    Date : 06.03.2023
 -->
 <?php
 /* Inclus les fichiers BDD.php et navbarFooter.php */
require("../model/BDD.php");
require("./navbarFooter.php");

/* Filtrage de l'entrée de l'utilisateur. */
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password2 = filter_input(INPUT_POST, 'Retypepassword', FILTER_SANITIZE_SPECIAL_CHARS);
$numPermis = filter_input(INPUT_POST, 'numPermis', FILTER_SANITIZE_SPECIAL_CHARS);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$inscription = filter_input(INPUT_POST, 'inscription', FILTER_SANITIZE_SPECIAL_CHARS);
$connexion = filter_input(INPUT_POST, 'connexion', FILTER_SANITIZE_SPECIAL_CHARS);

/* Stocker la date de aujord'hui */
$dateActuelle = new DateTime();

/* stocker la date inserer par l'utilisateur . */
$dateNaissance = new DateTime($date);

/* Calcul de l'âge de l'utilisateur. */
$age = $dateActuelle->diff($dateNaissance)->y;

/* Initialisation de la variable. */
$messageError = "";

/* Vérifier si l'e-mail est déjà dans la base de données. */
$userExists = userExists($email);

/* Vérifier si l'utilisateur a cliqué sur le bouton "connexion" et si oui, il redirige l'utilisateur
vers la page de connexion. */
if (isset($connexion)) {
    header("location:connexion.php");
}

if (isset($inscription)) {
    /* Vérifier si l'email, le mot de passe, le mot de passe2, numPermis et la date ne sont pas vides. */
    if ($email != "" && $password != "" && $password2 != "" && $numPermis != "" && $date != "") {
        /* Vérifier si le mot de passe et le mot de passe retapé sont identiques. */
        if ($password == $password2) {

            /* Vérifier si l'e-mail existe dans la base de données. */
            if ($userExists['email_exists'] === 1) {
          
                $messageError .= nl2br("Cette adresse mail est déjà utilisée. \n");
            } else {

               /* Hachage du mot de passe. */
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                
                /* Vérifier si l'utilisateur a plus de 18 ans. */
                if ($age >= 18) {
                   /* Insertion de l'utilisateur dans la base de données. */
                    newUser($email, $passwordHash, $numPermis, $date);
                    $_SESSION['IdUtilisateur'] = getIdUserByEmail($email);
                    header("location: connexion.php");
                } else {
                    $messageError .= nl2br("Vous devez etre majeur pour vous inscrire \n");
                }

            }
        } else {
            $messageError .= nl2br("Les mots de passe ne sont pas compatibles \n");
        }
    }

    /* Vérifier si l'utilisateur a saisi les informations requises. */
    if (empty($email)) {
        $messageError .= nl2br("Veuillez indiquer votre email \n");
    }
    if (empty($password)) {
        $messageError .= nl2br("Veuillez indiquer votre mot de passe \n");
    }
    if (empty($password2)) {
        $messageError .= nl2br("Veuillez confirmer votre mot de passe \n");
    }
    if (empty($numPermis)) {
        $messageError .= nl2br("Veuillez indiquer votre numero de permis \n");
    }
    if (empty($date)) {
        $messageError .= nl2br("Veuillez indiquer votre date de naissance \n");
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

    <div>
        <div class="card-body p-4 p-md-5">
            <h2 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2 d-flex justify-content-center align-items-center">Inscription
            </h2>
            <form method="POST" class="px-md-2 " style="margin:50px 150px">

                <div class="form-outline mb-4">
                    <label for="email">Votre email :</label>
                    <input type="text" name="email" id="email" placeholder="Email" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="password">Votre mot de passe :</label>
                        <input type="password" name="password" id="password" placeholder="8 caractères min."
                            class="form-control" minlength="8">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="Retypepassword">Confirmer le mot de passe :</label>
                        <input type="password" name="Retypepassword" id="Retypepassword" placeholder="8 caractères min."
                            class="form-control" minlength="8">
                    </div>
                    <div for="showPassWord" id="showMyPassword" class="d-flex justify-content-end">
                        <input type="checkbox" name="showMyPassword" id="showMyPassword" onclick="ShowMyPassword()"
                            style="margin-right: 5px;">
                        <span class="ml-2">Afficher le mot de passe</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 mb-4">
                        <label for="Retypepassword">Numéro du permis :</label>
                        <input type="text" name="numPermis" id="numPermis" placeholder="Numéro de permis"
                            class="form-control">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="Retypepassword">Date de naissance :</label>
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

        <?php
        if (!empty($messageError)) {
            if ($messageError != 0) { ?>
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="alert alert-danger w-50 mt-3 col-12 text-center" role="alert">
                        <?= $messageError ?>
                    </div>
                </div>
            <?php }
        }
        ?>

    </div>
</body>

</html>