<?php

require_once "Constantes.php";

function getConnexion()
{
    static $myDb = null;

    if ($myDb === null) {
        try {
            $myDb = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $myDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $myDb->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die("Erreur :" . $e->getMessage());
        }
    }
    return $myDb;
}
function GetAllVehiculeAvailable($dateDepart, $dateRetour)
{

    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation,IdType FROM Vehicules WHERE IdVehicule NOT IN (SELECT IdVehicule FROM Reservation WHERE DateDebut=? AND DateFin=?)");
    $sql->execute([$dateDepart, $dateRetour]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function GetVehiculeAccordingLocation($location)
{

    $myDb = GetConnexion();
    $sql = $myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation,IdType FROM Vehicules WHERE IdLocalisation=? ");
    $sql->execute([$location]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);

}
function FilterVehiculeByType($type)
{
    $myDb = GetConnexion();
    $sql = $myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation,IdType FROM Vehicules WHERE IdType=?");
    $sql->execute([$type]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

function GetUSers(){
    $myDb=getConnexion();
    $sql=$myDb->prepare("SELECT IdUtilisateur,Email,MotDePasse,NbPermis,Date,Actif,Admin FROM Utilisateurs ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);

}

function GetInfoUsersById($idUser){
    $myDb = getConnexion();
    $sql=$myDb->prepare("SELECT IdUtilisateur,Email,MotDePasse,NbPermis,Date,Actif,Admin FROM Utilisateurs WHERE IdUtilisateur=?");
    $sql->execute([$idUser]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}
function getInfoLocation(){
    $myDb=getConnexion();
    $sql=$myDb->prepare("SELECT IdLocalisation,Nom FROM Localisation ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
function getInfoType(){
    $myDb=getConnexion();
    $sql=$myDb->prepare("SELECT IdType,Type FROM TypeVehicule");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Il prend quatre paramètres, et les insère dans une table appelée Utilisateurs.
 */
function newUser($email, $password, $nPermis, $date)
{
    $query = getConnexion()->prepare("
    INSERT INTO `Utilisateurs`(`email`, `MotDePasse`, `NbPermis`, `Date`, `Actif`, `Admin`) 
    VALUES ( ?, ?, ?, ?,'Actif', false);");
    $query->execute([$email, $password, $nPermis, $date]);

}

/**
 * Il renvoie une valeur booléenne indiquant si l'adresse e-mail existe ou non dans la base de données.
 */

function userExists($email)
{
    $query = getConnexion()->prepare("
            SELECT EXISTS( SELECT `email` FROM `Utilisateurs` WHERE `email` = ?) AS email_exists;
        ");
    $query->execute([$email]);
    return $query->fetch(PDO::FETCH_ASSOC);

}
function getIdUserByEmail($email){
    $myDb=getConnexion();
    $sql=$myDb->prepare("SELECT IdUtilisateur FROM Utilisateurs WHERE Email=?");
    $sql->execute([$email]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}
