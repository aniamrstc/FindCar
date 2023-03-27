<!-- 
    Projet : FindCar
    Auteur : Liliana Santos
    Date : 06.03.2023
 -->
 <?php

/* Il démarre une nouvelle session ou en reprend une existante. */
session_start();

/* Vérifier si la session utilise des cookies. Si c'est le cas, il mettra le cookie à 0. */
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', 0);
}

/* Il détruit la session et redirige l'utilisateur vers la page d'index. */
if (session_destroy()) {

    header("Location:index.php");
}
?>