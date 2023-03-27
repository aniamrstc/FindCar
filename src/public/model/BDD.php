<!-- 
    Projet : FindCar
    Auteur : Ania Marostica, Liliana Santos
    Date : 20.02.2023
 -->
 <?php

require_once "Constantes.php";

/**
 * Si la connexion à la base de données n'est pas déjà établie, établissez-la et renvoyez-la, sinon
 * renvoyez simplement la connexion déjà établie.
 */
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


/**
 * Renvoie tous les véhicules selon les filtres selectionner.
 */
function GetVehiculeByFiltre($type, $location, $dateDepart, $dateRetour)
{

    $myDb = getConnexion();
    $sql = "SELECT IdVehicule, nomVehicule, prixJour, Statut, imageVoiture, Vehicules.IdNbPlaces, Vehicules.IdTransmission, Vehicules.IdCarburant, Vehicules.IdNbPortes, Vehicules.IdMarque, IdLocalisation, IdType,Transmission.typeTransmission,Places.nbPlace, Portes.NbPorte,Marques.Marque,Carburant.typeCarburant FROM Vehicules,Portes,Places,Transmission,Marques,Carburant WHERE Vehicules.IdNbPlaces =Places.IdNbPlaces AND Vehicules.IdTransmission = Transmission.IdTransmission AND Vehicules.IdNbPortes=Portes.IdNbPorte AND Vehicules.IdMarque=Marques.IdMarque AND Vehicules.IdCarburant=Carburant.IdCarburant";

    if (!empty($type)) {
        $sql .= " AND IdType='$type'";
    }
    if (!empty($location)) {
        $sql .= " AND IdLocalisation='$location'";
    }
    if (!empty($dateDepart && $dateRetour)) {
        $sql .= " AND IdVehicule NOT IN (SELECT IdVehicule FROM Reservation WHERE DateDebut='$dateDepart' AND DateFin='$dateRetour')";
    }
    $stmt = $myDb->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtient tous les utilisateurs de la base de données.
 */
function GetUSers()
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdUtilisateur,Email,MotDePasse,NbPermis,Date,Actif,Admin FROM Utilisateurs ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Renvoie les utilisateurs à partir de son id.
 */
function GetInfoUsersById($idUser)
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdUtilisateur,Email,MotDePasse,NbPermis,Date,Actif,Admin FROM Utilisateurs WHERE IdUtilisateur=?");
    $sql->execute([$idUser]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

/**
 * Recupere les localisations de la base de données.
 */
function getInfoLocation()
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdLocalisation,Nom FROM Localisation ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recupere les types de voiture de la base de données.
 */
function getInfoType()
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdType,Type FROM TypeVehicule");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Créer un utilisateur avec les paramètres 
 */
function newUser($email, $password, $nPermis, $date)
{
    $query = getConnexion()->prepare("
    INSERT INTO `Utilisateurs`(`email`, `MotDePasse`, `NbPermis`, `Date`, `Actif`, `Admin`) 
    VALUES ( ?, ?, ?, ?,'Actif', false);");
    $query->execute([$email, $password, $nPermis, $date]);
}

/**
 * Renvoie une valeur booléenne indiquant si l'adresse e-mail existe ou non dans la base de données.
 */

function userExists($email)
{
    $query = getConnexion()->prepare("
            SELECT EXISTS( SELECT `email` FROM `Utilisateurs` WHERE `email` = ?) AS email_exists;
        ");
    $query->execute([$email]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Renvoie l'identifiant de l'utilisateur avec l'e-mail donné.
 */
function getIdUserByEmail($email)
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdUtilisateur FROM Utilisateurs WHERE Email=?");
    $sql->execute([$email]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recupere le carburant de la base de données.
 */
function getCarburant()
{

    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdCarburant,typeCarburant FROM Carburant");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtient la transmission de la base de données.
 */
function getTransmission()
{

    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdTransmission,typeTransmission FROM Transmission");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recupere les voitures selon le nom 
 */
function searchCar($carName)
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation,IdType,imageVoiture FROM Vehicules WHERE nomVehicule LIKE '$carName%'");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtient tous les véhicules de la base de données.
 */
function getAllVehicule()
{

    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdVehicule,nomVehicule,prixJour,Statut,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation,IdType,imageVoiture FROM Vehicules ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Insère un nouveau véhicule dans la base de données.
 */
function newVehicule($nom,$prix,$image,$nbPlace,$transmission,$carburant,$nbPorte,$marque,$location,$type){
    $myDb = getConnexion();
    $sql = $myDb->prepare("INSERT INTO Vehicules (nomVehicule,prixJour,Statut,imageVoiture,IdNbPlaces,IdTransmission,IdCarburant,IdNbPortes,IdMarque,IdLocalisation,IdType) VALUES(?,?,1,?,?,?,?,?,?,?,?)");
    $sql->execute([$nom,$prix,$image,$nbPlace,$transmission,$carburant,$nbPorte,$marque,$location,$type]);
    return true;
}

/**
 * Filtre de la page sélection.
 */
function filterPageSelection($localisation,$carburant, $prixJour, $transmission)
{
    $myDb = getConnexion();
    $sql = "SELECT `IdVehicule`, `nomVehicule`, `prixJour`, `Statut`, `imageVoiture`, `Vehicules`.`IdNbPlaces`, `Vehicules`.`IdTransmission`, `Vehicules`.`IdCarburant`, 
    `Vehicules`.`IdNbPortes`,`Vehicules`.`IdMarque`, `Vehicules`.`IdLocalisation`, `IdType`, `Transmission`.`typeTransmission`,`Carburant`.`typeCarburant`,`Places`.`nbPlace`,
    `Portes`.`NbPorte`,`Marques`.`Marque`, `Localisation`.`Nom`
    FROM `Vehicules`, `Transmission`,`Carburant`,`Portes`,`Places`,`Marques`,`Localisation`
    WHERE `Vehicules`.`IdNbPlaces` = `Places`.`IdNbPlaces`
    AND `Vehicules`.`IdTransmission` = `Transmission`.`IdTransmission` 
    AND `Vehicules`.`IdNbPortes` = `Portes`.`IdNbPorte`
    AND `Vehicules`.`IdMarque` = `Marques`.`IdMarque` 
    AND `Vehicules`.`IdCarburant` = `Carburant`.`IdCarburant`
    AND `Vehicules`.`IdLocalisation` = `Localisation`.`IdLocalisation`
    AND `Localisation`.`IdLocalisation` = $localisation";
   

    if (!empty($carburant)) {
        $sql .= " AND `typeCarburant`='$carburant'";
    }
    if (!empty($prixJour)) {
        $sql .= " AND `prixJour` = '$prixJour'";
    }
    if (!empty($transmission)) {
        $sql .= " AND `typeTransmission` = '$transmission'";
    }

    $stmt = $myDb->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recupere les utilisateurs selon le nom d'utilisateur
 */
function searchUtilisateur($user)
{
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT `IdUtilisateur`, `Email`, `MotDePasse`, `NbPermis`, `Date`, `Actif`, `Admin` FROM `Utilisateurs` WHERE `Email` LIKE '$user%'");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Supprime un utilisateur de la base de données.
 */
function deleteUtilisateur($idUser)
{
    try {
        $myDb = getConnexion();
        $sql = $myDb->prepare("DELETE FROM `Utilisateurs` WHERE `IdUtilisateur`= ?");
        $sql->execute([$idUser]);
    } catch (Exception $e) {
        echo 'Exception reçue : ', $e->getMessage(), "\n";
    }
}

/**
 * Met à jour le statut d'un utilisateur dans la base de données.
 */
function updateStatus($status, $idUser)
{
    try {
        $myDb = getConnexion();
        $sql = $myDb->prepare("UPDATE `Utilisateurs` 
            SET `Actif`= ?
            WHERE `IdUtilisateur` = ?
            ");
        $sql->execute([$status, $idUser]);
    } catch (Exception $e) {
        echo 'Exception reçue : ', $e->getMessage(), "\n";
    }
}
/**
 * Recupere les nombre des portes du véhicule
 */
function getNbPorte(){
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdNbPorte,NbPorte FROM Portes ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtient le nombre de places.
 */
function getNbplaces(){
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdNbPlaces,nbPlace FROM Places ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtient les marques de voitures.
 */
function getMarque(){
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdMarque,Marque FROM Marques ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Supprime un véhicule selon son id
 */
function deleteVehicule($IdVehicule){
    $myDb=getConnexion();
    $sql = $myDb->prepare("DELETE FROM Vehicules WHERE IdVehicule=? ");
    $sql->execute([$IdVehicule]);
}

/**
 * Renvoie véhicule selon le id
 */
function getVehiculeById($IdVehicule){
    $myDb = getConnexion();
    $sql = $myDb->prepare("SELECT IdVehicule, nomVehicule, prixJour, Statut, imageVoiture, Vehicules.IdNbPlaces, Vehicules.IdTransmission, Vehicules.IdCarburant, Vehicules.IdNbPortes, Vehicules.IdMarque, Vehicules.IdLocalisation, TypeVehicule.IdType,Transmission.typeTransmission,Places.nbPlace, Portes.NbPorte,Marques.Marque,Carburant.typeCarburant,Localisation.Nom,TypeVehicule.Type FROM Vehicules,Portes,Places,Transmission,Marques,Carburant,Localisation,TypeVehicule WHERE Vehicules.IdNbPlaces =Places.IdNbPlaces AND Vehicules.IdTransmission = Transmission.IdTransmission AND Vehicules.IdNbPortes=Portes.IdNbPorte AND Vehicules.IdMarque=Marques.IdMarque AND Vehicules.IdCarburant=Carburant.IdCarburant AND Vehicules.IdVehicule=? AND Vehicules.IdLocalisation=Localisation.IdLocalisation AND Vehicules.IdType=TypeVehicule.IdType");
    $sql->execute([$IdVehicule]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Il met à jour un véhicule.
 */
function updateVehicule($nom,$prix,$nbPlace,$transmission,$carburant,$nbPorte,$marque,$location,$type,$idVehicule){
    $myDb = getConnexion();
    $sql=$myDb->prepare("UPDATE Vehicules set nomVehicule=?,prixJour=?,IdNbPlaces=?,IdTransmission=?,IdCarburant=?,IdNbPortes=?,IdMarque=?,IdLocalisation=?,IdType=? WHERE IdVehicule=?");
    $sql->execute([$nom,$prix,$nbPlace,$transmission,$carburant,$nbPorte,$marque,$location,$type,$idVehicule]);
    return true;
}
