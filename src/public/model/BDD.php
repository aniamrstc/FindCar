<?php

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
function SelectAllVehiculeAvailable($dateDepart,$dateRetour){
    
        $myDb=getConnexion();
        $sql=$myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation from Vehicules where IdVehicule NOT IN (SELECT IdVehicule FROM Reservation WHERE DateDebut=? AND DateFin=?)");
        $sql->execute([$dateDepart,$dateRetour]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);  
}

function SelectVehiculeWhereLocation($location){

    $myDb=GetConnexion();
    $sql=$myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation WHERE IdLocalisation=? ");
    $sql->execute([$location]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);

}


?>