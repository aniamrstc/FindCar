<!-- 
    Projet : FindCar
    Auteur : Liliana Santos
    Date : 06.03.2023
 -->
 <?php
session_start();
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', 0);
}
if (session_destroy()) {

    header("Location:index.php");
}
?>