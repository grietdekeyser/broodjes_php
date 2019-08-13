<?php

//Data/GebruikerDAO.php

namespace Data;

use Data\DBConfig;
use \PDO;
use Entities\Gebruiker;
use Exceptions\EmailExistsException;
require_once("DBConfig.php");
require_once("Entities/Gebruiker.php");


class GebruikerDAO {
    public function getAll() : array {
        $sql = "select id, voornaam, familienaam, email, wachtwoord from gebruikers";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);

        $lijst = [];
        foreach ($resultSet as $rij) {
            $gebruiker = Gebruiker::create($rij["id"], $rij["voornaam"], $rij["familienaam"], $rij["email"], $rij["wachtwoord"]);
            array_push($lijst, $gebruiker);
        }
        $dbh = null;
        return $lijst;
    }
    
    public function getById(int $id) {
        $sql = "select id, voornaam, familienaam, email, wachtwoord from gebruikers where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':id' => $id
        ));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($rij) {
            $gebruiker = Gebruiker::create($id, $rij["voornaam"], $rij["familienaam"], $rij["email"], $rij["wachtwoord"]);
        }
        else {
            $gebruiker = null;
        }
        $dbh = null;
        return $gebruiker;
    }

    public function getByEmail(string $email) {
        $sql = "select id, voornaam, familienaam, email, wachtwoord from gebruikers where email = :email";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':email' => $email
        ));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($rij) {
            $gebruiker = Gebruiker::create($rij["id"], $rij["voornaam"], $rij["familienaam"], $email, $rij["wachtwoord"]);
        }
        else {
            $gebruiker = null;
        }
        $dbh = null;
        return $gebruiker;
    }
    
    public function create(string $voornaam, string $familienaam, string $email, string $wachtwoord) {
        //controle of er reeds gebruiker is met dit e-mailadres
        $bestaandeGebruiker = $this->getByEmail($email);
        if (!is_null($bestaandeGebruiker)) {
            throw new EmailExistsException;
        }        
        
        $sql = "insert into gebruikers (voornaam, familienaam, email, wachtwoord) values (:voornaam, :familienaam, :email, :wachtwoord)";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':voornaam' => $voornaam,
            ':familienaam' => $familienaam,
            ':email' => $email,
            ':wachtwoord' => $wachtwoord
        ));
          
        $id = $dbh->lastInsertId();
        $gebruiker = Gebruiker::create($id, $voornaam, $familienaam, $email, $wachtwoord);
        $dbh = null;
        return $gebruiker;
    }
    
    //wachtwoord wijzigen
    public function updateWachtwoord(string $wachtwoord, int $id) {
        $sql = "update gebruikers set wachtwoord = :wachtwoord where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':wachtwoord' => $wachtwoord,
            ':id' => $id
        ));
        $dbh = null;
    }
}